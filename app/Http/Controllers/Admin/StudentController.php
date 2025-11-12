<?php

namespace App\Http\Controllers\Admin;



use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{

    public function index(Request $request)
    {
        $query = Student::query();

        // optional filters
        if ($request->filled('search')) {
            $q = $request->input('search');
            $query->where(fn($s) =>
                $s->where('name', 'like', "%{$q}%")
                  ->orWhere('roll_number', 'like', "%{$q}%")
                  ->orWhere('email', 'like', "%{$q}%")
            );
        }

        if ($request->filled('classroom_id')) {
            $query->where('classroom_id', $request->classroom_id);
        }

        $students = $query->latest()->paginate(15)->withQueryString();
        $classrooms = Classroom::orderBy('name')->get();

        return view('admin.students.index', compact('students', 'classrooms'));
    }

    public function create()
    {
        $classrooms = Classroom::orderBy('name')->get();
        return view('admin.students.create', compact('classrooms'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['nullable','email','max:255','unique:students,email','unique:users,email'],
            'roll_number' => [
                        'nullable', 'string', 'max:50',
                        Rule::unique('students', 'roll_number')
                            ->where(fn($q) => $q->where('classroom_id', $request->classroom_id))
                    ],           
             'classroom_id' => ['nullable','exists:classrooms,id'],
            'phone' => ['nullable','string','max:30'],
            'gender' => ['nullable', Rule::in(['male','female','other'])],
            'date_of_birth' => ['nullable','date'],
            'guardian_name' => ['nullable','string','max:255'],
            'address' => ['nullable','string'],
            'photo' => ['nullable','image','max:2048'],
            'password' => ['nullable','string','min:8'],
        ]);

        // Create user account for the student if email is provided (this will auto-create student record via User model boot)
        $user = null;
        $password = null;
        if ($request->email) {
            $password = $request->password ?? Str::random(12);
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($password),
                'role' => 'student',
            ]);
            
            // Get the auto-created student record and update it with additional details
            $student = $user->student;
            if ($student) {
                $student->roll_number = $data['roll_number'] ?? null;
                $student->classroom_id = $data['classroom_id'] ?? null;
                $student->phone = $data['phone'] ?? null;
                $student->gender = $data['gender'] ?? null;
                $student->date_of_birth = $data['date_of_birth'] ?? null;
                $student->guardian_name = $data['guardian_name'] ?? null;
                $student->address = $data['address'] ?? null;

                if ($request->hasFile('photo')) {
                    $path = $request->file('photo')->store('students', 'public');
                    $student->photo_path = $path;
                }

                $student->save();
            }
        } else {
            // If no email, create student without user account
            // handle photo upload
            if ($request->hasFile('photo')) {
                $path = $request->file('photo')->store('students', 'public');
                $data['photo_path'] = $path;
            }

            Student::create($data);
        }

        $message = 'Student created.';
        if ($user && !$request->password && $password) {
            $message .= ' Default password: ' . $password;
        }

        return redirect()->route('admin.students.index')->with('success', $message);
    }

    public function show(Student $student)
    {
        return view('admin.students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $classrooms = Classroom::orderBy('name')->get();
        return view('admin.students.edit', compact('student','classrooms'));
    }

    public function update(Request $request, Student $student)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['nullable','email','max:255', 
                Rule::unique('students','email')->ignore($student->id),
                Rule::unique('users','email')->ignore($student->user_id ?? 'NULL')
            ],
            'roll_number' => [
                        'nullable', 'string', 'max:50',
                        Rule::unique('students', 'roll_number')
                            ->ignore($student->id)
                            ->where(fn($q) => $q->where('classroom_id', $request->classroom_id))
                    ],            
            'classroom_id' => ['nullable','exists:classrooms,id'],
            'phone' => ['nullable','string','max:30'],
            'gender' => ['nullable', Rule::in(['male','female','other'])],
            'date_of_birth' => ['nullable','date'],
            'guardian_name' => ['nullable','string','max:255'],
            'address' => ['nullable','string'],
            'photo' => ['nullable','image','max:2048'],
            'password' => ['nullable','string','min:8'],
        ]);

        // Update or create user account if email is provided
        if ($request->email) {
            if ($student->user_id) {
                $user = User::find($student->user_id);
                if ($user) {
                    $user->name = $request->name;
                    $user->email = $request->email;
                    if ($request->password) {
                        $user->password = Hash::make($request->password);
                    }
                    $user->save();
                }
            } else {
                // Create user if doesn't exist
                $password = $request->password ?? Str::random(12);
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($password),
                    'role' => 'student',
                ]);
                $data['user_id'] = $user->id;
            }
        }

        if ($request->hasFile('photo')) {
            // delete old
            if ($student->photo_path) {
                Storage::disk('public')->delete($student->photo_path);
            }
            $path = $request->file('photo')->store('students', 'public');
            $data['photo_path'] = $path;
        }

        $student->update($data);

        return redirect()->route('admin.students.index')->with('success', 'Student updated.');
    }

    public function destroy(Student $student)
    {
        // Delete photo if exists
        if ($student->photo_path) {
            Storage::disk('public')->delete($student->photo_path);
        }

        // Delete associated user if exists (this will cascade delete the student)
        if ($student->user_id) {
            $user = User::find($student->user_id);
            if ($user && $user->role === 'student') {
                $user->delete(); // This will cascade delete the student due to foreign key
                return redirect()->route('admin.students.index')->with('success', 'Student deleted.');
            }
        }

        // If no user associated, just delete the student
        $student->delete();

        return redirect()->route('admin.students.index')->with('success', 'Student deleted.');
    }
}

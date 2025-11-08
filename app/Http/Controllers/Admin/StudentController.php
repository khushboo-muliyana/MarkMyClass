<?php

namespace App\Http\Controllers\Admin;



use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
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
            'email' => ['nullable','email','max:255','unique:students,email'],
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
        ]);

        // handle photo upload
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('students', 'public');
            $data['photo_path'] = $path;
        }

        Student::create($data);

        return redirect()->route('admin.students.index')->with('success', 'Student created.');
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
            'email' => ['nullable','email','max:255', Rule::unique('students','email')->ignore($student->id)],
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
        ]);

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
        if ($student->photo_path) {
            Storage::disk('public')->delete($student->photo_path);
        }
        $student->delete();

        return redirect()->route('admin.students.index')->with('success', 'Student deleted.');
    }
}

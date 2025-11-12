<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()->with(['teacher.classroom', 'student.classroom']);

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($role = $request->input('role')) {
            $query->where('role', $role);
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        $classrooms = Classroom::orderBy('name')->get();

        return view('admin.users.edit', [
            'user' => $user->loadMissing(['teacher', 'student']),
            'classrooms' => $classrooms,
        ]);
    }

    public function update(Request $request, User $user)
    {
        $rollNumberRule = Rule::unique('students', 'roll_number')
            ->where(fn ($q) => $q->where('classroom_id', $request->student_classroom_id));

        if ($user->student) {
            $rollNumberRule->ignore($user->student->id);
        }

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'role' => ['required', Rule::in(['admin', 'teacher', 'student'])],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ];

        $rules += [
            'teacher_phone' => ['nullable', 'string', 'max:20'],
            'teacher_gender' => ['nullable', Rule::in(['male', 'female', 'other'])],
            'teacher_qualification' => ['nullable', 'string', 'max:255'],
            'teacher_join_date' => ['nullable', 'date'],
            'teacher_classroom_id' => ['nullable', 'exists:classrooms,id'],
            'teacher_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ];

        $rules += [
            'student_roll_number' => ['nullable', 'string', 'max:50', $rollNumberRule],
            'student_classroom_id' => ['nullable', 'exists:classrooms,id'],
            'student_phone' => ['nullable', 'string', 'max:30'],
            'student_gender' => ['nullable', Rule::in(['male', 'female', 'other'])],
            'student_date_of_birth' => ['nullable', 'date'],
            'student_guardian_name' => ['nullable', 'string', 'max:255'],
            'student_address' => ['nullable', 'string'],
            'student_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ];

        $validated = $request->validate($rules);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();
        $user->refresh();

        if ($user->role === 'teacher') {
            $teacher = $user->teacher ?? Teacher::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]);

            $teacher->name = $user->name;
            $teacher->email = $user->email;
            $teacher->phone = $validated['teacher_phone'] ?? null;
            $teacher->gender = $validated['teacher_gender'] ?? null;
            $teacher->qualification = $validated['teacher_qualification'] ?? null;
            $teacher->join_date = $validated['teacher_join_date'] ?? null;
            $teacher->classroom_id = $validated['teacher_classroom_id'] ?? null;

            if ($request->hasFile('teacher_photo')) {
                if ($teacher->photo_path) {
                    Storage::disk('public')->delete($teacher->photo_path);
                }
                $teacher->photo_path = $request->file('teacher_photo')->store('teachers', 'public');
            }

            $teacher->save();
        } elseif ($user->role === 'student') {
            $student = $user->student ?? Student::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]);

            $student->name = $user->name;
            $student->email = $user->email;
            $student->roll_number = $validated['student_roll_number'] ?? null;
            $student->classroom_id = $validated['student_classroom_id'] ?? null;
            $student->phone = $validated['student_phone'] ?? null;
            $student->gender = $validated['student_gender'] ?? null;
            $student->date_of_birth = $validated['student_date_of_birth'] ?? null;
            $student->guardian_name = $validated['student_guardian_name'] ?? null;
            $student->address = $validated['student_address'] ?? null;

            if ($request->hasFile('student_photo')) {
                if ($student->photo_path) {
                    Storage::disk('public')->delete($student->photo_path);
                }
                $student->photo_path = $request->file('student_photo')->store('students', 'public');
            }

            $student->save();
        }

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }
}

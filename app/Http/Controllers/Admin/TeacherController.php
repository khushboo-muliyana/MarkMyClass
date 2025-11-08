<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Classroom;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    /**
     * Display a listing of the teachers.
     */
   public function index(Request $request)
{
    $query = Teacher::with('classroom')->latest();

    // Optional: search filter
    if ($request->search) {
        $query->where('name','like','%'.$request->search.'%')
              ->orWhere('email','like','%'.$request->search.'%')
              ->orWhere('phone','like','%'.$request->search.'%');
    }

    if ($request->classroom_id) {
        $query->where('classroom_id', $request->classroom_id);
    }

    $teachers = $query->paginate(10);
    $classrooms = Classroom::all();

    return view('admin.teachers.index', compact('teachers','classrooms'));
}


    /**
     * Show the form for creating a new teacher.
     */
    public function create()
    {
        $classrooms = Classroom::all();
        return view('admin.teachers.create', compact('classrooms'));
    }

    /**
     * Store a newly created teacher in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:teachers,email',
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|in:male,female,other',
            'qualification' => 'nullable|string|max:255',
            'join_date' => 'nullable|date',
            'classroom_id' => 'nullable|exists:classrooms,id',
            'photo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $teacher = new Teacher();
        $teacher->name = $request->name;
        $teacher->email = $request->email;
        $teacher->phone = $request->phone;
        $teacher->gender = $request->gender;
        $teacher->qualification = $request->qualification;
        $teacher->join_date = $request->join_date;
        $teacher->classroom_id = $request->classroom_id;

        if ($request->hasFile('photo_path')) {
            $path = $request->file('photo_path')->store('teachers', 'public');
            $teacher->photo_path = $path;
        }

        $teacher->save();

        return redirect()->route('admin.teachers.index')
                         ->with('success', 'Teacher created successfully.');
    }

    /**
     * Display the specified teacher.
     */
    public function show(Teacher $teacher)
    {
        return view('admin.teachers.show', compact('teacher'));
    }

    /**
     * Show the form for editing the specified teacher.
     */
    public function edit(Teacher $teacher)
    {
        $classrooms = Classroom::all();
        return view('admin.teachers.edit', compact('teacher', 'classrooms'));
    }

    /**
     * Update the specified teacher in storage.
     */
    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:teachers,email,' . $teacher->id,
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|in:male,female,other',
            'qualification' => 'nullable|string|max:255',
            'join_date' => 'nullable|date',
            'classroom_id' => 'nullable|exists:classrooms,id',
            'photo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $teacher->name = $request->name;
        $teacher->email = $request->email;
        $teacher->phone = $request->phone;
        $teacher->gender = $request->gender;
        $teacher->qualification = $request->qualification;
        $teacher->join_date = $request->join_date;
        $teacher->classroom_id = $request->classroom_id;

        if ($request->hasFile('photo_path')) {
            // Delete old photo if exists
            if ($teacher->photo_path) {
                Storage::disk('public')->delete($teacher->photo_path);
            }
            $path = $request->file('photo_path')->store('teachers', 'public');
            $teacher->photo_path = $path;
        }

        $teacher->save();

        return redirect()->route('admin.teachers.index')
                         ->with('success', 'Teacher updated successfully.');
    }

    /**
     * Remove the specified teacher from storage.
     */
    public function destroy(Teacher $teacher)
    {
        if ($teacher->photo_path) {
            Storage::disk('public')->delete($teacher->photo_path);
        }

        $teacher->delete();

        return redirect()->route('admin.teachers.index')
                         ->with('success', 'Teacher deleted successfully.');
    }
}

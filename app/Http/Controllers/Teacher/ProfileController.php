<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $teacher = Auth::user()->teacher;
        return view('teacher.profile', compact('teacher'));
    }

    public function edit()
    {
        $teacher = Auth::user()->teacher;
        return view('teacher.profile-edit', compact('teacher'));
    }

    public function update(Request $request)
    {
        $teacher = Auth::user()->teacher;

        $request->validate([
            'phone' => 'nullable|string|max:15',
            'gender' => 'nullable|in:male,female,other',
            'qualification' => 'nullable|string|max:255',
            'join_date' => 'nullable|date',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('photo')) {
            if ($teacher->photo_path && Storage::exists('public/' . $teacher->photo_path)) {
                Storage::delete('public/' . $teacher->photo_path);
            }
            $teacher->photo_path = $request->file('photo')->store('teachers', 'public');
        }

        $teacher->update($request->except('photo'));

        return redirect()->route('teacher.profile')->with('success', 'Profile updated successfully!');
    }
}

<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    // Show form to mark attendance
    public function index()
    {
        $teacher = Auth::user();

        // Get students assigned to this teacher
        $students = $teacher->classroom ? $teacher->classroom->students()->get() : collect();

        return view('teacher.attendance.index', compact('students'));
    }

    // Store attendance
    public function store(Request $request)
    {
        $teacher = Auth::user();
        $date = Carbon::today();

        foreach ($request->attendance as $student_id => $status) {
            Attendance::updateOrCreate(
                [
                    'teacher_id' => $teacher->id,
                    'student_id' => $student_id,
                    'date' => $date,
                ],
                [
                    'status' => $status
                ]
            );
        }

        return redirect()->route('teacher.attendance.index')->with('success', 'Attendance marked successfully.');
    }

    // View attendance records
    public function records()
    {
        $teacher = Auth::user();

        $attendances = Attendance::where('teacher_id', $teacher->id)
                        ->with('student')
                        ->orderBy('date', 'desc')
                        ->paginate(20);

        return view('teacher.attendance.records', compact('attendances'));
    }
}

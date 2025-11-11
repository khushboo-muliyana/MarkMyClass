<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TeacherDashboardController extends Controller
{
    public function index()
    {
        $teacher = Auth::user();

        // Total students assigned to this teacher
        $totalStudents = $teacher->classroom ? $teacher->classroom->students()->count() : 0;
        // Attendance today
        $today = Carbon::today();
        $todayAttendance = Attendance::where('teacher_id', $teacher->id)
                                    ->whereDate('date', $today)
                                    ->where('status', 'present')
                                    ->count();

        return view('teacher.dashboard', compact('totalStudents', 'todayAttendance'));
    }
}

@extends('layouts.dashboard')

@section('title', 'Mark Attendance')

@section('sidebar-menu')
    @include('teacher._sidebar')
@endsection

@section('content')
<h2>Mark Attendance</h2>
<p>Fill in the attendance for your class today.</p>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form action="{{ route('teacher.attendance.store') }}" method="POST">
    @csrf
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Student ID</th>
                <th>Name</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
                <tr>
                    <td>{{ $student->student_id }}</td>
                    <td>{{ $student->name }}</td>
                    <td>
                        <select name="attendance[{{ $student->id }}]" class="form-select" required>
                            <option value="">Select</option>
                            <option value="present">Present</option>
                            <option value="absent">Absent</option>
                            <option value="late">Late</option>
                            <option value="leave">Leave</option>
                        </select>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <button type="submit" class="btn btn-primary mt-3">Save Attendance</button>
</form>
@endsection

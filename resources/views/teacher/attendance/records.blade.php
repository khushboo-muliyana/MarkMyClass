@extends('layouts.dashboard')

@section('title', 'Attendance Records')

@section('sidebar-menu')
    @include('teacher._sidebar')
@endsection

@section('content')
<h2>Attendance Records</h2>

<table class="table table-striped mt-3">
    <thead>
        <tr>
            <th>Date</th>
            <th>Student ID</th>
            <th>Name</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($attendances as $attendance)
        <tr>
            <td>{{ $attendance->date->format('d-m-Y') }}</td>
            <td>{{ $attendance->student->student_id }}</td>
            <td>{{ $attendance->student->name }}</td>
            <td>
                @if($attendance->status == 'present')
                    <span class="badge bg-success">Present</span>
                @elseif($attendance->status == 'absent')
                    <span class="badge bg-danger">Absent</span>
                @elseif($attendance->status == 'late')
                    <span class="badge bg-warning">Late</span>
                @else
                    <span class="badge bg-secondary">{{ ucfirst($attendance->status) }}</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $attendances->links() }}
@endsection

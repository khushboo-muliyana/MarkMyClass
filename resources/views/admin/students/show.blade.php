@extends('layouts.dashboard')

@section('title','Student Profile')

@section('sidebar-menu')
    @include('admin._sidebar')
@endsection

@section('content')

{{-- ✅ Success Message --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- ✅ Error Messages --}}
@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>There were some errors:</strong>
        <ul class="mb-0">
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif


<div class="card">
    <div class="card-body text-center">

        @if($student->photo_path)
            <img src="{{ asset('storage/'.$student->photo_path) }}" class="rounded-circle mb-3" width="120">
        @else
            <img src="https://via.placeholder.com/120" class="rounded-circle mb-3">
        @endif

        <h4>{{ $student->name }}</h4>
        <p class="text-muted">
            Roll No: {{ $student->roll_number ?: '-' }}
        </p>

        <hr>

        <table class="table table-bordered">
            <tr><th>Email</th><td>{{ $student->email ?: '-' }}</td></tr>
            <tr><th>Phone</th><td>{{ $student->phone ?: '-' }}</td></tr>
            <tr><th>Gender</th><td>{{ $student->gender ? ucfirst($student->gender) : '-' }}</td></tr>
            <tr><th>DOB</th><td>{{ $student->date_of_birth ?: '-' }}</td></tr>
            <tr><th>Class</th><td>{{ optional($student->classroom)->name ?: '-' }}</td></tr>
            <tr><th>Guardian Name</th><td>{{ $student->guardian_name ?: '-' }}</td></tr>
            <tr><th>Address</th><td>{{ $student->address ?: '-' }}</td></tr>
        </table>

        <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">Back</a>
        <a href="{{ route('admin.students.edit',$student) }}" class="btn btn-primary">Edit</a>
    </div>
</div>
@endsection

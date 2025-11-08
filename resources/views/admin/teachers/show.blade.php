@extends('layouts.dashboard')

@section('title','Teacher Details')

@section('sidebar-menu')
    @include('admin._sidebar')
@endsection

@section('content')
<div class="card">
    <div class="card-body">

        <h4 class="mb-3">Teacher Details</h4>

        <p><strong>Name:</strong> {{ $teacher->name }}</p>
        <p><strong>Email:</strong> {{ $teacher->email }}</p>
        <p><strong>Phone:</strong> {{ $teacher->phone ?? '-' }}</p>
        <p><strong>Gender:</strong> {{ ucfirst($teacher->gender) ?? '-' }}</p>
        <p><strong>Qualification:</strong> {{ $teacher->qualification ?? '-' }}</p>
        <p><strong>Join Date:</strong> {{ $teacher->join_date ?? '-' }}</p>
        <p><strong>Classroom:</strong> {{ $teacher->classroom->name ?? '-' }}</p>

        @if($teacher->photo_path)
            <p><strong>Photo:</strong></p>
            <img src="{{ asset('storage/'.$teacher->photo_path) }}" alt="Teacher Photo" width="120">
        @endif

        <div class="mt-3">
            <a href="{{ route('admin.teachers.index') }}" class="btn btn-outline-secondary">Back</a>
        </div>

    </div>
</div>
@endsection

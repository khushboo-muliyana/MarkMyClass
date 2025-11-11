@extends('layouts.dashboard')

@section('title', 'My Profile')

@section('sidebar-menu')
    @include('teacher._sidebar')
@endsection

@section('content')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-body text-center">

        @if($teacher->photo_path)
            <img src="{{ asset('storage/'.$teacher->photo_path) }}" class="rounded-circle mb-3" width="120">
        @else
            <img src="https://ui-avatars.com/api/?name={{ $teacher->name }}" class="rounded-circle mb-3" width="120">
        @endif

        <h4>{{ $teacher->name }}</h4>
        <p class="text-muted">{{ $teacher->qualification ?: '-' }}</p>

        <hr>

        <table class="table">
            <tr><th>Email</th><td>{{ $teacher->email }}</td></tr>
            <tr><th>Phone</th><td>{{ $teacher->phone ?: '-' }}</td></tr>
            <tr><th>Gender</th><td>{{ ucfirst($teacher->gender) ?: '-' }}</td></tr>
            <tr><th>Join Date</th><td>{{ $teacher->join_date ?: '-' }}</td></tr>
            <tr><th>Class</th><td>{{ $teacher->classroom->name ?? '-' }}</td></tr>
        </table>

        <a href="{{ route('teacher.profile.edit') }}" class="btn btn-primary">Edit Profile</a>
    </div>
</div>

@endsection

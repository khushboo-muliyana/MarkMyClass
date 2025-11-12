@extends('layouts.dashboard')

@section('title','Users')

@section('sidebar-menu')
    @include('admin._sidebar')
@endsection

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

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

<div class="card mb-3">
    <div class="card-body d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Users</h5>
        <a href="{{ route('admin.teachers.create') }}" class="btn btn-outline-primary">Add Teacher</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form class="mb-3" method="GET" action="{{ route('admin.users.index') }}">
            <div class="row g-2">
                <div class="col-md-5">
                    <input type="search" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search name or email">
                </div>
                <div class="col-md-3">
                    <select name="role" class="form-select">
                        <option value="">All roles</option>
                        <option value="admin" @selected(request('role')==='admin')>Admin</option>
                        <option value="teacher" @selected(request('role')==='teacher')>Teacher</option>
                        <option value="student" @selected(request('role')==='student')>Student</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-secondary w-100">Filter</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-light w-100">Reset</a>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Related Record</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td class="text-capitalize">{{ $user->role }}</td>
                            <td>
                                @if($user->role === 'teacher' && $user->teacher)
                                    <span class="badge bg-primary">Teacher #{{ $user->teacher->id }}</span>
                                    @if($user->teacher->classroom)
                                        <small class="d-block text-muted">Classroom: {{ $user->teacher->classroom->name }}</small>
                                    @endif
                                @elseif($user->role === 'student' && $user->student)
                                    <span class="badge bg-success">Student #{{ $user->student->id }}</span>
                                    @if($user->student->classroom)
                                        <small class="d-block text-muted">Classroom: {{ $user->student->classroom->name }}</small>
                                    @endif
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.users.edit',$user) }}" class="btn btn-sm btn-outline-primary">Manage</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $users->links() }}
    </div>
</div>
@endsection

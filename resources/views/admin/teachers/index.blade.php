@extends('layouts.dashboard')

@section('title','Teachers')

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

<div class="card mb-3">
    <div class="card-body d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Teachers</h5>
        <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary">Add Teacher</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        {{-- ✅ Search/Filter Form --}}
        <form class="mb-3" method="GET" action="{{ route('admin.teachers.index') }}">
            <div class="row g-2">
                <div class="col-md-4">
                    <input type="search" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search name / email / phone">
                </div>
                <div class="col-md-4">
                    <select name="classroom_id" class="form-select">
                        <option value="">All classes</option>
                        @foreach($classrooms as $c)
                            <option value="{{ $c->id }}" @selected(request('classroom_id')==$c->id)>{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-outline-secondary">Filter</button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Gender</th>
                        <th>Classroom</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teachers as $teacher)
                        <tr>
                            <td>
                                @if($teacher->photo_path)
                                    <img src="{{ asset('storage/'.$teacher->photo_path) }}" alt="" width="48" class="rounded">
                                @else
                                    <div class="bg-light rounded d-inline-block" style="width:48px;height:48px;"></div>
                                @endif
                            </td>
                            <td>{{ $teacher->name }}</td>
                            <td>{{ $teacher->email }}</td>
                            <td>{{ $teacher->phone ?? '-' }}</td>
                            <td>{{ ucfirst($teacher->gender) ?? '-' }}</td>
                            <td>{{ $teacher->classroom->name ?? '-' }}</td>
                            <td>
                                <a href="{{ route('admin.teachers.edit',$teacher) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('admin.teachers.destroy',$teacher) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete teacher?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">No teachers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- ✅ Pagination --}}
            {{ $teachers->links() }}
        </div>
    </div>
</div>

@endsection

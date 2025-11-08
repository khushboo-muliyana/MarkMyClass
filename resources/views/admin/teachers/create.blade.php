@extends('layouts.dashboard')

@section('title','Add Teacher')

@section('sidebar-menu')
    @include('admin._sidebar')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.teachers.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label">Name</label>
                    <input name="name" value="{{ old('name') }}" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input name="email" value="{{ old('email') }}" class="form-control">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Phone</label>
                    <input name="phone" value="{{ old('phone') }}" class="form-control">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Gender</label>
                    <select name="gender" class="form-select">
                        <option value="">Select</option>
                        <option value="male" @selected(old('gender')=='male')>Male</option>
                        <option value="female" @selected(old('gender')=='female')>Female</option>
                        <option value="other" @selected(old('gender')=='other')>Other</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Qualification</label>
                    <input name="qualification" value="{{ old('qualification') }}" class="form-control">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Join Date</label>
                    <input name="join_date" type="date" value="{{ old('join_date') }}" class="form-control">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Classroom</label>
                    <select name="classroom_id" class="form-select">
                        <option value="">Select Classroom</option>
                        @foreach($classrooms as $c)
                            <option value="{{ $c->id }}" @selected(old('classroom_id')==$c->id)>{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Photo</label>
                    <input name="photo_path" type="file" class="form-control">
                </div>

            </div>

            <div class="mt-3">
                <button class="btn btn-primary">Save</button>
                <a href="{{ route('admin.teachers.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>

        </form>
    </div>
</div>
@endsection

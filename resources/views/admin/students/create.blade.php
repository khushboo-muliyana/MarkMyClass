@extends('layouts.dashboard')

@section('title','Add Student')

@section('sidebar-menu')
    @include('admin._sidebar')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.students.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- ✅ Global Error Display --}}
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
                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input name="email" value="{{ old('email') }}" class="form-control">
                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Roll Number</label>
                    <input name="roll_number" value="{{ old('roll_number') }}" class="form-control">
                    @error('roll_number') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Class</label>
                    <select name="classroom_id" class="form-select">
                        <option value="">Select class</option>
                        @foreach($classrooms as $c)
                            <option value="{{ $c->id }}" @selected(old('classroom_id')==$c->id)>{{ $c->name }}</option>
                        @endforeach
                    </select>
                    @error('classroom_id') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Phone</label>
                    <input name="phone" value="{{ old('phone') }}" class="form-control">
                    @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Gender</label>
                    <select name="gender" class="form-select">
                        <option value="">Select</option>
                        <option value="male" @selected(old('gender')=='male')>Male</option>
                        <option value="female" @selected(old('gender')=='female')>Female</option>
                        <option value="other" @selected(old('gender')=='other')>Other</option>
                    </select>
                    @error('gender') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Date of Birth</label>
                    <input name="date_of_birth" type="date" value="{{ old('date_of_birth') }}" class="form-control">
                    @error('date_of_birth') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Guardian Name</label>
                    <input name="guardian_name" value="{{ old('guardian_name') }}" class="form-control">
                    @error('guardian_name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Address</label>
                    <textarea name="address" class="form-control">{{ old('address') }}</textarea>
                    @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Photo</label>
                    <input name="photo" type="file" class="form-control">
                    @error('photo') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

            </div>

            <div class="mt-3">
                <button class="btn btn-primary">Save</button>
                <a href="{{ route('admin.students.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

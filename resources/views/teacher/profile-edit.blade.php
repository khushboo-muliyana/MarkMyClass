@extends('layouts.dashboard')

@section('title', 'Edit Profile')

@section('sidebar-menu')
    @include('teacher._sidebar')
@endsection

@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ route('teacher.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone"
                       value="{{ old('phone', $teacher->phone) }}"
                       class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Gender</label>
                <select name="gender" class="form-control">
                    <option value="">Select</option>
                    <option value="male" {{ $teacher->gender == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ $teacher->gender == 'female' ? 'selected' : '' }}>Female</option>
                    <option value="other" {{ $teacher->gender == 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Qualification</label>
                <input type="text" name="qualification"
                       value="{{ old('qualification', $teacher->qualification) }}"
                       class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Join Date</label>
                <input type="date" name="join_date"
                       value="{{ old('join_date', $teacher->join_date) }}"
                       class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Photo</label>
                <input type="file" name="photo" class="form-control">
            </div>

            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('teacher.profile') }}" class="btn btn-secondary">Cancel</a>

        </form>

    </div>
</div>

@endsection

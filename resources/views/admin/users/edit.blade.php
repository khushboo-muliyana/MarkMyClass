@extends('layouts.dashboard')

@section('title','Manage User')

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

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">Update User</h5>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Back</a>
</div>

<form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data" id="user-form">
    @csrf
    @method('PUT')

    <div class="card mb-4">
        <div class="card-header">
            <strong>Account Details</strong>
        </div>
        <div class="card-body row g-3">
            <div class="col-md-6">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Role</label>
                <select name="role" id="role" class="form-select" required>
                    <option value="admin" @selected(old('role', $user->role)==='admin')>Admin</option>
                    <option value="teacher" @selected(old('role', $user->role)==='teacher')>Teacher</option>
                    <option value="student" @selected(old('role', $user->role)==='student')>Student</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">New Password</label>
                <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current">
            </div>
            <div class="col-md-4">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm new password">
            </div>
        </div>
    </div>

    <div class="card mb-4 role-section" id="teacher-section">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong>Teacher Profile</strong>
            <span class="text-muted">Visible when role is teacher</span>
        </div>
        <div class="card-body row g-3">
            <div class="col-md-4">
                <label class="form-label">Phone</label>
                <input type="text" name="teacher_phone" class="form-control" value="{{ old('teacher_phone', optional($user->teacher)->phone) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Gender</label>
                <select name="teacher_gender" class="form-select">
                    <option value="">Select gender</option>
                    <option value="male" @selected(old('teacher_gender', optional($user->teacher)->gender)==='male')>Male</option>
                    <option value="female" @selected(old('teacher_gender', optional($user->teacher)->gender)==='female')>Female</option>
                    <option value="other" @selected(old('teacher_gender', optional($user->teacher)->gender)==='other')>Other</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Qualification</label>
                <input type="text" name="teacher_qualification" class="form-control" value="{{ old('teacher_qualification', optional($user->teacher)->qualification) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Join Date</label>
                <input type="date" name="teacher_join_date" class="form-control" value="{{ old('teacher_join_date', optional($user->teacher)->join_date) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Classroom</label>
                <select name="teacher_classroom_id" class="form-select">
                    <option value="">Not assigned</option>
                    @foreach($classrooms as $classroom)
                        <option value="{{ $classroom->id }}" @selected(old('teacher_classroom_id', optional($user->teacher)->classroom_id)==$classroom->id)>{{ $classroom->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Profile Photo</label>
                <input type="file" name="teacher_photo" class="form-control">
                @if(optional($user->teacher)->photo_path)
                    <small class="text-muted d-block mt-1">Current: <a href="{{ asset('storage/'.optional($user->teacher)->photo_path) }}" target="_blank">View</a></small>
                @endif
            </div>
        </div>
    </div>

    <div class="card mb-4 role-section" id="student-section">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong>Student Profile</strong>
            <span class="text-muted">Visible when role is student</span>
        </div>
        <div class="card-body row g-3">
            <div class="col-md-4">
                <label class="form-label">Roll Number</label>
                <input type="text" name="student_roll_number" class="form-control" value="{{ old('student_roll_number', optional($user->student)->roll_number) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Classroom</label>
                <select name="student_classroom_id" class="form-select">
                    <option value="">Not assigned</option>
                    @foreach($classrooms as $classroom)
                        <option value="{{ $classroom->id }}" @selected(old('student_classroom_id', optional($user->student)->classroom_id)==$classroom->id)>{{ $classroom->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Phone</label>
                <input type="text" name="student_phone" class="form-control" value="{{ old('student_phone', optional($user->student)->phone) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Gender</label>
                <select name="student_gender" class="form-select">
                    <option value="">Select gender</option>
                    <option value="male" @selected(old('student_gender', optional($user->student)->gender)==='male')>Male</option>
                    <option value="female" @selected(old('student_gender', optional($user->student)->gender)==='female')>Female</option>
                    <option value="other" @selected(old('student_gender', optional($user->student)->gender)==='other')>Other</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Date of Birth</label>
                <input type="date" name="student_date_of_birth" class="form-control" value="{{ old('student_date_of_birth', optional(optional($user->student)->date_of_birth)->format('Y-m-d')) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Guardian Name</label>
                <input type="text" name="student_guardian_name" class="form-control" value="{{ old('student_guardian_name', optional($user->student)->guardian_name) }}">
            </div>
            <div class="col-12">
                <label class="form-label">Address</label>
                <textarea name="student_address" class="form-control" rows="3">{{ old('student_address', optional($user->student)->address) }}</textarea>
            </div>
            <div class="col-md-4">
                <label class="form-label">Profile Photo</label>
                <input type="file" name="student_photo" class="form-control">
                @if(optional($user->student)->photo_path)
                    <small class="text-muted d-block mt-1">Current: <a href="{{ asset('storage/'.optional($user->student)->photo_path) }}" target="_blank">View</a></small>
                @endif
            </div>
        </div>
    </div>

    <div class="text-end">
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </div>
</form>

@push('scripts')
<script>
    function toggleRoleSections() {
        const roleSelect = document.getElementById('role');
        if (!roleSelect) {
            return;
        }
        const role = roleSelect.value;
        document.getElementById('teacher-section').style.display = role === 'teacher' ? 'block' : 'none';
        document.getElementById('student-section').style.display = role === 'student' ? 'block' : 'none';
    }

    const roleField = document.getElementById('role');
    roleField?.addEventListener('change', toggleRoleSections);
    toggleRoleSections();
</script>
@endpush
@endsection

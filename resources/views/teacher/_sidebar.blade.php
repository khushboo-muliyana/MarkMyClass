<div class="sidebar-menu">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ request()->is('teacher/dashboard') ? 'active' : '' }}" href="{{ route('teacher.dashboard') }}">
                <i class="bi bi-house-door me-2"></i> Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->is('teacher/attendance*') ? 'active' : '' }}" href="{{ route('teacher.attendance.index') }}">
                <i class="bi bi-calendar-check me-2"></i> Mark Attendance
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->is('teacher/attendance-records*') ? 'active' : '' }}" href="{{ route('teacher.attendance.records') }}">
                <i class="bi bi-list-task me-2"></i> Attendance Records
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->is('teacher/profile') ? 'active' : '' }}" href="{{ route('teacher.profile') }}">
                <i class="bi bi-person me-2"></i> My Profile
            </a>
        </li>

        <li class="nav-item mt-3">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-danger w-100">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </button>
            </form>
        </li>
    </ul>
</div>

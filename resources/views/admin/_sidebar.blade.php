<li class="nav-item">
    <a href="{{ route('admin.dashboard') }}" 
       class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i>
        <span>Dashboard</span>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('admin.students.index') }}" 
       class="nav-link {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">
        <i class="bi bi-people"></i>
        <span>Students</span>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('admin.teachers.index') }}" 
       class="nav-link {{ request()->routeIs('admin.teachers.*') ? 'active' : '' }}">
        <i class="bi bi-person-badge"></i>
        <span>Teachers</span>
    </a>
</li>
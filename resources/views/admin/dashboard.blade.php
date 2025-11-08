    @extends('layouts.dashboard')

    @section('title', 'Admin Dashboard')

    @section('sidebar-menu')
        @include('admin._sidebar')
    @endsection



    @section('content')
        <!-- Welcome Section -->
        <div class="welcome-section">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h2>Welcome back, {{ Auth::user()->name }}!</h2>
                    <p>Here's what's happening with your attendance system today.</p>
                </div>
                <div class="mt-3 mt-md-0">
                    <button class="btn btn-light btn-lg">
                        <i class="bi bi-plus-circle me-2"></i>Add New
                    </button>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-6 col-lg-3">
                <div class="stats-card primary">
                    <div class="stats-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="stats-value">248</div>
                    <p class="stats-label">Total Students</p>
                    <small class="text-muted">
                        <i class="bi bi-arrow-up text-success"></i> 12% from last month
                    </small>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <div class="stats-card success">
                    <div class="stats-icon">
                        <i class="bi bi-person-badge"></i>
                    </div>
                    <div class="stats-value">18</div>
                    <p class="stats-label">Active Teachers</p>
                    <small class="text-muted">
                        <i class="bi bi-arrow-up text-success"></i> 2 new this month
                    </small>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <div class="stats-card info">
                    <div class="stats-icon">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                    <div class="stats-value">95.2%</div>
                    <p class="stats-label">Today's Attendance</p>
                    <small class="text-muted">
                        <i class="bi bi-arrow-up text-success"></i> 2.1% increase
                    </small>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <div class="stats-card warning">
                    <div class="stats-icon">
                        <i class="bi bi-book"></i>
                    </div>
                    <div class="stats-value">12</div>
                    <p class="stats-label">Active Classes</p>
                    <small class="text-muted">
                        <i class="bi bi-dash text-muted"></i> No change
                    </small>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="content-card">
            <div class="card-header-custom">
                <h5 class="card-title-custom">
                    <i class="bi bi-lightning-charge me-2"></i>Quick Actions
                </h5>
            </div>
            <div class="quick-actions">
                <a href="#" class="action-btn">
                    <i class="bi bi-person-plus"></i>
                    <span>Add Student</span>
                </a>
                <a href="#" class="action-btn">
                    <i class="bi bi-person-badge"></i>
                    <span>Add Teacher</span>
                </a>
                <a href="#" class="action-btn">
                    <i class="bi bi-calendar-plus"></i>
                    <span>Mark Attendance</span>
                </a>
                <a href="#" class="action-btn">
                    <i class="bi bi-file-earmark-text"></i>
                    <span>Generate Report</span>
                </a>
                <a href="#" class="action-btn">
                    <i class="bi bi-book-half"></i>
                    <span>Create Class</span>
                </a>
                <a href="#" class="action-btn">
                    <i class="bi bi-graph-up-arrow"></i>
                    <span>View Analytics</span>
                </a>
            </div>
        </div>

        <!-- Recent Activity & Latest Records -->
        <div class="row g-4">
            <!-- Recent Attendance Records -->
            <div class="col-lg-8">
                <div class="content-card">
                    <div class="card-header-custom">
                        <h5 class="card-title-custom">
                            <i class="bi bi-clock-history me-2"></i>Recent Attendance Records
                        </h5>
                        <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Class</th>
                                    <th>Teacher</th>
                                    <th>Present</th>
                                    <th>Absent</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ now()->format('M d, Y') }}</td>
                                    <td>Class 10-A</td>
                                    <td>John Doe</td>
                                    <td>28</td>
                                    <td>2</td>
                                    <td>
                                        <span class="badge bg-success">Completed</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ now()->subDay()->format('M d, Y') }}</td>
                                    <td>Class 9-B</td>
                                    <td>Jane Smith</td>
                                    <td>25</td>
                                    <td>5</td>
                                    <td>
                                        <span class="badge bg-success">Completed</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ now()->subDays(2)->format('M d, Y') }}</td>
                                    <td>Class 11-A</td>
                                    <td>Mike Johnson</td>
                                    <td>30</td>
                                    <td>0</td>
                                    <td>
                                        <span class="badge bg-success">Completed</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ now()->subDays(3)->format('M d, Y') }}</td>
                                    <td>Class 8-C</td>
                                    <td>Sarah Williams</td>
                                    <td>22</td>
                                    <td>3</td>
                                    <td>
                                        <span class="badge bg-warning">Pending</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- System Overview -->
            <div class="col-lg-4">
                <div class="content-card">
                    <div class="card-header-custom">
                        <h5 class="card-title-custom">
                            <i class="bi bi-info-circle me-2"></i>System Overview
                        </h5>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">System Health</span>
                            <span class="badge bg-success">Excellent</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 98%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Storage Used</span>
                            <span class="text-muted">45%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-info" role="progressbar" style="width: 45%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Active Sessions</span>
                            <span class="badge bg-primary">12</span>
                        </div>
                    </div>
                    <hr>
                    <div class="d-grid">
                        <button class="btn btn-primary-custom">
                            <i class="bi bi-download me-2"></i>Export Data
                        </button>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="content-card mt-4">
                    <div class="card-header-custom">
                        <h5 class="card-title-custom">
                            <i class="bi bi-bar-chart me-2"></i>This Week
                        </h5>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <small class="text-muted d-block">Avg. Attendance</small>
                            <strong>94.5%</strong>
                        </div>
                        <div class="text-end">
                            <small class="text-muted d-block">Total Records</small>
                            <strong>84</strong>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted d-block">Absent Students</small>
                            <strong class="text-danger">12</strong>
                        </div>
                        <div class="text-end">
                            <small class="text-muted d-block">Late Arrivals</small>
                            <strong class="text-warning">8</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

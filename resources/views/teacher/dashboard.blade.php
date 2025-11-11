@extends('layouts.dashboard')

@section('title', 'Teacher Dashboard')

@section('sidebar-menu')
    @include('teacher._sidebar')
@endsection


@section('content')
    <!-- Welcome Section -->
    <div class="welcome-section">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h2>Welcome, {{ Auth::user()->name }}!</h2>
                <p>Ready to mark today's attendance? Let's get started.</p>
            </div>
            <div class="mt-3 mt-md-0">
                <button class="btn btn-light btn-lg">
                    <i class="bi bi-calendar-check me-2"></i>Mark Attendance
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
                <div class="stats-value">{{ $totalStudents ?? 0 }}</div>
                <p class="stats-label">Total Students</p>
                <small class="text-muted">
                    <i class="bi bi-check-circle text-success"></i> All enrolled
                </small>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-3">
            <div class="stats-card success">
                <div class="stats-icon">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="stats-value">{{ $todayAttendance ?? 0 }}</div>
                <p class="stats-label">Present Today</p>
                <small class="text-muted">
                    <i class="bi bi-clock"></i> As of now
                </small>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-3">
            <div class="stats-card danger">
                <div class="stats-icon">
                    <i class="bi bi-x-circle"></i>
                </div>
                <div class="stats-value">2</div>
                <p class="stats-label">Absent Today</p>
                <small class="text-muted">
                    <i class="bi bi-exclamation-triangle"></i> Action needed
                </small>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-3">
            <div class="stats-card info">
                <div class="stats-icon">
                    <i class="bi bi-percent"></i>
                </div>
                <div class="stats-value">93.8%</div>
                <p class="stats-label">This Week Avg.</p>
                <small class="text-muted">
                    <i class="bi bi-arrow-up text-success"></i> Good progress
                </small>
            </div>
        </div>
    </div>

    <!-- Today's Attendance Status -->
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="content-card">
                <div class="card-header-custom">
                    <h5 class="card-title-custom">
                        <i class="bi bi-calendar-day me-2"></i>Today's Attendance - {{ now()->format('F d, Y') }}
                    </h5>
                    <div>
                        <span class="badge bg-success me-2">Marked</span>
                        <button class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil me-1"></i>Edit
                        </button>
                    </div>
                </div>
                
                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <div class="text-center p-3 bg-light rounded">
                            <div class="h3 mb-0 text-success">30</div>
                            <small class="text-muted">Present</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-3 bg-light rounded">
                            <div class="h3 mb-0 text-danger">2</div>
                            <small class="text-muted">Absent</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-3 bg-light rounded">
                            <div class="h3 mb-0 text-info">0</div>
                            <small class="text-muted">Late</small>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Student ID</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Time</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>ST001</td>
                                <td>Alice Johnson</td>
                                <td><span class="badge bg-success">Present</span></td>
                                <td>08:30 AM</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>ST002</td>
                                <td>Bob Smith</td>
                                <td><span class="badge bg-success">Present</span></td>
                                <td>08:25 AM</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>ST003</td>
                                <td>Charlie Brown</td>
                                <td><span class="badge bg-danger">Absent</span></td>
                                <td>-</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-check"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>ST004</td>
                                <td>Diana Prince</td>
                                <td><span class="badge bg-success">Present</span></td>
                                <td>08:35 AM</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>ST005</td>
                                <td>Ethan Hunt</td>
                                <td><span class="badge bg-danger">Absent</span></td>
                                <td>-</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-check"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                    <button class="btn btn-outline-secondary">
                        <i class="bi bi-download me-2"></i>Export
                    </button>
                    <button class="btn btn-primary-custom">
                        <i class="bi bi-save me-2"></i>Save Changes
                    </button>
                </div>
            </div>
        </div>

        <!-- Quick Actions & Info -->
        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="content-card">
                <div class="card-header-custom">
                    <h5 class="card-title-custom">
                        <i class="bi bi-lightning-charge me-2"></i>Quick Actions
                    </h5>
                </div>
                <div class="d-grid gap-2">
                    <button class="btn btn-primary-custom">
                        <i class="bi bi-calendar-check me-2"></i>Mark All Present
                    </button>
                    <button class="btn btn-outline-primary">
                        <i class="bi bi-clock me-2"></i>Mark Late Arrivals
                    </button>
                    <button class="btn btn-outline-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i>View Absentees
                    </button>
                    <button class="btn btn-outline-info">
                        <i class="bi bi-file-earmark-text me-2"></i>Generate Report
                    </button>
                </div>
            </div>

            <!-- This Week's Summary -->
            <div class="content-card mt-4">
                <div class="card-header-custom">
                    <h5 class="card-title-custom">
                        <i class="bi bi-calendar-week me-2"></i>This Week
                    </h5>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Monday</span>
                        <span class="badge bg-success">95%</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 95%"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Tuesday</span>
                        <span class="badge bg-success">92%</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 92%"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Wednesday</span>
                        <span class="badge bg-warning">88%</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 88%"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Thursday</span>
                        <span class="badge bg-success">94%</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 94%"></div>
                    </div>
                </div>
                <div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Today</span>
                        <span class="badge bg-success">94%</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 94%"></div>
                    </div>
                </div>
                <hr>
                <div class="text-center">
                    <strong>Weekly Average: 92.6%</strong>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="content-card mt-4">
                <div class="card-header-custom">
                    <h5 class="card-title-custom">
                        <i class="bi bi-clock-history me-2"></i>Recent Activity
                    </h5>
                </div>
                <div class="list-group list-group-flush">
                    <div class="list-group-item border-0 px-0">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            <div class="flex-grow-1">
                                <small class="text-muted d-block">2 hours ago</small>
                                <small>Marked attendance for Class 10-A</small>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item border-0 px-0">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-file-earmark-text text-info me-2"></i>
                            <div class="flex-grow-1">
                                <small class="text-muted d-block">Yesterday</small>
                                <small>Generated weekly report</small>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item border-0 px-0">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-person-plus text-primary me-2"></i>
                            <div class="flex-grow-1">
                                <small class="text-muted d-block">2 days ago</small>
                                <small>Added new student</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Classes -->
    <div class="content-card">
        <div class="card-header-custom">
            <h5 class="card-title-custom">
                <i class="bi bi-calendar3 me-2"></i>Upcoming Classes
            </h5>
            <a href="#" class="btn btn-sm btn-outline-primary">View Calendar</a>
        </div>
        <div class="row g-3">
            <div class="col-md-6 col-lg-3">
                <div class="border rounded p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h6 class="mb-0">Class 10-A</h6>
                            <small class="text-muted">Mathematics</small>
                        </div>
                        <span class="badge bg-primary">10:00 AM</span>
                    </div>
                    <small class="text-muted">Room 201</small>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="border rounded p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h6 class="mb-0">Class 9-B</h6>
                            <small class="text-muted">Science</small>
                        </div>
                        <span class="badge bg-primary">02:00 PM</span>
                    </div>
                    <small class="text-muted">Room 105</small>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="border rounded p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h6 class="mb-0">Class 11-A</h6>
                            <small class="text-muted">Physics</small>
                        </div>
                        <span class="badge bg-primary">03:30 PM</span>
                    </div>
                    <small class="text-muted">Lab 3</small>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="border rounded p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h6 class="mb-0">Class 8-C</h6>
                            <small class="text-muted">English</small>
                        </div>
                        <span class="badge bg-primary">04:30 PM</span>
                    </div>
                    <small class="text-muted">Room 302</small>
                </div>
            </div>
        </div>
    </div>
@endsection

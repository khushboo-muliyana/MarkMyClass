<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TeacherController;

use App\Http\Controllers\Teacher\TeacherDashboardController;
use App\Http\Controllers\Teacher\AttendanceController;
use App\Http\Controllers\Teacher\ProfileController as TeacherProfileController;


use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // Students CRUD
        Route::resource('students', StudentController::class)->except(['show']);
          // Teachers CRUD
        Route::resource('teachers', TeacherController::class)->except(['show']);
    });
Route::middleware(['auth', 'teacher'])->prefix('teacher')->name('teacher.')->group(function() {
    
    // Dashboard
    Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('dashboard');

    // Attendance
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::get('/attendance-records', [AttendanceController::class, 'records'])->name('attendance.records');

    // Profile
    Route::get('/profile', [TeacherProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [TeacherProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [TeacherProfileController::class, 'update'])->name('profile.update');
});

require __DIR__.'/auth.php';

<?php

use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\OfficeController;
use App\Http\Controllers\AttedenceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatistikController;
use Illuminate\Support\Facades\Route;

// Guest Routes
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'handleLogin'])->name('login.post')->middleware('throttle:5,1');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'handleRegister'])->name('register.post')->middleware('throttle:5,1');
    Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.request');
    Route::get('/reset-password', [AuthController::class, 'resetPassword'])->name('password.reset');
});

// Face Enrollment (accessed by authenticated users or guests with pending session)
Route::get('/face-enrollment', [AuthController::class, 'faceEnrollmentView'])->name('face.enrollment');
Route::post('/face-enrollment', [AuthController::class, 'faceEnrollmentStore'])->name('face.enrollment.store')->middleware('throttle:5,1');

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Face Enrolled Employee Routes
    Route::middleware(['face.enrolled', 'employee'])->group(function () {
        // home
        Route::get('/', [HomeController::class, 'index'])->name('home');

        // Attendance/Absen
        Route::get('/attedance', [AttedenceController::class, 'index'])->name('attendance.index');
        Route::post('/api/offices/closest', [AttedenceController::class, 'getClosestOffice'])->name('api.offices.closest');

        Route::get('/attedance/action', [AttedenceController::class, 'attedanceAction'])->name('attendance.action');
        Route::post('/api/attedance/submit', [AttedenceController::class, 'submit'])->name('attendance.submit')->middleware('throttle:5,1');
        Route::get('/attedance/success', [AttedenceController::class, 'attedanceSuccess'])->name('attendance.success');

        Route::get('/attedance/ishoma/index', [AttedenceController::class, 'attedanceIshomaIndex']);
        Route::get('/attedance/ishoma', [AttedenceController::class, 'attedanceIshoma']);

        // History
        Route::get('/history', [HistoryController::class, 'index']);

        // Statistik
        Route::get('/statistik', [StatistikController::class, 'index']);

        // Profile
        Route::get('/profile', [ProfileController::class, 'profile']);
    });
});

// Admin Dashboard Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Kelola Karyawan (CRUD)
    Route::get('/employees', [EmployeeController::class, 'index']);
    Route::get('/employees/create', [EmployeeController::class, 'create']);
    Route::post('/employees', [EmployeeController::class, 'store']);
    Route::get('/employees/{id}/edit', [EmployeeController::class, 'edit']);
    Route::put('/employees/{id}', [EmployeeController::class, 'update']);
    Route::delete('/employees/{id}', [EmployeeController::class, 'destroy']);

    // Kelola Kantor Geofencing (CRUD)
    Route::get('/offices', [OfficeController::class, 'index']);
    Route::get('/offices/create', [OfficeController::class, 'create']);
    Route::post('/offices', [OfficeController::class, 'store']);
    Route::get('/offices/{id}/edit', [OfficeController::class, 'edit']);
    Route::put('/offices/{id}', [OfficeController::class, 'update']);
    Route::delete('/offices/{id}', [OfficeController::class, 'destroy']);

    // Rekap Absensi
    Route::get('/attendances/prayers', [AttendanceController::class, 'prayers']);
    Route::get('/attendances', [AttendanceController::class, 'index']);
    Route::get('/attendances/{id}', [AttendanceController::class, 'show']);
});

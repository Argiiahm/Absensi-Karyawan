<?php

use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\OfficeController;
use App\Http\Controllers\AttedenceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatistikController;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.request');
Route::get('/reset-password', [AuthController::class, 'resetPassword'])->name('password.reset');

Route::get('/', function () {
    return view('components.features.employes.home.home');
});


// attedance/absen
// absen biasa
Route::get('/attedance', [AttedenceController::class, 'index']);
// absen sholat
Route::get('/attedance/ishoma/index', [AttedenceController::class, 'attedanceIshomaIndex']);
Route::get('/attedance/ishoma', [AttedenceController::class, 'attedanceIshoma']);

// absen action (selfie)
Route::get('/attedance/action', [AttedenceController::class, 'attedanceAction']);
// absen sukses
Route::get('/attedance/success', [AttedenceController::class, 'attedanceSuccess']);
// history attedance/riwayat absen
Route::get('/history', [HistoryController::class, 'index']);

// statistik
Route::get('/statistik', [StatistikController::class, 'index']);

// profile
Route::get('/profile', [ProfileController::class, 'profile']);

// Admin Dashboard Routes
Route::prefix('admin')->group(function () {
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

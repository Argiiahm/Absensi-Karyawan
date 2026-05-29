<?php

use App\Http\Controllers\AttedenceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatistikController;
use Illuminate\Support\Facades\Route;

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

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/otp', [AuthController::class, 'showOtp']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);

Route::get('/forgot-password', [AuthController::class, 'showForgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);
Route::get('/reset-otp', [AuthController::class, 'showResetOtp']);
Route::post('/verify-reset-otp', [AuthController::class, 'verifyResetOtp']);
Route::get('/change-password', [AuthController::class, 'showChangePassword']);
Route::post('/change-password', [AuthController::class, 'changePassword']);

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/logout', [AuthController::class, 'logout']);
});

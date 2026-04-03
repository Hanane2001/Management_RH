<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Middleware\IsAdmin;

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

Route::middleware(['auth', IsAdmin::class])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    
    //Employees
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
    Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
    Route::get('/employees/{id}', [EmployeeController::class, 'show'])->name('employees.show');
    Route::get('/employees/{id}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::put('/employees/{id}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::delete('/employees/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
});

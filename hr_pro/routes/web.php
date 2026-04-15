<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\LeaveBalanceController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsManager;

Route::get('/', function () {
    return view('welcome');
});

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/otp', [AuthController::class, 'showOtp']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);
Route::get('/reset-otp', [AuthController::class, 'showResetOtp']);
Route::post('/verify-reset-otp', [AuthController::class, 'verifyResetOtp']);
Route::get('/change-password', [AuthController::class, 'showChangePassword']);
Route::post('/change-password', [AuthController::class, 'changePassword']);

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Departments
    Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');
    Route::get('/departments/{id}', [DepartmentController::class, 'show'])->name('departments.show');

    // Contracts
    Route::get('/contracts/create', [ContractController::class, 'create'])->name('contracts.create');
    Route::get('/contracts', [ContractController::class, 'index'])->name('contracts.index');
    Route::get('/contracts/{contract}', [ContractController::class, 'show'])->name('contracts.show');

    // Leave
    Route::get('/leaves/create', [LeaveController::class, 'create'])->name('leaves.create');
    Route::get('/leaves/balance/my', [LeaveController::class, 'balance'])->name('leaves.balance');
    Route::get('/leaves', [LeaveController::class, 'index'])->name('leaves.index');
    Route::get('/leaves/{leave}', [LeaveController::class, 'show'])->name('leaves.show');
    Route::post('/leaves', [LeaveController::class, 'store'])->name('leaves.store');

    // LeaveBalance
    Route::get('/my-balance', [LeaveBalanceController::class, 'myBalance'])->name('leave-balances.my');
});

// Admin routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('employees', EmployeeController::class);
    Route::resource('departments', DepartmentController::class)->except(['index', 'show']);

    Route::get('/leave-balances/create', [LeaveBalanceController::class, 'create'])->name('leave-balances.create');
    Route::post('/leave-balances', [LeaveBalanceController::class, 'store'])->name('leave-balances.store');
    Route::get('/leave-balances/{leaveBalance}/edit', [LeaveBalanceController::class, 'edit'])->name('leave-balances.edit');
    Route::put('/leave-balances/{leaveBalance}', [LeaveBalanceController::class, 'update'])->name('leave-balances.update');
    Route::delete('/leave-balances/{leaveBalance}', [LeaveBalanceController::class, 'destroy'])->name('leave-balances.destroy');
    Route::post('/leave-balances/initialize', [LeaveBalanceController::class, 'initializeYear'])->name('leave-balances.initialize');
    Route::post('/leave-balances/reset', [LeaveBalanceController::class, 'resetForNewYear'])->name('leave-balances.reset');
    Route::post('/leave-balances/{leaveBalance}/add-days', [LeaveBalanceController::class, 'addDays'])->name('leave-balances.add-days');
});

// Manager routes
Route::middleware(['auth', 'manager'])->group(function () {
    Route::post('/contracts', [ContractController::class, 'store'])->name('contracts.store');
    Route::get('/contracts/{contract}/edit', [ContractController::class, 'edit'])->name('contracts.edit');
    Route::put('/contracts/{contract}', [ContractController::class, 'update'])->name('contracts.update');
    Route::delete('/contracts/{contract}', [ContractController::class, 'destroy'])->name('contracts.destroy');

    Route::post('/leaves/{leave}/approve', [LeaveController::class, 'approve'])->name('leaves.approve');
    Route::post('/leaves/{leave}/reject', [LeaveController::class, 'reject'])->name('leaves.reject');
    Route::get('/leaves/balances/all', [LeaveController::class, 'allBalances'])->name('leaves.all-balances');

    Route::get('/leave-balances', [LeaveBalanceController::class, 'index'])->name('leave-balances.index');
    Route::get('/leave-balances/{leaveBalance}', [LeaveBalanceController::class, 'show'])->name('leave-balances.show');
    Route::get('/leave-balances/statistics', [LeaveBalanceController::class, 'statistics'])->name('leave-balances.statistics');
    Route::get('/leave-balances/export/csv', [LeaveBalanceController::class, 'export'])->name('leave-balances.export');
});
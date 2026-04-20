<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\LeaveBalanceController;
use App\Http\Controllers\EvaluationController;
use Illuminate\Support\Facades\Gate;

Route::get('/', function () {
    return view('welcome');
});

// Auth 
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/otp', [AuthController::class, 'showOtp'])->name('otp');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify-otp');
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot-password');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset-password');
Route::get('/reset-otp', [AuthController::class, 'showResetOtp'])->name('reset-otp');
Route::post('/verify-reset-otp', [AuthController::class, 'verifyResetOtp'])->name('verify-reset-otp');
Route::get('/change-password', [AuthController::class, 'showChangePassword'])->name('change-password');
Route::post('/change-password', [AuthController::class, 'changePassword']);

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Departments
    Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');
    Route::get('/departments/{id}', [DepartmentController::class, 'show'])->name('departments.show');

    // Contracts
    Route::get('/contracts', [ContractController::class, 'index'])->name('contracts.index');
    Route::get('/contracts/{contract}', [ContractController::class, 'show'])->name('contracts.show');

    // Leaves
    Route::get('/leaves', [LeaveController::class, 'index'])->name('leaves.index');
    Route::get('/leaves/create', [LeaveController::class, 'create'])->name('leaves.create');
    Route::post('/leaves', [LeaveController::class, 'store'])->name('leaves.store');
    Route::get('/leaves/{leave}', [LeaveController::class, 'show'])->name('leaves.show');
    Route::get('/leaves/balance/my', [LeaveController::class, 'balance'])->name('leaves.balance');

    // Leave Balances
    Route::get('/my-balance', [LeaveBalanceController::class, 'myBalance'])->name('leave-balances.my');

    // Evaluations
    Route::get('/evaluations', [EvaluationController::class, 'index'])->name('evaluations.index');
    Route::get('/evaluations/statistics', [EvaluationController::class, 'statistics'])->name('evaluations.statistics');
    Route::get('/evaluations/export', [EvaluationController::class, 'export'])->name('evaluations.export');
    Route::get('/evaluations/create', [EvaluationController::class, 'create'])->name('evaluations.create');
    Route::get('/evaluations/{evaluation}', [EvaluationController::class, 'show'])->name('evaluations.show');
});

Route::middleware(['auth', 'admin'])->group(function () {
    // Employees
    Route::resource('employees', EmployeeController::class);
    
    // Departments
    Route::resource('departments', DepartmentController::class)->except(['index', 'show']);
    
    // Leave Balances
    Route::get('/leave-balances', [LeaveBalanceController::class, 'index'])->name('leave-balances.index');
    Route::get('/leave-balances/create', [LeaveBalanceController::class, 'create'])->name('leave-balances.create');
    Route::post('/leave-balances', [LeaveBalanceController::class, 'store'])->name('leave-balances.store');
    Route::get('/leave-balances/{leaveBalance}', [LeaveBalanceController::class, 'show'])->name('leave-balances.show');
    Route::get('/leave-balances/{leaveBalance}/edit', [LeaveBalanceController::class, 'edit'])->name('leave-balances.edit');
    Route::put('/leave-balances/{leaveBalance}', [LeaveBalanceController::class, 'update'])->name('leave-balances.update');
    Route::delete('/leave-balances/{leaveBalance}', [LeaveBalanceController::class, 'destroy'])->name('leave-balances.destroy');
    Route::post('/leave-balances/initialize', [LeaveBalanceController::class, 'initializeYear'])->name('leave-balances.initialize');
    Route::post('/leave-balances/{leaveBalance}/add-days', [LeaveBalanceController::class, 'addDays'])->name('leave-balances.add-days');
    Route::get('/leave-balances/export/csv', [LeaveBalanceController::class, 'export'])->name('leave-balances.export');
    Route::get('/leave-balances/statistics', [LeaveBalanceController::class, 'statistics'])->name('leave-balances.statistics');
});

Route::middleware(['auth', 'manager'])->group(function () {
    // Contracts
    Route::get('/contracts/create', [ContractController::class, 'create'])->name('contracts.create');
    Route::post('/contracts', [ContractController::class, 'store'])->name('contracts.store');
    Route::get('/contracts/{contract}/edit', [ContractController::class, 'edit'])->name('contracts.edit');
    Route::put('/contracts/{contract}', [ContractController::class, 'update'])->name('contracts.update');
    Route::delete('/contracts/{contract}', [ContractController::class, 'destroy'])->name('contracts.destroy');

    // Leaves
    Route::post('/leaves/{leave}/approve', [LeaveController::class, 'approve'])->name('leaves.approve');
    Route::post('/leaves/{leave}/reject', [LeaveController::class, 'reject'])->name('leaves.reject');
    Route::get('/leaves/balances/all', [LeaveController::class, 'allBalances'])->name('leaves.all-balances');

    // Leave Balances
    Route::get('/leave-balances', [LeaveBalanceController::class, 'index'])->name('leave-balances.index');
    Route::get('/leave-balances/{leaveBalance}', [LeaveBalanceController::class, 'show'])->name('leave-balances.show');
    Route::get('/leave-balances/statistics', [LeaveBalanceController::class, 'statistics'])->name('leave-balances.statistics');
    Route::get('/leave-balances/export/csv', [LeaveBalanceController::class, 'export'])->name('leave-balances.export');

    // Evaluations
    Route::post('/evaluations', [EvaluationController::class, 'store'])->name('evaluations.store');
    Route::get('/evaluations/{evaluation}/edit', [EvaluationController::class, 'edit'])->name('evaluations.edit');
    Route::put('/evaluations/{evaluation}', [EvaluationController::class, 'update'])->name('evaluations.update');
    Route::delete('/evaluations/{evaluation}', [EvaluationController::class, 'destroy'])->name('evaluations.destroy');
});
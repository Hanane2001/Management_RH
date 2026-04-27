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
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    // Register
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    // OTP Verification
    Route::get('/otp', [AuthController::class, 'showOtp'])->name('otp');
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify-otp');
    
    // Password Reset
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot-password');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset-password');
    Route::get('/reset-otp', [AuthController::class, 'showResetOtp'])->name('reset-otp');
    Route::post('/verify-reset-otp', [AuthController::class, 'verifyResetOtp'])->name('verify-reset-otp');
    Route::get('/change-password', [AuthController::class, 'showChangePassword'])->name('change-password');
    Route::post('/change-password', [AuthController::class, 'changePassword']);
});

// Auth
Route::middleware(['auth'])->group(function () {
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('show');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/', [ProfileController::class, 'update'])->name('update');
        Route::get('/change-password', [ProfileController::class, 'showChangePassword'])->name('change-password');
        Route::put('/password', [ProfileController::class, 'changePassword'])->name('update-password');
    });
    
    // Departments
    Route::prefix('departments')->name('departments.')->group(function () {
        Route::get('/', [DepartmentController::class, 'index'])->name('index');
        Route::get('/create', [DepartmentController::class, 'create'])->name('create');
        Route::get('/{id}', [DepartmentController::class, 'show'])->name('show');
    });
    
    // Contracts
    Route::resource('contracts', ContractController::class);
    
    // Leaves
    Route::prefix('leaves')->name('leaves.')->group(function () {
        Route::get('/', [LeaveController::class, 'index'])->name('index');
        Route::get('/create', [LeaveController::class, 'create'])->name('create');
        Route::post('/', [LeaveController::class, 'store'])->name('store');
        Route::get('/{leave}', [LeaveController::class, 'show'])->name('show');
        Route::get('/balance/my', [LeaveController::class, 'balance'])->name('balance');
    });
    
    // Leave Balances
    Route::get('/my-balance', [LeaveBalanceController::class, 'myBalance'])->name('leave-balances.my');
    
    // Evaluations
    Route::prefix('evaluations')->name('evaluations.')->group(function () {
        Route::get('/', [EvaluationController::class, 'index'])->name('index');
        Route::get('/statistics', [EvaluationController::class, 'statistics'])->name('statistics');
        Route::get('/{evaluation}', [EvaluationController::class, 'show'])->name('show');
    });
    
    // Documents
    Route::prefix('documents')->name('documents.')->group(function () {
        Route::get('/', [DocumentController::class, 'index'])->name('index');
        Route::get('/create', [DocumentController::class, 'create'])->name('create');
        Route::post('/', [DocumentController::class, 'store'])->name('store');
        Route::get('/{document}', [DocumentController::class, 'show'])->name('show');
        Route::get('/{document}/download', [DocumentController::class, 'download'])->name('download');
        Route::get('/{document}/edit', [DocumentController::class, 'edit'])->name('edit');
        Route::put('/{document}', [DocumentController::class, 'update'])->name('update');
        Route::delete('/{document}', [DocumentController::class, 'destroy'])->name('destroy');
        Route::get('/employee/{employeeId}', [DocumentController::class, 'employeeDocuments'])->name('employee');
    });
    
    // Attendances
    Route::prefix('attendances')->name('attendances.')->group(function () {
        Route::get('/', [AttendanceController::class, 'index'])->name('index');
        Route::get('/create', [AttendanceController::class, 'create'])->name('create');
        Route::post('/', [AttendanceController::class, 'store'])->name('store');
        Route::get('/report', [AttendanceController::class, 'report'])->name('report');
        Route::get('/{attendance}', [AttendanceController::class, 'show'])->name('show');
        Route::post('/check-in', [AttendanceController::class, 'checkIn'])->name('check-in');
        Route::post('/check-out', [AttendanceController::class, 'checkOut'])->name('check-out');
        Route::get('/{attendance}/edit', [AttendanceController::class, 'edit'])->name('edit');
        Route::put('/{attendance}', [AttendanceController::class, 'update'])->name('update');
        Route::delete('/{attendance}', [AttendanceController::class, 'destroy'])->name('destroy');
    });
    
    // Payrolls
    Route::prefix('payrolls')->name('payrolls.')->group(function () {
        Route::get('/', [PayrollController::class, 'index'])->name('index');
        Route::get('/create', [PayrollController::class, 'create'])->name('create');
        Route::post('/', [PayrollController::class, 'store'])->name('store');
        Route::get('/{payroll}', [PayrollController::class, 'show'])->name('show');
        Route::get('/{payroll}/edit', [PayrollController::class, 'edit'])->name('edit');
        Route::put('/{payroll}', [PayrollController::class, 'update'])->name('update');
        Route::delete('/{payroll}', [PayrollController::class, 'destroy'])->name('destroy');
        Route::post('/generate-from-contract', [PayrollController::class, 'generateFromContract'])->name('generate-from-contract');
        Route::post('/generate-all', [PayrollController::class, 'generateAll'])->name('generate-all');
        Route::post('/{payroll}/approve', [PayrollController::class, 'approve'])->name('approve');
        Route::post('/{payroll}/mark-paid', [PayrollController::class, 'markAsPaid'])->name('mark-paid');
    });
    
    // Notifications
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::get('/create', [NotificationController::class, 'create'])->name('create');
        Route::post('/', [NotificationController::class, 'store'])->name('store');
        Route::get('/{notification}', [NotificationController::class, 'show'])->name('show');
        Route::get('/{notification}/edit', [NotificationController::class, 'edit'])->name('edit');
        Route::put('/{notification}', [NotificationController::class, 'update'])->name('update');
        Route::delete('/{notification}', [NotificationController::class, 'destroy'])->name('destroy');
        Route::post('/{notification}/mark-read', [NotificationController::class, 'markAsRead'])->name('mark-read');
        Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
        Route::delete('/delete-all', [NotificationController::class, 'deleteAll'])->name('delete-all');
        Route::post('/send-bulk', [NotificationController::class, 'sendBulk'])->name('send-bulk');
    });
});

Route::middleware(['auth', 'admin'])->group(function () {
    // Employees
    Route::resource('employees', EmployeeController::class);
    Route::post('/employees/{employee}/approve', [EmployeeController::class, 'approve'])->name('employees.approve');
    
    // Departments
    Route::prefix('departments')->name('departments.')->group(function () {
        Route::post('/', [DepartmentController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [DepartmentController::class, 'edit'])->name('edit');
        Route::put('/{id}', [DepartmentController::class, 'update'])->name('update');
        Route::delete('/{id}', [DepartmentController::class, 'destroy'])->name('destroy');
    });
    
    // Leave Balances
    Route::prefix('leave-balances')->name('leave-balances.')->group(function () {
        Route::get('/', [LeaveBalanceController::class, 'index'])->name('index');
        Route::get('/create', [LeaveBalanceController::class, 'create'])->name('create');
        Route::post('/', [LeaveBalanceController::class, 'store'])->name('store');
        Route::get('/{leaveBalance}', [LeaveBalanceController::class, 'show'])->name('show');
        Route::get('/{leaveBalance}/edit', [LeaveBalanceController::class, 'edit'])->name('edit');
        Route::put('/{leaveBalance}', [LeaveBalanceController::class, 'update'])->name('update');
        Route::delete('/{leaveBalance}', [LeaveBalanceController::class, 'destroy'])->name('destroy');
        Route::post('/initialize', [LeaveBalanceController::class, 'initializeYear'])->name('initialize');
        Route::post('/{leaveBalance}/add-days', [LeaveBalanceController::class, 'addDays'])->name('add-days');
        Route::get('/statistics', [LeaveBalanceController::class, 'statistics'])->name('statistics');
    });
    
    // Evaluations
    Route::prefix('evaluations')->name('evaluations.')->group(function () {
        Route::get('/create', [EvaluationController::class, 'create'])->name('create');
        Route::post('/', [EvaluationController::class, 'store'])->name('store');
        Route::get('/{evaluation}/edit', [EvaluationController::class, 'edit'])->name('edit');
        Route::put('/{evaluation}', [EvaluationController::class, 'update'])->name('update');
        Route::delete('/{evaluation}', [EvaluationController::class, 'destroy'])->name('destroy');
    });
    
    // Audit Logs
    Route::prefix('audit-logs')->name('audit-logs.')->group(function () {
        Route::get('/', [AuditLogController::class, 'index'])->name('index');
        Route::get('/dashboard', [AuditLogController::class, 'dashboard'])->name('dashboard');
        Route::get('/{auditLog}', [AuditLogController::class, 'show'])->name('show');
        Route::delete('/clean', [AuditLogController::class, 'clean'])->name('clean');
        Route::get('/entity/{entityType}/{entityId}', [AuditLogController::class, 'forEntity'])->name('entity');
        Route::get('/user/{userId}', [AuditLogController::class, 'forUser'])->name('user');
    });
});

Route::middleware(['auth', 'manager'])->group(function () {
    // Leaves
    Route::prefix('leaves')->name('leaves.')->group(function () {
        Route::post('/{leave}/approve', [LeaveController::class, 'approve'])->name('approve');
        Route::post('/{leave}/reject', [LeaveController::class, 'reject'])->name('reject');
        Route::get('/balances/all', [LeaveController::class, 'allBalances'])->name('all-balances');
    });
    
    // Leave Balances
    Route::prefix('leave-balances')->name('leave-balances.')->group(function () {
        Route::get('/', [LeaveBalanceController::class, 'index'])->name('index');
        Route::get('/{leaveBalance}', [LeaveBalanceController::class, 'show'])->name('show');
        Route::get('/statistics', [LeaveBalanceController::class, 'statistics'])->name('statistics');
    });
    
    // Evaluations
    Route::prefix('evaluations')->name('evaluations.')->group(function () {
        Route::get('/create', [EvaluationController::class, 'create'])->name('create');
        Route::post('/', [EvaluationController::class, 'store'])->name('store');
        Route::get('/{evaluation}/edit', [EvaluationController::class, 'edit'])->name('edit');
        Route::put('/{evaluation}', [EvaluationController::class, 'update'])->name('update');
        Route::delete('/{evaluation}', [EvaluationController::class, 'destroy'])->name('destroy');
    });
});

Route::middleware(['auth'])->prefix('api')->name('api.')->group(function () {
    // Notifications
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
    Route::get('/notifications/recent', [NotificationController::class, 'getRecent'])->name('notifications.recent');
    
    // Dashboard statistics
    Route::get('/dashboard/stats', function () {
        return response()->json([
            'user' => auth()->user()->getFullName(),
            'role' => auth()->user()->role->name ?? 'N/A'
        ]);
    })->name('dashboard.stats');
});

// Fallback Route (404)
Route::fallback(function () {
    return redirect('/dashboard')->with('error', 'Page not found');
});
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Contract;
use App\Models\Leave;
use App\Models\LeaveBalance;
use App\Models\Department;
use App\Models\Evaluation;
use App\Models\Document;
use App\Models\Attendance;
use App\Models\Payroll;
use App\Models\Notification;
use App\Policies\UserPolicy;
use App\Policies\ContractPolicy;
use App\Policies\LeavePolicy;
use App\Policies\LeaveBalancePolicy;
use App\Policies\DepartmentPolicy;
use App\Policies\EvaluationPolicy;
use App\Policies\DocumentPolicy;
use App\Policies\AttendancePolicy;
use App\Policies\PayrollPolicy;
use App\Policies\NotificationPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Contract::class, ContractPolicy::class);
        Gate::policy(Leave::class, LeavePolicy::class);
        Gate::policy(LeaveBalance::class, LeaveBalancePolicy::class);
        Gate::policy(Department::class, DepartmentPolicy::class);
        Gate::policy(Evaluation::class, EvaluationPolicy::class);
        Gate::policy(Document::class, DocumentPolicy::class);
        Gate::policy(Attendance::class, AttendancePolicy::class);
        Gate::policy(Payroll::class, PayrollPolicy::class);
        Gate::policy(Notification::class, NotificationPolicy::class);

        Gate::define('isAdmin', fn(User $user) => $user->isAdmin());
        Gate::define('isManager', fn(User $user) => $user->isManager());
        Gate::define('isEmployee', fn(User $user) => $user->isEmployee());

        Gate::define('manage-contracts', fn(User $user) => $user->isAdmin() || $user->isManager());
        Gate::define('manage-employees', fn(User $user) => $user->isAdmin());
        Gate::define('manage-leaves', fn(User $user) => $user->isAdmin() || $user->isManager());
        Gate::define('view-reports', fn(User $user) => $user->isAdmin() || $user->isManager());
        Gate::define('manage-departments', fn(User $user) => $user->isAdmin());
    }
}

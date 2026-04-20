<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Payroll;

class PayrollPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Payroll $payroll): bool
    {
        if ($user->isAdmin()) return true;
        
        if ($user->isManager()) {
            return $payroll->employee->department_id === $user->department_id;
        }
        
        return $payroll->employee_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isManager();
    }

    public function update(User $user, Payroll $payroll): bool
    {
        if ($user->isAdmin()) return true;
        
        if ($user->isManager()) {
            return $payroll->employee->department_id === $user->department_id;
        }
        
        return false;
    }

    public function delete(User $user, Payroll $payroll): bool
    {
        return $user->isAdmin();
    }

    public function approve(User $user): bool
    {
        return $user->isAdmin() || $user->isManager();
    }

    public function markAsPaid(User $user): bool
    {
        return $user->isAdmin();
    }
}

<?php

namespace App\Policies;

use App\Models\User;
use App\Models\LeaveBalance;

class LeaveBalancePolicy
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
        return $user->isAdmin() || $user->isManager();
    }

    public function view(User $user, LeaveBalance $leaveBalance): bool
    {
        if ($user->isAdmin()) return true;
        if ($user->isManager()) {
            return $leaveBalance->employee->department_id === $user->department_id;
        }
        return $leaveBalance->employee_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, LeaveBalance $leaveBalance): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, LeaveBalance $leaveBalance): bool
    {
        return $user->isAdmin();
    }

    public function addDays(User $user): bool
    {
        return $user->isAdmin();
    }

    public function initialize(User $user): bool
    {
        return $user->isAdmin();
    }

    public function export(User $user): bool
    {
        return $user->isAdmin() || $user->isManager();
    }
}

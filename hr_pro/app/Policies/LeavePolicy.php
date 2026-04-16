<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Leave;

class LeavePolicy
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

    public function view(User $user, Leave $leave): bool
    {
        if ($user->isAdmin()) return true;
        if ($user->isManager()) {
            return $leave->employee->department_id === $user->department_id;
        }
        return $leave->employee_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isEmployee();
    }

    public function process(User $user, Leave $leave): bool
    {
        if ($user->isAdmin()) return true;
        if ($user->isManager()) {
            return $leave->employee->department_id === $user->department_id;
        }
        return false;
    }

    public function delete(User $user, Leave $leave): bool
    {
        return ($leave->employee_id === $user->id && $leave->isPending()) || $user->isAdmin();
    }
}

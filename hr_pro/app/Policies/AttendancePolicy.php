<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Attendance;

class AttendancePolicy
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

    public function view(User $user, Attendance $attendance): bool
    {
        if ($user->isAdmin()) return true;
        
        if ($user->isManager()) {
            return $attendance->employee->department_id === $user->department_id;
        }
        
        return $attendance->employee_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isManager();
    }

    public function update(User $user, Attendance $attendance): bool
    {
        if ($user->isAdmin()) return true;
        
        if ($user->isManager()) {
            return $attendance->employee->department_id === $user->department_id;
        }
        
        return false;
    }

    public function delete(User $user, Attendance $attendance): bool
    {
        return $user->isAdmin();
    }
}

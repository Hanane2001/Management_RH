<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Evaluation;

class EvaluationPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function view(User $user, Evaluation $evaluation): bool
    {
        if ($user->isAdmin()) return true;
        if ($user->isManager()) {
            return $evaluation->employee->department_id === $user->department_id;
        }
        return $evaluation->employee_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isManager();
    }

    public function update(User $user, Evaluation $evaluation = null): bool
    {
        if ($user->isAdmin()) return false;
        if ($user->isManager()) {
            if ($evaluation) {
                return $evaluation->employee->department_id === $user->department_id;
            }
            return true;
        }
        return false;
    }

    public function delete(User $user, Evaluation $evaluation = null): bool
    {
        if ($user->isAdmin()) return false;
        if ($user->isManager()) {
            if ($evaluation) {
                return $evaluation->employee->department_id === $user->department_id;
            }
            return true;
        }
        return false;
    }
}

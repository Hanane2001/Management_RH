<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Contract;

class ContractPolicy
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

    public function view(User $user, Contract $contract): bool
    {
        if ($user->isAdmin()) return true;
        if ($user->isManager()) {
            return $contract->employee->department_id === $user->department_id;
        }
        return $contract->employee_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isManager();
    }

    public function update(User $user, Contract $contract): bool
    {
        if ($user->isAdmin()) return true;
        if ($user->isManager()) {
            return $contract->employee->department_id === $user->department_id;
        }
        return false;
    }

    public function delete(User $user, Contract $contract): bool
    {
        return $user->isAdmin() || $user->isManager();
    }
}

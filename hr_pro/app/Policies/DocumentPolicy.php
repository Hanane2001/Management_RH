<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Document;

class DocumentPolicy
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

    public function view(User $user, Document $document): bool
    {
        if ($user->isAdmin()) return true;
        
        if ($user->isManager()) {
            return $document->employee->department_id === $user->department_id;
        }
        
        return $document->employee_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isManager() || $user->isEmployee();
    }

    public function update(User $user, Document $document): bool
    {
        if ($user->isAdmin()) return true;
        
        if ($user->isManager()) {
            return $document->employee->department_id === $user->department_id;
        }
        
        return $document->employee_id === $user->id;
    }

    public function delete(User $user, Document $document): bool
    {
        if ($user->isAdmin()) return true;
        
        if ($user->isManager()) {
            return $document->employee->department_id === $user->department_id;
        }
        
        return $document->employee_id === $user->id;
    }
}

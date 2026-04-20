<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Notification;

class NotificationPolicy
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

    public function view(User $user, Notification $notification): bool
    {
        if ($user->isAdmin()) return true;
        
        if ($user->isManager()) {
            return $notification->user->department_id === $user->department_id || $notification->user_id === $user->id;
        }
        
        return $notification->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isManager();
    }

    public function update(User $user, Notification $notification): bool
    {
        if ($user->isAdmin()) return true;
        
        if ($user->isManager()) {
            return $notification->user->department_id === $user->department_id;
        }
        
        return false;
    }

    public function delete(User $user, Notification $notification): bool
    {
        if ($user->isAdmin()) return true;
        
        if ($user->isManager()) {
            return $notification->user->department_id === $user->department_id;
        }
        
        return $notification->user_id === $user->id;
    }
}

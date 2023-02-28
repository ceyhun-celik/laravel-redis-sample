<?php

namespace App\Observers;

use App\Models\UserRole;
use Illuminate\Support\Facades\Cache;

class UserRoleObserver
{
    /**
     * Handle the UserRole "created" event.
     */
    public function created(UserRole $userRole): void
    {
        Cache::tags('users_collective')->flush();
        Cache::tags('users_individual')->forget($userRole->user_id);
    }

    /**
     * Handle the UserRole "updated" event.
     */
    public function updated(UserRole $userRole): void
    {
        Cache::tags('users_collective')->flush();
        Cache::tags('users_individual')->forget($userRole->user_id);
    }
}

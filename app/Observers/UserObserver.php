<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Cache;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        Cache::tags('users_collective')->flush();
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        Cache::tags('users_collective')->flush();
        Cache::tags('users_individual')->forget($user->id);
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        Cache::tags('users_collective')->flush();
        Cache::tags('users_individual')->forget($user->id);
    }
}

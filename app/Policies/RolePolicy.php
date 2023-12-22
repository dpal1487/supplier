<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Log;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function admin(User $user)
    {
        // dd($user);
        Log::info("Checking admin role for user: " . $user->id);
        return $user->roles->contains('slug', 'admin');
    }

    public function account(User $user)
    {
        Log::info("Checking account role for user: " . $user->id);

        return $user->roles->contains('slug', 'account');
    }
    public function user(User $user)
    {
        return $user->roles->contains('slug', 'user');
    }

    public function pm(User $user)
    {
        return $user->roles->contains('slug', 'pm');
    }
}

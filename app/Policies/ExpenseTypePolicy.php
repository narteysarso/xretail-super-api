<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExpenseTypePolicy
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

    public function before($user)
    {
        // dd($user);
        return $user->is_active;
    }

    public function create($user)
    {
        if ($user->hasRole('admin') || $user->hasRole('vendor')) {
            return true;
        }

        return false;
    }
    public function view($user)
    {
        if ($user->hasRole('admin') || $user->hasRole('clerk') || $user->hasRole('vendor')) {
            return true;
        }

        return false;
    }
    public function update($user)
    {
        if ($user->hasRole('admin') || $user->hasRole('clerk') || $user->hasRole('vendor')) {
            return true;
        }

        return false;
    }

     public function delete($user)
    {
        if ($user->hasRole('admin') || $user->hasRole('clerk') || $user->hasRole('vendor')) {
            return true;
        }

        return false;
    }
}

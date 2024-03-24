<?php

namespace App\Policies;

use App\User;
use App\Staff;
use Illuminate\Auth\Access\HandlesAuthorization;

class StaffPolicy
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

    public function add($user)
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return false;
    }
    public function view($user)
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return false;
    }

    public function update($user, Staff $staff)
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return false;
    }


    public function remove($user, Staff $staff)
    {
        if ($user->hasRole('admin') && $user->id !== auth()->user->id) {
            return true;
        }

        return false;
    }


    public function activate($user, Staff $staff)
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return false;
    }
    public function deactivate($user, Staff $staff)
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return false;
    }
    public function addRole($user, Staff $staff)
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return false;
    }
    public function removeRole($user, Staff $staff)
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return false;
    }
}

<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CreditPolicy
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

    public function view($user)
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return false;
    }

    public function create($user)
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return false;
    }

    public function update($user, Product $product)
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return false;
    }


    public function delete($user, Product $product)
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return false;
    }
}

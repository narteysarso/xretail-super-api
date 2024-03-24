<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaxPolicy
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
        return $user->is_active;
    }

    public function create($user)
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return false;
    }
}

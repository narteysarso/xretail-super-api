<?php

namespace App\Policies;

use App\User;
use App\Staff;
use App\Invoice;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvoicePolicy
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

    public function invalidate($user)
    {
        if ($user->hasRole('admin') || $user->hasRole('vendor')) {
            return true;
        }

        return false;
    }

    public function generatePdf($user, $invoice)
    {
        dd($invoice);
        if ($user->hasRole('admin') || $user->hasRole('vendor')) {
            return true;
        }

        return false;
    }
}

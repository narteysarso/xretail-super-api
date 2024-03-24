<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Staff' => 'App\Policies\StaffPolicy',
        'App\Invoice' => 'App\Policies\InvoicePolicy',
        'App\Product' => 'App\Policies\ProductPolicy',
        'App\InvoiceNumber' => 'App\Policies\InvoiceNumberPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();
        //
    }
}

<?php

namespace App\Providers;

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
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //Implicitly grant "Admin" role all permissions
        //This works in the app by using gate-related function like auth()->user->can() and @can
         Gate::before(function ($user,$ability){
            if ($user->hasRole('Admin')){
                return true;
            }
        });
    }
}

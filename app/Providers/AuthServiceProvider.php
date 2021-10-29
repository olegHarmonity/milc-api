<?php

namespace App\Providers;

use App\Util\UserRoles;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
         'App\Models\User' => 'App\Policies\UserPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin', function ($user) {
            return $user->role == UserRoles::$ROLE_ADMIN;
        });

        Gate::define('organisation_admin', function ($user) {
            return $user->role ==  UserRoles::$ROLE_COMPANY_ADMIN;
        });
    }
}

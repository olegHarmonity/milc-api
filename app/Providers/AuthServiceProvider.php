<?php

namespace App\Providers;

use App\Models\Image;
use App\Models\Organisation;
use App\Models\OrganisationType;
use App\Models\User;
use App\Policies\ImagePolicy;
use App\Policies\OrganisationPolicy;
use App\Policies\OrganisationTypePolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Organisation::class => OrganisationPolicy::class,
        OrganisationType::class => OrganisationTypePolicy::class,
        Image::class => ImagePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}

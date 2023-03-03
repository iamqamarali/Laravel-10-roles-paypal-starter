<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\Response;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {

        Gate::define('viewAny-group', function ($user) {
            return $user->hasRole('super-admin|admin')
                     ? Response::allow()
                     : Response::denyAsNotFound();;
        });

        Gate::define('create-group', function ($user) {
            return $user->hasRole('super-admin|admin')
                        ? Response::allow()
                        : Response::denyAsNotFound();
        });


        Gate::define('delete-group', function($user){
            return $user->hasRole('super-admin')
                        ? Response::allow()
                        : Response::denyAsNotFound();
        });

    }
}

<?php

namespace App\Providers;

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
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->registerSuperAdmin();
        $this->registerUserRead();
        $this->registerUserCreate();
    }
    public function registerSuperAdmin()
    {
        Gate::before(function ($user) {
            return checkUserPermission($user, 'super-admin') ? true : null;
        });
    }

    public function registerUserRead()
    {
        Gate::define('user-read', function () {
            return true;
        });
    }

    public function registerUserCreate()
    {
        Gate::define('user-create', function ($user) {
            return checkUserPermission($user, 'user-create');
        });
    }

    public function registerUserEdit()
    {
        Gate::define('user-edit', function ($user) {
            return checkUserPermission($user, 'user-edit');
        });
    }
}

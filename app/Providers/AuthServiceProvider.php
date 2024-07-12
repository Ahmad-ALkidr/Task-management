<?php

namespace App\Providers;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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
        $this->registerPolicies();
        //Gate Porject

        Gate::define('create-project', function ($user) {
            return $user->role === 'manager';
        });
        Gate::define('delete-project', function ($user) {
            return $user->role === 'manager';
        });
        // Gate::define('create', function (User $user) {
        //     return $user->role === 'manager';
        // });


        //Gate Task
        Gate::define('create-task', function ($user) {
            return $user->role === 'manager';
        });
        Gate::define('delete-task', function ($user) {
            return $user->role === 'manager';
        });

    }
}

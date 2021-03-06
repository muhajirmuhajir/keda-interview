<?php

namespace App\Providers;

use App\Models\User;
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
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('view-all-chat', function (User $user) {
            return $user->user_type_id == User::STAFF;
        });
        Gate::define('view-all-customer', function (User $user) {
            return $user->user_type_id == User::STAFF;
        });
        Gate::define('delete-customer', function (User $user) {
            return $user->user_type_id == User::STAFF;
        });
    }
}

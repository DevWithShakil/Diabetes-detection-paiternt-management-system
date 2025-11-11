<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{

    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        // ✅ Define Role Gates
        Gate::define('admin', function (User $user) {
            return $user->role === 'admin';
        });

        Gate::define('doctor', function (User $user) {
            return $user->role === 'doctor';
        });

        Gate::define('patient', function (User $user) {
            return $user->role === 'patient';
        });

    }
}

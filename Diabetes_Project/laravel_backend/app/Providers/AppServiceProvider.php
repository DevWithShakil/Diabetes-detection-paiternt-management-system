<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::define('admin', fn($user) => $user->role === 'admin');
        Gate::define('doctor', fn($user) => $user->role === 'doctor');
        Gate::define('patient', fn($user) => $user->role === 'patient');
    }
}

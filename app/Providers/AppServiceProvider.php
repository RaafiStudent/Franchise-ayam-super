<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Gate untuk mengecek apakah user adalah Admin
        Gate::define('is-admin', function (User $user) {
            return $user->role === 'admin';
        });

        // Gate untuk mengecek apakah user adalah Owner
        Gate::define('is-owner', function (User $user) {
            return $user->role === 'owner';
        });

        // Gate untuk akses Dashboard (Admin & Owner)
        Gate::define('view-reports', function (User $user) {
            return in_array($user->role, ['admin', 'owner']);
        });
    }
}
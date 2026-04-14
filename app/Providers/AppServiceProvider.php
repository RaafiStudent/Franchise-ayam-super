<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Carbon; 
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // 1. SETTING LOKALISASI (BAHASA INDONESIA)
        // id_ID untuk Linux/Server, Indonesian untuk Windows/Laragon
        setlocale(LC_TIME, 'id_ID', 'Indonesian_indonesia.1252'); 
        Carbon::setLocale('id');

        // Biar locale Laravel ikut ke Indonesia juga secara runtime
        config(['app.locale' => 'id']);

        // 2. DEFINISI GATE (HAK AKSES)
        
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
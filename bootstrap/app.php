<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Daftarkan alias middleware di sini
        $middleware->alias([
            'role' => \App\Http\Middleware\EnsureUserHasRole::class,
            'is_active' => \App\Http\Middleware\IsActive::class, // INI YANG TERLEWAT, SEKARANG SUDAH DITAMBAHKAN
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
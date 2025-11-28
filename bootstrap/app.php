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
    ->withMiddleware(function (Middleware $middleware): void {

        // --- TAMBAHKAN BAGIAN INI ---
        $middleware->validateCsrfTokens(except: [
            'midtrans-callback', // Izinkan route ini diakses tanpa token
        ]);
        // ----------------------------

        // Tambahkan alias middleware custom kamu di sini
        $middleware->alias([
            'is_active' => \App\Http\Middleware\EnsureUserIsActive::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();

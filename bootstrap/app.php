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
        
        // 1. BERI IZIN KHUSUS UNTUK MIDTRANS (PENTING!)
        // Supaya tidak muncul error 419 di Ngrok
        $middleware->validateCsrfTokens(except: [
            'midtrans-callback', // Sesuaikan dengan route di dashboard Midtrans kamu
        ]);

        // 2. DAFTARKAN ALIAS MIDDLEWARE (Punya kamu sudah benar)
        $middleware->alias([
            'role' => \App\Http\Middleware\EnsureUserHasRole::class,
            'is_active' => \App\Http\Middleware\IsActive::class, 
        ]);
        
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Cek apakah user sudah login
        if (!$request->user()) {
            return redirect()->route('login');
        }

        // 2. Cek apakah role user sesuai dengan yang diminta di route
        if ($request->user()->role !== $role) {
            // Jika tidak sesuai, arahkan ke dashboard masing-masing atau beranda
            return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        return $next($request);
    }
}
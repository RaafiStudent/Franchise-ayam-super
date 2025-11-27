<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsActive
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login DAN statusnya BUKAN 'active'
        if (Auth::check() && Auth::user()->status !== 'active') {
            
            // Jika Admin, boleh lewat
            if (Auth::user()->role === 'admin') {
                return $next($request);
            }

            // Jika Mitra Pending/Banned, tendang keluar
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('approval.notice');
        }

        return $next($request);
    }
}
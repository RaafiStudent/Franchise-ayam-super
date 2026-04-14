<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsActive
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan user sudah login
        if (Auth::check()) {
            $status = Auth::user()->status;

            // Jika statusnya PENDING, lempar ke halaman pemberitahuan
            if ($status === 'pending') {
                return redirect()->route('approval.notice');
            }

            // Jika statusnya BANNED (Blokir), paksa logout dan lempar ke halaman login
            if ($status === 'banned') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                return redirect('/login')->with('error', 'Akun Anda telah diblokir. Silakan hubungi Administrator Pusat.');
            }
        }

        // Jika statusnya ACTIVE, izinkan masuk seperti biasa
        return $next($request);
    }
}
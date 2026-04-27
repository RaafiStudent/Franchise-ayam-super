<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman edit profil.
     */
    public function edit()
    {
        return view('profile.edit', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Memperbarui Password (Fitur Utama Keamanan).
     */
    public function updatePassword(Request $request)
    {
        // Validasi dengan Custom Message Bahasa Indonesia
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'current_password.current_password' => 'GAGAL: Password lama yang Anda masukkan SALAH!',
            'password.required' => 'Password baru wajib diisi.',
            'password.confirmed' => 'GAGAL: Konfirmasi password baru TIDAK COCOK / TIDAK SAMA!',
            'password.min' => 'Password baru minimal harus 8 karakter.'
        ]);

        // Jika lolos validasi, update passwordnya
        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('profile.edit')->with('status', 'password-updated');
    }
}
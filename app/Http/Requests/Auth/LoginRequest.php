<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginRequest extends FormRequest
{
    /**
     * Menentukan apakah pengguna diizinkan untuk membuat request ini.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Aturan validasi yang diterapkan pada request saat login.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * KAMUS BAHASA INDONESIA: Pesan error khusus jika form kosong atau salah ketik.
     */
    public function messages(): array
    {
        return [
            'email.required' => 'Alamat email tidak boleh kosong.',
            'email.email' => 'Format email tidak valid (harus menggunakan @).',
            'password.required' => 'Password tidak boleh kosong.',
            'password.min' => 'Password minimal harus 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.'
        ];
    }

    /**
     * Mencoba memproses autentikasi login pengguna.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        // 1. KITA CEK EMAILNYA DULU
        $user = User::where('email', $this->email)->first();

        if (! $user) {
            RateLimiter::hit($this->throttleKey());
            
            // JIKA EMAIL TIDAK ADA DI DATABASE -> ERROR DI BAWAH EMAIL
            throw ValidationException::withMessages([
                'email' => 'Alamat email ini belum terdaftar di sistem kami.',
            ]);
        }

        // 2. JIKA EMAIL BENAR, KITA CEK PASSWORDNYA
        if (! Hash::check($this->password, $user->password)) {
            RateLimiter::hit($this->throttleKey());
            
            // JIKA PASSWORD SALAH -> ERROR DI BAWAH PASSWORD
            throw ValidationException::withMessages([
                'password' => 'Password yang Anda masukkan salah. Silakan coba lagi.',
            ]);
        }

        // 3. JIKA EMAIL DAN PASSWORD BENAR -> LOGIN SUKSES
        Auth::login($user, $this->boolean('remember'));
        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Memastikan request login tidak melebihi batas (Anti-Spam / Bruteforce).
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => 'Terlalu banyak percobaan login. Silakan tunggu ' . $seconds . ' detik.',
        ]);
    }

    /**
     * Mendapatkan kunci batasan (throttle key) untuk request ini.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('email')).'|'.$this->ip());
    }
}
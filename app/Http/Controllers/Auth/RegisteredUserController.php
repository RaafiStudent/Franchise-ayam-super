<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

// ========================================================
// TAMBAHAN WAJIB UNTUK FITUR NOTIFIKASI
// ========================================================
use App\Notifications\SystemNotification;
use Illuminate\Support\Facades\Notification;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi Input
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'no_hp' => ['required', 'numeric'],
            'alamat_lengkap' => ['required', 'string'],
            'provinsi' => ['required', 'string'],
            'kota' => ['required', 'string'],
            'ktp_image' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'], // Max 2MB
        ]);

        // 2. Proses Upload KTP
        $ktpPath = null;
        if ($request->hasFile('ktp_image')) {
            // Simpan ke folder: storage/app/public/ktp
            $ktpPath = $request->file('ktp_image')->store('ktp', 'public');
        }

        // 3. Simpan ke Database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'mitra',           // Default jadi Mitra
            'status' => 'pending',       // Default Pending (tunggu admin)
            'no_hp' => $request->no_hp,
            'alamat_lengkap' => $request->alamat_lengkap,
            'provinsi' => $request->provinsi, // Kita simpan nama provinsinya
            'kota' => $request->kota,         // Kita simpan nama kotanya
            'ktp_image' => $ktpPath,
            'catatan' => $request->catatan,
        ]);

        // ========================================================
        // KODE BARU: TEMBAK NOTIFIKASI KE ADMIN ADA PENDAFTAR BARU
        // ========================================================
        $admins = User::where('role', 'admin')->get();
        if($admins->count() > 0) {
            $title = "Mitra Baru Mendaftar! 👤";
            $message = "Ada pendaftaran akun Mitra baru a.n {$user->name}. Segera cek dan lakukan verifikasi.";
            
            // Kita arahkan url-nya langsung ke halaman Manajemen User Admin
            $url = route('admin.users.index'); 
            
            Notification::send($admins, new SystemNotification($title, $message, $url));
        }
        // ========================================================

        event(new Registered($user));

        // Catatan: Karena statusnya 'pending', kita tidak me-login-kan user secara otomatis.
        // Langsung di-redirect ke halaman pemberitahuan (approval.notice). Ini sudah SANGAT TEPAT!
        return redirect()->route('approval.notice');
    }
}
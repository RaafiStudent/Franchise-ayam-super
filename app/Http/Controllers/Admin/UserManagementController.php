<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Storage; // Tambahan untuk fitur upload

class UserManagementController extends Controller
{
    private function logActivity($action, $targetName, $details = null)
    {
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'target_user' => $targetName,
            'description' => $details,
            'ip_address' => request()->ip(),
        ]);
    }

    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid (harus memakai @).',
            'email.unique' => 'Email ini sudah terdaftar! Silakan gunakan email lain.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'password.min' => 'Kata sandi minimal harus 8 karakter.',
            'ktp_photo.image' => 'File KTP harus berupa gambar (JPG, PNG).',
            'ktp_photo.max' => 'Ukuran foto KTP maksimal 2MB.',
        ];

        // Validasi Dasar
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:admin,owner,mitra'],
            'status' => ['required', 'in:active,pending,banned'],
        ];

        // Jika Role adalah Mitra, tambahkan validasi untuk data pelengkap
        if ($request->role === 'mitra') {
            $rules['phone'] = ['nullable', 'string', 'max:20'];
            $rules['address'] = ['nullable', 'string'];
            $rules['province'] = ['nullable', 'string', 'max:100'];
            $rules['city'] = ['nullable', 'string', 'max:100'];
            $rules['ktp_photo'] = ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'];
        }

        $request->validate($rules, $messages);

        // Siapkan data untuk disimpan
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => $request->status,
        ];

        // Masukkan data tambahan jika rolenya Mitra
        if ($request->role === 'mitra') {
            $data['phone'] = $request->phone;
            $data['address'] = $request->address;
            $data['province'] = $request->province;
            $data['city'] = $request->city;

            // Proses Upload Foto KTP
            if ($request->hasFile('ktp_photo')) {
                $data['ktp_photo'] = $request->file('ktp_photo')->store('mitra-ktp', 'public');
            }
        }

        $user = User::create($data);

        $this->logActivity('CREATE_USER', $user->name, "Menambahkan user baru dengan role: {$user->role}");

        return redirect()->route('admin.users.index')->with('success', 'Berhasil! Pengguna baru telah ditambahkan ke sistem.');
    }

    // ... (Fungsi edit, update, dan destroy TETAP SAMA seperti sebelumnya)
    public function edit(User $user) { return view('admin.users.edit', compact('user')); }
    
    public function update(Request $request, User $user)
    {
        $messages = [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.unique' => 'Email ini sudah dipakai oleh pengguna lain.',
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
        ];

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'role' => ['required', 'in:admin,owner,mitra'],
            'status' => ['required', 'in:active,pending,banned'],
        ];

        $request->validate($rules, $messages);

        $details = "Memperbarui data profil pengguna";
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status,
        ];

        if ($request->filled('password')) {
            $request->validate(['password' => ['confirmed', Rules\Password::defaults()]], $messages);
            $data['password'] = Hash::make($request->password);
            $details = "Memperbarui profil dan melakukan RESET KATA SANDI";
        }

        $user->update($data);
        $this->logActivity('UPDATE_USER', $user->name, $details);
        return redirect()->route('admin.users.index')->with('success', 'Mantap! Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) { return back()->with('error', 'Anda tidak bisa menghapus akun Anda sendiri!'); }
        $targetName = $user->name;
        $user->delete();
        $this->logActivity('DELETE_USER', $targetName, "Menghapus akun secara permanen");
        return redirect()->route('admin.users.index')->with('success', 'Data pengguna berhasil dihapus dari sistem.');
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

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
        // Kumpulan pesan error FULL BAHASA INDONESIA
        $messages = [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid (harus memakai @).',
            'email.unique' => 'Email ini sudah terdaftar! Silakan gunakan email lain.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'password.min' => 'Kata sandi minimal harus 8 karakter.',
            'role.in' => 'Pilihan hak akses (Role) tidak valid.',
            'status.in' => 'Pilihan status tidak valid.',
        ];

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:admin,owner,mitra'],
            'status' => ['required', 'in:active,pending,banned'], // Ditambah banned
        ], $messages);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => $request->status,
        ]);

        $this->logActivity('CREATE_USER', $user->name, "Menambahkan user baru dengan role: {$user->role}");

        return redirect()->route('admin.users.index')->with('success', 'Berhasil! Pengguna baru telah ditambahkan ke sistem.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // Kumpulan pesan error FULL BAHASA INDONESIA untuk fitur Edit
        $messages = [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah dipakai oleh pengguna lain.',
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok dengan yang diketik di atas.',
            'password.min' => 'Kata sandi baru minimal harus 8 karakter.',
            'role.in' => 'Pilihan hak akses (Role) tidak valid.',
            'status.in' => 'Pilihan status yang Anda masukkan tidak valid.',
        ];

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'role' => ['required', 'in:admin,owner,mitra'],
            'status' => ['required', 'in:active,pending,banned'], // Ditambah banned
        ], $messages);

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
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Anda tidak bisa menghapus akun Anda sendiri!');
        }

        $targetName = $user->name;
        $user->delete();

        $this->logActivity('DELETE_USER', $targetName, "Menghapus akun secara permanen");

        return redirect()->route('admin.users.index')->with('success', 'Data pengguna berhasil dihapus dari sistem.');
    }
}
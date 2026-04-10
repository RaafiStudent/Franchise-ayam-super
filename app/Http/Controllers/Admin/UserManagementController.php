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
        // 1. Kumpulan pesan error bahasa Indonesia
        $messages = [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar! Silakan gunakan email lain.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok dengan password di atas.',
            'password.min' => 'Password minimal harus 8 karakter.',
        ];

        // 2. Terapkan pesan error tersebut ke validasi
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:admin,owner,mitra'],
            'status' => ['required', 'in:active,pending'],
        ], $messages);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => $request->status,
        ]);

        $this->logActivity('CREATE_USER', $user->name, "Menambahkan user baru dengan role: {$user->role}");

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan ke dalam sistem!');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $messages = [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email ini sudah dipakai oleh user lain.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
            'password.min' => 'Password minimal harus 8 karakter.',
        ];

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'role' => ['required', 'in:admin,owner,mitra'],
            'status' => ['required', 'in:active,pending'],
        ], $messages);

        $details = "Memperbarui profil user";
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status,
        ];

        if ($request->filled('password')) {
            $request->validate(['password' => ['confirmed', Rules\Password::defaults()]], $messages);
            $data['password'] = Hash::make($request->password);
            $details = "Memperbarui profil dan melakukan RESET PASSWORD";
        }

        $user->update($data);

        $this->logActivity('UPDATE_USER', $user->name, $details);

        return redirect()->route('admin.users.index')->with('success', 'Data user berhasil diperbarui!');
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Anda tidak bisa menghapus akun sendiri!');
        }

        $targetName = $user->name;
        $user->delete();

        $this->logActivity('DELETE_USER', $targetName, "Menghapus akun user secara permanen");

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus!');
    }
}
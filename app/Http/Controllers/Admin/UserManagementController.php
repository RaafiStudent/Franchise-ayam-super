<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ActivityLog; // Tambahkan ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules;

class UserManagementController extends Controller
{
    /**
     * Fungsi Helper untuk mencatat Log Aktivitas
     */
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

    // Menampilkan daftar semua user
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    // Menampilkan form tambah user
    public function create()
    {
        return view('admin.users.create');
    }

    // Menyimpan user baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:admin,owner,mitra'],
            'status' => ['required', 'in:active,pending'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => $request->status,
        ]);

        // Catat Log Aktivitas
        $this->logActivity('CREATE_USER', $user->name, "Menambahkan user baru dengan role: {$user->role}");

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan!');
    }

    // Menampilkan form edit user
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // Memperbarui data user
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'role' => ['required', 'in:admin,owner,mitra'],
            'status' => ['required', 'in:active,pending'],
        ]);

        $details = "Memperbarui profil user";
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status,
        ];

        // Cek jika password diganti (Reset Password)
        if ($request->filled('password')) {
            $request->validate(['password' => ['confirmed', Rules\Password::defaults()]]);
            $data['password'] = Hash::make($request->password);
            $details = "Memperbarui profil dan melakukan RESET PASSWORD";
        }

        $user->update($data);

        // Catat Log Aktivitas
        $this->logActivity('UPDATE_USER', $user->name, $details);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui!');
    }

    // Menghapus user
    public function destroy(User $user)
    {
        // Mencegah admin menghapus dirinya sendiri
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Anda tidak bisa menghapus akun sendiri!');
        }

        $targetName = $user->name;
        $user->delete();

        // Catat Log Aktivitas
        $this->logActivity('DELETE_USER', $targetName, "Menghapus akun user secara permanen dari sistem");

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus!');
    }
}
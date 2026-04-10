<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Storage; 

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
            'ktp_image.image' => 'File KTP harus berupa gambar (JPG, PNG).',
            'ktp_image.max' => 'Ukuran foto KTP maksimal 2MB.',
        ];

        // Validasi Dasar (Role wajib ada saat CREATE)
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:admin,owner,mitra'],
            'status' => ['required', 'in:active,pending,banned'],
        ];

        // Validasi tambahan khusus Mitra
        if ($request->role === 'mitra') {
            $rules['no_hp'] = ['nullable', 'string', 'max:20'];
            $rules['alamat_lengkap'] = ['nullable', 'string'];
            $rules['provinsi'] = ['nullable', 'string', 'max:100'];
            $rules['kota'] = ['nullable', 'string', 'max:100'];
            $rules['ktp_image'] = ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'];
        }

        $request->validate($rules, $messages);

        // Siapkan data dasar
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => $request->status,
        ];

        // Masukkan data tambahan khusus Mitra
        if ($request->role === 'mitra') {
            $data['no_hp'] = $request->no_hp;
            $data['alamat_lengkap'] = $request->alamat_lengkap;
            $data['provinsi'] = $request->provinsi;
            $data['kota'] = $request->kota;

            if ($request->hasFile('ktp_image')) {
                $data['ktp_image'] = $request->file('ktp_image')->store('mitra-ktp', 'public');
            }
        }

        $user = User::create($data);

        $this->logActivity('CREATE_USER', $user->name, "Menambahkan user baru dengan role: {$user->role}");

        return redirect()->route('admin.users.index')->with('success', 'Berhasil! Pengguna baru telah ditambahkan ke sistem.');
    }

    public function edit(User $user) { return view('admin.users.edit', compact('user')); }
    
    public function update(Request $request, User $user)
    {
        $messages = [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.unique' => 'Email ini sudah dipakai oleh pengguna lain.',
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'ktp_image.image' => 'File KTP harus berupa gambar.',
            'ktp_image.max' => 'Ukuran foto maksimal 2MB.',
        ];

        // PERHATIKAN: Role sudah DIBUANG dari validasi update agar tidak error
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'status' => ['required', 'in:active,pending,banned'],
        ];

        // Validasi tambahan jika yang diedit adalah Mitra (mengambil role dari database)
        if ($user->role === 'mitra') {
            $rules['no_hp'] = ['nullable', 'string', 'max:20'];
            $rules['alamat_lengkap'] = ['nullable', 'string'];
            $rules['provinsi'] = ['nullable', 'string', 'max:100'];
            $rules['kota'] = ['nullable', 'string', 'max:100'];
            $rules['ktp_image'] = ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'];
        }

        $request->validate($rules, $messages);

        $details = "Memperbarui data profil pengguna";
        
        // PERHATIKAN: Role sudah DIBUANG dari data yang disimpan
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
        ];

        // Proses penyimpanan data khusus Mitra saat Update
        if ($user->role === 'mitra') {
            $data['no_hp'] = $request->no_hp;
            $data['alamat_lengkap'] = $request->alamat_lengkap;
            $data['provinsi'] = $request->provinsi;
            $data['kota'] = $request->kota;

            if ($request->hasFile('ktp_image')) {
                if ($user->ktp_image && Storage::disk('public')->exists($user->ktp_image)) {
                    Storage::disk('public')->delete($user->ktp_image);
                }
                $data['ktp_image'] = $request->file('ktp_image')->store('mitra-ktp', 'public');
            }
        }

        // Proses jika password diganti
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
        
        // Hapus foto KTP dari storage jika ada saat user dihapus
        if ($user->ktp_image && Storage::disk('public')->exists($user->ktp_image)) {
            Storage::disk('public')->delete($user->ktp_image);
        }

        $targetName = $user->name;
        $user->delete();
        $this->logActivity('DELETE_USER', $targetName, "Menghapus akun secara permanen");
        return redirect()->route('admin.users.index')->with('success', 'Data pengguna berhasil dihapus dari sistem.');
    }
}
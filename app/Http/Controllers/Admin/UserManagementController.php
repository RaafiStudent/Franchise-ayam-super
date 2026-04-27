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

    public function index(Request $request)
    {
        // 1. Tangkap kata kunci dari form pencarian
        $search = $request->input('search');

        // 2. Tarik data dari database dengan fitur filter
        $users = User::when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhere('email', 'like', "%{$search}%");
            })
            ->latest() // Urutkan dari yang terbaru
            ->paginate(10) // Batasi 10 per halaman
            ->withQueryString(); // Jaga kata kunci agar tidak hilang saat pindah halaman (pagination)

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
    
    public function update(Request $request, $id)
    {
        $user = \App\Models\User::findOrFail($id);

        // 1. Validasi Dasar (Berlaku untuk Semua Role)
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'status' => 'required|in:active,pending,banned',
        ];

        // 2. Validasi Khusus Mitra (Hanya dijalankan jika yang diedit adalah Mitra)
        if ($user->role === 'mitra') {
            $rules['no_hp'] = 'required|string|max:20';
            $rules['provinsi'] = 'required|string|max:100';
            $rules['kota'] = 'required|string|max:100';
            $rules['alamat_lengkap'] = 'required|string';
            
            // KTP opsional saat update, hanya divalidasi jika ada file baru yang diunggah
            if ($request->hasFile('ktp_image')) {
                $rules['ktp_image'] = 'image|mimes:jpeg,png,jpg|max:2048';
            }
        }

        // 3. LOGIKA PINTAR PASSWORD: Hanya divalidasi JIKA Admin mengetik sesuatu di kotak password
        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        // 4. Custom Pesan Error Bahasa Indonesia (Jas Jis Joss)
        $messages = [
            'required' => 'Kolom :attribute wajib diisi.',
            'email.unique' => 'Email ini sudah digunakan oleh pengguna lain.',
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
            'password.min' => 'Password minimal harus 8 karakter.'
        ];

        $validated = $request->validate($rules, $messages);

        // 5. Update Data Pengguna
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->status = $validated['status'];

        // Update data khusus Mitra
        if ($user->role === 'mitra') {
            $user->no_hp = $validated['no_hp'];
            $user->provinsi = $validated['provinsi'];
            $user->kota = $validated['kota'];
            $user->alamat_lengkap = $validated['alamat_lengkap'];

            // Proses upload KTP baru jika ada
            if ($request->hasFile('ktp_image')) {
                $path = $request->file('ktp_image')->store('ktp_images', 'public');
                $user->ktp_image = $path;
            }
        }

        // Enkripsi dan update password JIKA dimasukkan
        if ($request->filled('password')) {
            $user->password = \Illuminate\Support\Facades\Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Data pengguna ' . $user->name . ' berhasil diperbarui!');
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
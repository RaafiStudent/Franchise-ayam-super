<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // 1. Menampilkan Daftar Mitra (Yang Pending & Active)
    public function index()
    {
        // Ambil user yang role-nya 'mitra', urutkan yang pending paling atas
        $mitras = User::where('role', 'mitra')
            ->orderByRaw("FIELD(status, 'pending', 'active', 'banned')")
            ->latest()
            ->get();

        return view('admin.dashboard', compact('mitras'));
    }

    // 2. Proses ACC / Aktivasi Akun
    public function approve($id)
    {
        $mitra = User::findOrFail($id);
        $mitra->status = 'active'; // Ubah jadi Active
        $mitra->save();

        return redirect()->back()->with('success', 'Akun Mitra berhasil diaktifkan!');
    }
    
    // 3. Proses Blokir / Tolak
    public function reject($id)
    {
        $mitra = User::findOrFail($id);
        $mitra->status = 'banned'; // Ubah jadi Banned
        $mitra->save();

        return redirect()->back()->with('error', 'Akun Mitra dibekukan.');
    }
}
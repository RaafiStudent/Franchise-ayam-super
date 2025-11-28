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

    // 1. Tampilkan Semua Pesanan
    public function manageOrders()
    {
        // Urutkan: Yang 'paid' & 'processing' paling atas, baru history lainnya
        $orders = \App\Models\Order::with('user')
            ->orderByRaw("FIELD(order_status, 'processing', 'pending', 'shipped', 'completed', 'cancelled')")
            ->latest()
            ->get();

        return view('admin.orders.index', compact('orders'));
    }

    // 2. Update Resi & Kirim Barang
    public function shipOrder(Request $request, $id)
    {
        $request->validate([
            'resi_number' => 'required|string',
            'courier_name' => 'required|string',
        ]);

        $order = \App\Models\Order::findOrFail($id);
        
        $order->update([
            'resi_number' => $request->resi_number,
            'courier_name' => $request->courier_name,
            'order_status' => 'shipped' // Ubah status jadi DIKIRIM
        ]);

        return redirect()->back()->with('success', 'Resi berhasil diinput! Pesanan sedang dikirim.');
    }

}
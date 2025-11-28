<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;   // <--- Tambahan
use App\Models\Product; // <--- Tambahan
use Illuminate\Http\Request;
use Carbon\Carbon;      // <--- Tambahan untuk tanggal

class AdminController extends Controller
{
    // 1. Dashboard Utama (Statistik & Approval Mitra)
    public function index()
    {
        // A. Logika Approval Mitra (Yang lama)
        $mitras = User::where('role', 'mitra')
            ->orderByRaw("FIELD(status, 'pending', 'active', 'banned')")
            ->latest()
            ->get();

        // B. Logika Statistik (BARU)
        $today = Carbon::today();

        // 1. Total Omset Hari Ini (Hanya yang sudah PAID)
        $omsetHariIni = Order::whereDate('created_at', $today)
            ->where('payment_status', 'paid')
            ->sum('total_price');

        // 2. Jumlah Order Masuk Hari Ini
        $orderHariIni = Order::whereDate('created_at', $today)->count();

        // 3. Order Belum Dibayar (Total Pending)
        $belumDibayar = Order::where('payment_status', 'unpaid')->count();

        // 4. Stok Alert (Cari produk yang stoknya < 10)
        $stokMenipis = Product::where('stock', '<', 10)->get();

        return view('admin.dashboard', compact('mitras', 'omsetHariIni', 'orderHariIni', 'belumDibayar', 'stokMenipis'));
    }

    // 2. Proses ACC / Aktivasi Akun
    public function approve($id)
    {
        $mitra = User::findOrFail($id);
        $mitra->status = 'active'; 
        $mitra->save();
        return redirect()->back()->with('success', 'Akun Mitra berhasil diaktifkan!');
    }
    
    // 3. Proses Blokir / Tolak
    public function reject($id)
    {
        $mitra = User::findOrFail($id);
        $mitra->status = 'banned'; 
        $mitra->save();
        return redirect()->back()->with('error', 'Akun Mitra dibekukan.');
    }

    // --- MANAJEMEN PESANAN (ORDER) ---

    public function manageOrders()
    {
        $orders = Order::with('user')
            ->orderByRaw("FIELD(order_status, 'processing', 'pending', 'shipped', 'completed', 'cancelled')")
            ->latest()
            ->get();

        return view('admin.orders.index', compact('orders'));
    }

    public function shipOrder(Request $request, $id)
    {
        $request->validate([
            'resi_number' => 'required|string',
            'courier_name' => 'required|string',
        ]);

        $order = Order::findOrFail($id);
        
        $order->update([
            'resi_number' => $request->resi_number,
            'courier_name' => $request->courier_name,
            'order_status' => 'shipped'
        ]);

        return redirect()->back()->with('success', 'Resi berhasil diinput! Pesanan sedang dikirim.');
    }
}
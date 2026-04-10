<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Schema;

class OwnerController extends Controller
{
    public function index()
    {
        // Pengecekan cerdas: Apakah tabel 'orders' dan kolom 'status' sudah dibuat di database?
        // Ini mencegah error sebelum kita benar-benar membangun Modul Pemesanan nanti.
        $isOrderTableReady = Schema::hasTable('orders') && Schema::hasColumn('orders', 'status');

        $data = [
            // Jika tabel siap, hitung omset asli. Jika belum, tampilkan Rp 0.
            'total_omset' => $isOrderTableReady ? Order::where('status', 'completed')->sum('total_price') : 0,
            
            // Menghitung jumlah akun mitra yang ada di sistem
            'total_mitra' => User::where('role', 'mitra')->count(),
            
            // Jika tabel siap, ambil 5 pesanan terakhir. Jika belum, kirim data kosong (koleksi kosong).
            'pesanan_terbaru' => $isOrderTableReady ? Order::with('user')->latest()->take(5)->get() : collect([]),
        ];

        return view('owner.dashboard', $data);
    }
}
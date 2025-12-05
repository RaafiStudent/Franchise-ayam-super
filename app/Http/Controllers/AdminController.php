<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; // <--- PENTING! Jangan dihapus

class AdminController extends Controller
{
    // 1. Dashboard Utama (Statistik, Approval, & Widget Baru)
    public function index()
    {
        // A. Logika Approval Mitra (Ambil 5 terbaru saja)
        $mitras = User::where('role', 'mitra')
            ->orderByRaw("FIELD(status, 'pending', 'active', 'banned')")
            ->latest()
            ->take(5)
            ->get();

        // B. Logika Statistik Utama
        $today = Carbon::today();
        $omsetHariIni = Order::whereDate('created_at', $today)->where('payment_status', 'paid')->sum('total_price');
        $orderHariIni = Order::whereDate('created_at', $today)->count();
        $belumDibayar = Order::where('payment_status', 'unpaid')->count();
        
        // C. Stok Alert
        $stokMenipis = Product::where('stock', '<', 10)->get();

        // --- BAGIAN BARU (Penyebab Error Tadi) ---

        // D. WIDGET BARU: Top 5 Produk Terlaris
        // Menggabungkan tabel order_items dengan products untuk hitung jumlah terjual
        $topProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select('products.name', 'products.image', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->groupBy('products.id', 'products.name', 'products.image')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        // E. WIDGET BARU: Grafik Mini (Omset 7 Hari Terakhir)
        $startDate = Carbon::now()->subDays(6);
        $chartData = Order::where('payment_status', 'paid')
            ->where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, SUM(total_price) as total')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Siapkan data array untuk Chart.js di View
        $chartLabels = $chartData->pluck('date')->map(fn($date) => Carbon::parse($date)->isoFormat('dddd')); 
        $chartValues = $chartData->pluck('total');

        // F. Kirim SEMUA Variabel ke View (Jangan ada yang ketinggalan!)
        return view('admin.dashboard', compact(
            'mitras', 
            'omsetHariIni', 
            'orderHariIni', 
            'belumDibayar', 
            'stokMenipis', 
            'topProducts',   // <--- Ini yang tadi error (undefined)
            'chartLabels',   // <--- Ini buat grafik
            'chartValues'    // <--- Ini buat grafik
        ));
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
    public function manageOrders(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $orders = Order::with('user')
            ->when($search, function ($query, $search) {
                return $query->where('id', 'like', "%{$search}%")
                    ->orWhere('resi_number', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                          ->orWhere('kota', 'like', "%{$search}%");
                    });
            })
            ->orderByRaw("FIELD(order_status, 'processing', 'pending', 'shipped', 'completed', 'cancelled')")
            ->latest()
            ->paginate($perPage);

        $orders->appends(['search' => $search, 'per_page' => $perPage]);

        return view('admin.orders.index', compact('orders', 'search', 'perPage'));
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
<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Notifications\SystemNotification;
use Illuminate\Support\Facades\Notification; // Tambahan wajib untuk kirim ke banyak user (Owner)

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

        // B. Logika Statistik Utama (SINKRON DENGAN LAPORAN)
        $today = Carbon::today();
        
        // Omset Hari Ini (Hanya yang sudah bayar)
        $omsetHariIni = Order::whereDate('created_at', $today)
            ->where('payment_status', 'paid')
            ->sum('total_price');

        // Order Hari Ini (Hanya yang sudah bayar agar sinkron dengan nominal omset)
        $orderHariIni = Order::whereDate('created_at', $today)
            ->where('payment_status', 'paid') 
            ->count();

        // Pesanan yang masuk tapi belum dibayar hari ini
        $belumDibayar = Order::where('payment_status', 'unpaid')
            ->whereDate('created_at', $today)
            ->count();
        
        // C. Stok Alert
        $stokMenipis = Product::where('stock', '<', 10)->get();

        // D. WIDGET: Top 5 Produk Terlaris
        $topProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select('products.name', 'products.image', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->groupBy('products.id', 'products.name', 'products.image')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        // E. WIDGET: Grafik Mingguan (SINKRON DENGAN LAPORAN MINGGUAN: SENIN - MINGGU)
        $chartLabels = [];
        $chartValues = [];
        $startOfWeek = Carbon::now()->startOfWeek(); 

        for ($i = 0; $i < 7; $i++) {
            $date = $startOfWeek->copy()->addDays($i);
            $chartLabels[] = $date->translatedFormat('l'); 
            
            $chartValues[] = Order::where('payment_status', 'paid')
                ->whereDate('created_at', $date)
                ->sum('total_price');
        }

        // F. Kirim SEMUA Variabel ke View
        return view('admin.dashboard', compact(
            'mitras', 
            'omsetHariIni', 
            'orderHariIni', 
            'belumDibayar', 
            'stokMenipis', 
            'topProducts',
            'chartLabels',
            'chartValues'
        ));
    }

    // 2. Proses ACC / Aktivasi Akun
    public function approve($id)
    {
        $mitra = User::findOrFail($id);
        $mitra->status = 'active'; 
        $mitra->save();

        // ========================================================
        // 1. TEMBAK NOTIFIKASI KE MITRA BAHWA AKUN AKTIF
        // ========================================================
        $title = "Akun Diaktifkan! 🎉";
        $message = "Selamat datang, {$mitra->name}! Akun Anda telah disetujui Admin. Anda sekarang bisa mulai belanja stok.";
        $url = route('mitra.shop'); 
        
        $mitra->notify(new SystemNotification($title, $message, $url));

        // ========================================================
        // 2. KODE BARU: TEMBAK NOTIFIKASI KE OWNER (CABANG BARU)
        // ========================================================
        $owners = User::where('role', 'owner')->get();
        if($owners->count() > 0) {
            $titleOwner = "Cabang Baru Bergabung! 🏪";
            $messageOwner = "Mitra baru bernama {$mitra->name} telah resmi diaktifkan oleh Admin. Total cabang kita bertambah!";
            $urlOwner = route('owner.dashboard'); 
            
            Notification::send($owners, new SystemNotification($titleOwner, $messageOwner, $urlOwner));
        }
        // ========================================================

        return redirect()->back()->with('success', 'Akun Mitra berhasil diaktifkan!');
    }

    public function viewLogs() {
        $logs = \App\Models\ActivityLog::with('user')->latest()->paginate(20);
        return view('admin.logs.index', compact('logs'));
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

        // --- LOGIKA TEMBAK NOTIFIKASI KE MITRA ---
        if($order->user) {
            $title = "Pesanan Dikirim! 🚚";
            $message = "Pesanan #ORDER-{$order->id} sedang dikirim menggunakan {$request->courier_name}. No Resi: {$request->resi_number}.";
            $url = url('/my-orders'); 
            
            $order->user->notify(new SystemNotification($title, $message, $url));
        }

        return redirect()->back()->with('success', 'Resi berhasil diinput! Pesanan sedang dikirim.');
    }
}
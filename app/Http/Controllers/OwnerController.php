<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Menu;
use App\Models\ActivityLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class OwnerController extends Controller
{
    public function index()
    {
        $isOrderTableReady = Schema::hasTable('orders') && Schema::hasColumn('orders', 'order_status');

        $data = [
            'total_omset' => $isOrderTableReady ? Order::where('order_status', 'completed')->sum('total_price') : 0,
            'total_mitra' => User::where('role', 'mitra')->count(),
            'pesanan_terbaru' => $isOrderTableReady ? Order::with('user')->latest()->take(5)->get() : collect([]),
        ];

        return view('owner.dashboard', $data);
    }

    /**
     * LAPORAN KEUANGAN DENGAN DATA RIIL (UNTUK GRAFIK)
     */
    public function reportIndex(Request $request)
    {
        $filter = $request->query('filter', 'week'); // Default seminggu terakhir

        // 1. Ambil Data Ringkasan Riil
        $totalOmset = Order::where('payment_status', 'paid')->sum('total_price');
        $totalTransaksi = Order::where('payment_status', 'paid')->count();
        $totalMitra = User::where('role', 'mitra')->count();

        // 2. LOGIKA GRAFIK TREN PENDAPATAN (7 HARI TERAKHIR)
        $label = [];
        $dataPendapatan = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $label[] = $date->format('d M'); // Format: 14 Apr
            
            // Hitung sum total_price per hari yang statusnya sudah 'paid'
            $sumPerHari = Order::whereDate('created_at', $date)
                                ->where('payment_status', 'paid')
                                ->sum('total_price');
            
            $dataPendapatan[] = $sumPerHari;
        }

        // 3. LOGIKA GRAFIK LINGKARAN (STATUS ORDER RIIL)
        $pieData = [
            Order::where('order_status', 'pending')->count(),
            Order::where('order_status', 'processing')->count(),
            Order::where('order_status', 'shipped')->count(),
            Order::where('order_status', 'completed')->count(),
            Order::where('order_status', 'cancelled')->count(),
        ];

        // 4. Data Tabel Riil
        $orders = Order::with('user')->latest()->paginate(10);

        return view('owner.reports.index', compact(
            'filter', 'totalOmset', 'totalTransaksi', 'totalMitra', 
            'label', 'dataPendapatan', 'pieData', 'orders'
        ));
    }

    public function menuReport()
    {
        $menus = Menu::orderBy('loves', 'desc')->get();
        return view('owner.reports.menus', compact('menus'));
    }

    public function viewLogs()
    {
        $logs = ActivityLog::with('user')->latest()->paginate(20);
        return view('owner.logs.index', compact('logs'));
    }
}
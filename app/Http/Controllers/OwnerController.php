<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Menu;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OwnerController extends Controller
{
    public function index()
    {
        $data = [
            'total_omset' => Order::where('payment_status', 'paid')->sum('total_price'),
            'total_mitra' => User::where('role', 'mitra')->count(),
            'pesanan_terbaru' => Order::with('user')->latest()->take(5)->get(),
        ];
        return view('owner.dashboard', $data);
    }

    public function reportIndex(Request $request)
    {
        $filter = $request->query('filter', 'week');
        $label = [];
        $dataPendapatan = [];

        // --- LOGIKA FIX: MENGGUNAKAN WHERERAW AGAR TIDAK ERROR 'COLUMN NOT FOUND' ---
        if ($filter == 'today') {
            for ($i = 0; $i <= 20; $i += 4) {
                $label[] = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00';
                
                // Gunakan whereRaw untuk mengambil JAM (HOUR) dari created_at
                $dataPendapatan[] = Order::where('payment_status', 'paid')
                    ->whereDate('created_at', Carbon::today())
                    ->whereRaw("HOUR(created_at) >= ?", [$i])
                    ->whereRaw("HOUR(created_at) < ?", [$i + 4])
                    ->sum('total_price');
            }
        } elseif ($filter == 'month') {
            for ($i = 25; $i >= 0; $i -= 5) {
                $date = Carbon::now()->subDays($i);
                $label[] = $date->format('d M');
                $dataPendapatan[] = Order::where('payment_status', 'paid')
                    ->whereDate('created_at', $date)
                    ->sum('total_price');
            }
        } elseif ($filter == 'year') {
            for ($i = 5; $i >= 0; $i--) {
                $date = Carbon::now()->subMonths($i);
                $label[] = $date->format('M');
                $dataPendapatan[] = Order::where('payment_status', 'paid')
                    ->whereMonth('created_at', $date->month)
                    ->whereYear('created_at', $date->year)
                    ->sum('total_price');
            }
        } else {
            // Default: 'week'
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                $label[] = $date->format('d M');
                $dataPendapatan[] = Order::where('payment_status', 'paid')
                    ->whereDate('created_at', $date)
                    ->sum('total_price');
            }
        }

        // 2. Data Ringkasan Atas
        $queryBase = Order::where('payment_status', 'paid');
        if($filter == 'today') $queryBase->whereDate('created_at', Carbon::today());
        if($filter == 'week') $queryBase->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        if($filter == 'month') $queryBase->whereMonth('created_at', Carbon::now()->month);

        $totalOmset = $queryBase->sum('total_price');
        $totalTransaksi = $queryBase->count();
        $totalMitra = User::where('role', 'mitra')->count();

        // 3. Grafik Lingkaran
        $pieData = [
            Order::where('order_status', 'pending')->count(),
            Order::where('order_status', 'processing')->count(),
            Order::where('order_status', 'shipped')->count(),
            Order::where('order_status', 'completed')->count(),
            Order::where('order_status', 'cancelled')->count(),
        ];

        $orders = Order::with('user')->latest()->paginate(10);

        return view('owner.reports.index', compact(
            'filter', 'totalOmset', 'totalTransaksi', 'totalMitra', 
            'label', 'dataPendapatan', 'pieData', 'orders'
        ));
    }

    public function menuReport() {
        $menus = Menu::orderBy('loves', 'desc')->get();
        return view('owner.reports.menus', compact('menus'));
    }

    public function viewLogs() {
        $logs = \App\Models\ActivityLog::with('user')->latest()->paginate(20);
        return view('owner.logs.index', compact('logs'));
    }
}
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
    /**
     * 1. Dashboard Utama (SINKRON DENGAN DESAIN PREMIUM)
     */
    public function index()
    {
        $totalOmsetAllTime = Order::where('payment_status', 'paid')->sum('total_price');
        
        $omsetYear = Order::where('payment_status', 'paid')
                            ->whereYear('created_at', Carbon::now()->year)
                            ->sum('total_price');
        
        $totalMitra = User::where('role', 'mitra')->count();
        
        $recentTransactions = Order::with('user')->latest()->take(5)->get();
        
        return view('owner.dashboard', compact(
            'totalOmsetAllTime', 
            'omsetYear', 
            'totalMitra', 
            'recentTransactions'
        ));
    }

    /**
     * 2. Laporan Keuangan Lengkap dengan Grafik Smart
     */
    public function reportIndex(Request $request)
    {
        $filter = $request->query('filter', 'today');
        $label = [];
        $dataPendapatan = [];

        // --- LOGIKA SMART KALENDER (GRAFIK) ---
        if ($filter == 'today') {
            for ($i = 0; $i <= 23; $i++) {
                $label[] = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00';
                $dataPendapatan[] = Order::where('payment_status', 'paid')
                    ->whereDate('created_at', Carbon::today())
                    ->whereRaw("HOUR(created_at) = ?", [$i])
                    ->sum('total_price');
            }
        } elseif ($filter == 'week') {
            $startOfWeek = Carbon::now()->startOfWeek(); 
            for ($i = 0; $i < 7; $i++) {
                $date = $startOfWeek->copy()->addDays($i);
                $label[] = $date->translatedFormat('l'); 
                $dataPendapatan[] = Order::where('payment_status', 'paid')
                    ->whereDate('created_at', $date)
                    ->sum('total_price');
            }
        } elseif ($filter == 'month') {
            $daysInMonth = Carbon::now()->daysInMonth;
            for ($i = 1; $i <= $daysInMonth; $i++) {
                $label[] = $i; 
                $dataPendapatan[] = Order::where('payment_status', 'paid')
                    ->whereMonth('created_at', Carbon::now()->month)
                    ->whereYear('created_at', Carbon::now()->year)
                    ->whereDay('created_at', $i)
                    ->sum('total_price');
            }
        } elseif ($filter == 'year') {
            for ($m = 1; $m <= 12; $m++) {
                $label[] = Carbon::create()->month($m)->translatedFormat('F'); 
                $dataPendapatan[] = Order::where('payment_status', 'paid')
                    ->whereMonth('created_at', $m)
                    ->whereYear('created_at', Carbon::now()->year)
                    ->sum('total_price');
            }
        // FITUR BARU: ALL TIME (Grafik Tahunan)
        } elseif ($filter == 'all_time') {
            $firstOrder = Order::orderBy('created_at', 'asc')->first();
            $startYear = $firstOrder ? Carbon::parse($firstOrder->created_at)->year : Carbon::now()->year;
            $currentYear = Carbon::now()->year;

            for ($y = $startYear; $y <= $currentYear; $y++) {
                $label[] = (string)$y;
                $dataPendapatan[] = Order::where('payment_status', 'paid')
                    ->whereYear('created_at', $y)
                    ->sum('total_price');
            }
        }

        // --- DATA RINGKASAN & TABEL ---
        $queryBase = Order::where('payment_status', 'paid');
        if($filter == 'today') $queryBase->whereDate('created_at', Carbon::today());
        if($filter == 'week') $queryBase->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        if($filter == 'month') $queryBase->whereMonth('created_at', Carbon::now()->month);
        if($filter == 'year') $queryBase->whereYear('created_at', Carbon::now()->year);
        // Jika all_time, tidak perlu filter queryBase, ambil semua.

        $totalOmset = $queryBase->sum('total_price');
        $totalTransaksi = $queryBase->count();
        $totalMitra = User::where('role', 'mitra')->count();

        // Data untuk Grafik Lingkaran (Status Pesanan)
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

    /**
     * 3. Laporan Menu Terpopuler (Logika Sorting Pintar)
     */
    public function menuReport() 
    {
        $menus = \App\Models\Menu::orderBy('loves', 'desc')
                                 ->orderBy('hates', 'asc')
                                 ->get();

        $bestMenu = \App\Models\Menu::orderBy('loves', 'desc')
                                    ->orderBy('hates', 'asc')
                                    ->first();
                                    
        $totalVariants = \App\Models\Menu::count();
        $totalParticipation = \App\Models\Menu::sum('loves') + \App\Models\Menu::sum('hates');

        return view('owner.reports.menus', compact('menus', 'bestMenu', 'totalVariants', 'totalParticipation'));
    }
    
    /**
     * 4. Log Aktivitas Sistem
     */
    public function viewLogs(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $logs = \App\Models\ActivityLog::with('user')
            ->when($search, function ($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('action', 'like', "%{$search}%")
                      ->orWhere('target_user', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhereHas('user', function ($u) use ($search) {
                          $u->where('name', 'like', "%{$search}%");
                      });
                });
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('owner.logs.index', compact('logs'));
    }
}
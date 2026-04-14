<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf; // Jangan lupa ini

class ReportController extends Controller
{

    public function exportPdf(Request $request)
{
    // 1. Tangkap Filter
    $filter = $request->input('filter', 'today'); // Default ke today agar sinkron
    
    $query = Order::where('payment_status', 'paid');
    
    // 2. Filter Data Sesuai Pilihan
    if ($filter == 'today') {
        $orders = $query->whereDate('created_at', Carbon::today())->get();
    } elseif ($filter == 'week') {
        // Mingguan (Senin - Minggu Berjalan)
        $orders = $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
    } elseif ($filter == 'month') {
        $orders = $query->whereYear('created_at', date('Y'))
                        ->whereMonth('created_at', date('m'))
                        ->get();
    } else {
        // Tahunan
        $orders = $query->whereYear('created_at', date('Y'))->get();
    }

    // 3. Hitung Ringkasan (PENTING: Variabel ini harus ada karena dipanggil di Blade PDF)
    $totalOmset = $orders->sum('total_price');
    $totalTransaksi = $orders->count(); // Ini yang tadi lupa dihitung

    // 4. Cetak PDF
    // Tambahkan 'filter' dan 'totalTransaksi' ke dalam compact
    $pdf = Pdf::loadView('admin.reports.pdf', compact('orders', 'totalOmset', 'totalTransaksi', 'filter'));
    
    return $pdf->download('Laporan-AyamSuper-' . ucfirst($filter) . '.pdf');
}

    public function index(Request $request)
    {
        // 1. Tentukan Filter (Default: Bulanan)
        $filter = $request->input('filter', 'month');
        
        $query = Order::where('payment_status', 'paid');
        $label = [];
        $dataPendapatan = [];

        // --- LOGIKA BARU DI SINI ---
        if ($filter == 'today') {
            // FILTER HARI INI (Grafik Per Jam)
            $orders = $query->whereDate('created_at', Carbon::today())
                            ->select(DB::raw('HOUR(created_at) as hour'), DB::raw('SUM(total_price) as total'))
                            ->groupBy('hour')
                            ->orderBy('hour', 'ASC')
                            ->get();

            // Loop dari Jam 00 s/d 23 (24 Jam)
            for ($i = 0; $i <= 23; $i++) {
                $label[] = sprintf('%02d:00', $i); // Label: 00:00, 01:00, dst
                
                // Cari apakah ada transaksi di jam ini?
                $found = $orders->firstWhere('hour', $i);
                $dataPendapatan[] = $found ? $found->total : 0;
            }

        } elseif ($filter == 'day') {
            // Filter Harian (7 Hari Terakhir)
            $startDate = Carbon::now()->subDays(6);
            $orders = $query->where('created_at', '>=', $startDate)
                            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_price) as total'))
                            ->groupBy('date')
                            ->orderBy('date', 'ASC')
                            ->get();
            
            foreach($orders as $o) {
                $label[] = Carbon::parse($o->date)->locale('id')->isoFormat('dddd, D MMM');
                $dataPendapatan[] = $o->total;
            }

        } elseif ($filter == 'week') {
            // Filter Mingguan (4 Minggu Terakhir)
            $startDate = Carbon::now()->subWeeks(4);
            $orders = $query->where('created_at', '>=', $startDate)
                            ->select(DB::raw('YEARWEEK(created_at) as yearweek'), DB::raw('SUM(total_price) as total'))
                            ->groupBy('yearweek')
                            ->orderBy('yearweek', 'ASC')
                            ->get();

            foreach($orders as $o) {
                $label[] = 'Minggu ke-' . substr($o->yearweek, -2);
                $dataPendapatan[] = $o->total;
            }

        } else {
            // Filter Bulanan (Tahun Ini)
            $orders = $query->whereYear('created_at', date('Y'))
                            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(total_price) as total'))
                            ->groupBy('month')
                            ->orderBy('month', 'ASC')
                            ->get();

            for ($i=1; $i<=12; $i++) {
                $found = $orders->firstWhere('month', $i);
                $months[] = $found ? $found->total : 0;
                $label[] = Carbon::create()->month($i)->locale('id')->isoFormat('MMMM');
            }
            $dataPendapatan = $months;
        }

        // ... (Sisa kode ke bawah sama persis: Pie Chart & Ringkasan) ...
        // Copy paste sisa kode lama di sini (Pie Data, Total Omset, Return View)
        
        // 3. Data untuk Pie Chart
        $statusCounts = Order::select('order_status', DB::raw('count(*) as total'))
                             ->groupBy('order_status')
                             ->pluck('total', 'order_status')
                             ->toArray();
        
        $pieData = [
            $statusCounts['pending'] ?? 0,
            $statusCounts['processing'] ?? 0,
            $statusCounts['shipped'] ?? 0,
            $statusCounts['completed'] ?? 0,
            $statusCounts['cancelled'] ?? 0,
        ];

        $totalOmset = Order::where('payment_status', 'paid')->sum('total_price');
        $totalTransaksi = Order::where('payment_status', 'paid')->count();
        $totalMitra = \App\Models\User::where('role', 'mitra')->where('status', 'active')->count();

        return view('admin.reports.index', compact(
            'label', 'dataPendapatan', 'filter', 
            'pieData', 'totalOmset', 'totalTransaksi', 'totalMitra'
        ));
    }
}
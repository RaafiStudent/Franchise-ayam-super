<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // 1. Tentukan Filter (Default: Bulanan / 'month')
        $filter = $request->input('filter', 'month');
        
        $query = Order::where('payment_status', 'paid');
        $label = [];
        $dataPendapatan = [];

        // 2. Logika Filter Data untuk Grafik Garis (Tren Pendapatan)
        if ($filter == 'day') {
            // Filter Harian (7 Hari Terakhir)
            $startDate = Carbon::now()->subDays(6);
            $orders = $query->where('created_at', '>=', $startDate)
                            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_price) as total'))
                            ->groupBy('date')
                            ->orderBy('date', 'ASC')
                            ->get();
            
            // Format Label (Senin, Selasa, dst)
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
            // Filter Bulanan (Tahun Ini - Jan s/d Des)
            $orders = $query->whereYear('created_at', date('Y'))
                            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(total_price) as total'))
                            ->groupBy('month')
                            ->orderBy('month', 'ASC')
                            ->get();

            // Mapping Angka Bulan ke Nama Bulan
            $months = [];
            for ($i=1; $i<=12; $i++) {
                $found = $orders->firstWhere('month', $i);
                $months[] = $found ? $found->total : 0; // Kalau bulan kosong, isi 0
                $label[] = Carbon::create()->month($i)->locale('id')->isoFormat('MMMM');
            }
            $dataPendapatan = $months;
        }

        // 3. Data untuk Pie Chart (Komposisi Status Pesanan) - Semua Waktu
        $statusCounts = Order::select('order_status', DB::raw('count(*) as total'))
                             ->groupBy('order_status')
                             ->pluck('total', 'order_status')
                             ->toArray();
        
        // Pastikan urutan key sama agar warna konsisten
        $pieData = [
            $statusCounts['pending'] ?? 0,
            $statusCounts['processing'] ?? 0,
            $statusCounts['shipped'] ?? 0,
            $statusCounts['completed'] ?? 0,
            $statusCounts['cancelled'] ?? 0,
        ];

        // 4. Ringkasan Kartu Atas
        $totalOmset = Order::where('payment_status', 'paid')->sum('total_price');
        $totalTransaksi = Order::where('payment_status', 'paid')->count();
        $totalMitra = \App\Models\User::where('role', 'mitra')->where('status', 'active')->count();

        return view('admin.reports.index', compact(
            'label', 'dataPendapatan', 'filter', 
            'pieData', 'totalOmset', 'totalTransaksi', 'totalMitra'
        ));
    }
}
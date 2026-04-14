<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * DASHBOARD LAPORAN (VIEW)
     */
    public function index(Request $request)
    {
        $filter = $request->input('filter', 'today'); // Default Hari Ini agar sinkron dengan Owner
        
        $label = [];
        $dataPendapatan = [];
        
        // Base Query untuk Ringkasan Box agar ikut terfilter
        $querySummary = Order::where('payment_status', 'paid');

        // --- LOGIKA FILTER SINKRON ---
        if ($filter == 'today') {
            // Grafik Per Jam
            for ($i = 0; $i <= 23; $i++) {
                $label[] = sprintf('%02d:00', $i);
                $dataPendapatan[] = Order::where('payment_status', 'paid')
                    ->whereDate('created_at', Carbon::today())
                    ->whereRaw("HOUR(created_at) = ?", [$i])
                    ->sum('total_price');
            }
            $querySummary->whereDate('created_at', Carbon::today());

        } elseif ($filter == 'week') {
            // Grafik Senin - Minggu (Minggu Berjalan)
            $startOfWeek = Carbon::now()->startOfWeek();
            for ($i = 0; $i < 7; $i++) {
                $date = $startOfWeek->copy()->addDays($i);
                $label[] = $date->translatedFormat('l');
                $dataPendapatan[] = Order::where('payment_status', 'paid')
                    ->whereDate('created_at', $date)
                    ->sum('total_price');
            }
            $querySummary->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);

        } elseif ($filter == 'month') {
            // Grafik Per Tanggal (Bulan Berjalan)
            $daysInMonth = Carbon::now()->daysInMonth;
            for ($i = 1; $i <= $daysInMonth; $i++) {
                $label[] = $i;
                $dataPendapatan[] = Order::where('payment_status', 'paid')
                    ->whereMonth('created_at', Carbon::now()->month)
                    ->whereYear('created_at', Carbon::now()->year)
                    ->whereDay('created_at', $i)
                    ->sum('total_price');
            }
            $querySummary->whereMonth('created_at', Carbon::now()->month)
                         ->whereYear('created_at', Carbon::now()->year);

        } elseif ($filter == 'year') {
            // Grafik Per Bulan (Januari - Desember)
            for ($m = 1; $m <= 12; $m++) {
                $label[] = Carbon::create()->month($m)->translatedFormat('F');
                $dataPendapatan[] = Order::where('payment_status', 'paid')
                    ->whereMonth('created_at', $m)
                    ->whereYear('created_at', Carbon::now()->year)
                    ->sum('total_price');
            }
            $querySummary->whereYear('created_at', Carbon::now()->year);
        }

        // --- HITUNG DATA RINGKASAN BOX (IKUT FILTER) ---
        $totalOmset = $querySummary->sum('total_price');
        $totalTransaksi = $querySummary->count();
        $totalMitra = User::where('role', 'mitra')->count();

        // --- DATA UNTUK PIE CHART (STATUS ORDER) ---
        $pieData = [
            Order::where('order_status', 'pending')->count(),
            Order::where('order_status', 'processing')->count(),
            Order::where('order_status', 'shipped')->count(),
            Order::where('order_status', 'completed')->count(),
            Order::where('order_status', 'cancelled')->count(),
        ];

        return view('admin.reports.index', compact(
            'label', 'dataPendapatan', 'filter', 
            'pieData', 'totalOmset', 'totalTransaksi', 'totalMitra'
        ));
    }

    /**
     * EXPORT PDF (SINKRON DENGAN VIEW)
     */
    public function exportPdf(Request $request)
    {
        $filter = $request->input('filter', 'today');
        $query = Order::where('payment_status', 'paid');

        // Sinkronisasi data PDF dengan filter yang dipilih
        if ($filter == 'today') {
            $orders = $query->whereDate('created_at', Carbon::today())->get();
        } elseif ($filter == 'week') {
            $orders = $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
        } elseif ($filter == 'month') {
            $orders = $query->whereMonth('created_at', Carbon::now()->month)
                            ->whereYear('created_at', Carbon::now()->year)
                            ->get();
        } else {
            $orders = $query->whereYear('created_at', Carbon::now()->year)->get();
        }

        $totalOmset = $orders->sum('total_price');
        $totalTransaksi = $orders->count();

        $pdf = Pdf::loadView('admin.reports.pdf', compact('orders', 'totalOmset', 'totalTransaksi', 'filter'));
        
        return $pdf->download('Laporan-AyamSuper-' . ucfirst($filter) . '.pdf');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf; // <--- [PENTING] Import Library PDF

class OrderController extends Controller
{
    // 1. Halaman List Riwayat Pesanan
    public function index()
    {
        // Ambil order milik user yang sedang login, urutkan dari yang terbaru
        $orders = Order::where('user_id', Auth::id())
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('orders.index', compact('orders'));
    }

    // 2. Halaman Detail Pesanan
    public function show($id)
    {
        $order = Order::with('items.product')
                    ->where('user_id', Auth::id())
                    ->findOrFail($id);

        return view('orders.show', compact('order'));
    }
    
    // 3. Fitur "Pesanan Diterima" (Konfirmasi Barang Sampai)
    public function markAsCompleted($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);
        
        if($order->order_status == 'shipped') {
            $order->update(['order_status' => 'completed']);
            return redirect()->back()->with('success', 'Terima kasih! Pesanan selesai.');
        }
        
        return redirect()->back()->with('error', 'Pesanan belum dikirim, tidak bisa diselesaikan.');
    }

    // 4. [BARU] Fitur Download Invoice PDF
    public function downloadInvoice($id)
    {
        // Ambil data order beserta detail itemnya
        $order = Order::with('items.product')
                    ->where('user_id', Auth::id())
                    ->findOrFail($id);

        // Load View khusus PDF (pastikan file resources/views/orders/invoice_pdf.blade.php sudah dibuat)
        $pdf = Pdf::loadView('orders.invoice_pdf', compact('order'));

        // Download file otomatis dengan nama unik
        return $pdf->download('Invoice-AyamSuper-ORDER-'.$order->id.'.pdf');
    }
}
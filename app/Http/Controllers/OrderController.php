<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf; 

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('items.product')
                    ->where('user_id', Auth::id())
                    ->findOrFail($id);

        return view('checkout.show', compact('order')); // Arahkan ke checkout.show biar bagus
    }
    
    // LOGIC TERIMA BARANG
    public function markAsCompleted($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);
        
        // Hanya bisa selesai kalau statusnya sedang dikirim
        if($order->order_status == 'shipped') {
            $order->update([
                'order_status' => 'completed',
                'updated_at' => now() // Update jam terakhir
            ]);
            
            return redirect()->back()->with('success', 'Terima kasih! Pesanan telah selesai.');
        }
        
        return redirect()->back()->with('error', 'Pesanan belum dikirim, tidak bisa diselesaikan.');
    }

    // LOGIC DOWNLOAD PDF
    public function downloadInvoice($id)
    {
        $order = Order::with('items.product')
                    ->where('user_id', Auth::id())
                    ->findOrFail($id);

        $pdf = Pdf::loadView('orders.invoice_pdf', compact('order'));

        return $pdf->download('Invoice-AyamSuper-ORDER-'.$order->id.'.pdf');
    }
}
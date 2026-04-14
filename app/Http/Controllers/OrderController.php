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

        // PERBAIKAN ALAMAT VIEW: mitra/orders/index.blade.php
        return view('mitra.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('items.product')
                    ->where('user_id', Auth::id())
                    ->findOrFail($id);

        // PERBAIKAN ALAMAT VIEW: mitra/orders/show.blade.php
        return view('mitra.orders.show', compact('order'));
    }
    
    public function markAsCompleted($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);
        
        if($order->order_status == 'shipped') {
            $order->update([
                'order_status' => 'completed',
                'updated_at' => now()
            ]);
            
            return redirect()->back()->with('success', 'Terima kasih! Pesanan telah selesai.');
        }
        
        return redirect()->back()->with('error', 'Pesanan belum dikirim, tidak bisa diselesaikan.');
    }

    public function downloadInvoice($id)
    {
        $order = Order::with('items.product')
                    ->where('user_id', Auth::id())
                    ->findOrFail($id);

        // PERBAIKAN ALAMAT VIEW: mitra/orders/invoice_pdf.blade.php
        $pdf = Pdf::loadView('mitra.orders.invoice_pdf', compact('order'));

        return $pdf->stream('Invoice-AyamSuper-ORDER-'.$order->id.'.pdf');
    }
}
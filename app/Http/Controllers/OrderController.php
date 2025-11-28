<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Halaman List Riwayat Pesanan
    public function index()
    {
        // Ambil order milik user yang sedang login, urutkan dari yang terbaru
        $orders = Order::where('user_id', Auth::id())
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('orders.index', compact('orders'));
    }

    // Halaman Detail Pesanan (Lihat isinya apa aja)
    public function show($id)
    {
        $order = Order::with('items.product')
                    ->where('user_id', Auth::id())
                    ->findOrFail($id);

        return view('orders.show', compact('order')); // Kita pakai view yang sama/mirip dengan checkout show tadi
    }
    
    // Fitur "Pesanan Diterima" (Konfirmasi Barang Sampai)
    public function markAsCompleted($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);
        
        if($order->order_status == 'shipped') {
            $order->update(['order_status' => 'completed']);
            return redirect()->back()->with('success', 'Terima kasih! Pesanan selesai.');
        }
        
        return redirect()->back()->with('error', 'Pesanan belum dikirim, tidak bisa diselesaikan.');
    }
}
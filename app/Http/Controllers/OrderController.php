<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf; 

class OrderController extends Controller
{
    public function index(Request $request)
    {
        // Tangkap request pencarian dan filter jumlah data (default 10)
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10);

        // Ambil data pesanan khusus untuk Mitra yang sedang login
        $orders = \App\Models\Order::where('user_id', \Illuminate\Support\Facades\Auth::id())
            ->when($search, function ($query, $search) {
                // Bersihkan kata #ORDER- jika user mengetik itu di pencarian
                $searchId = str_replace('#ORDER-', '', $search);
                return $query->where('id', 'like', "%{$searchId}%")
                             ->orWhere('resi_number', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        // FIX: Alamat view diarahkan ke dalam folder mitra
        return view('mitra.orders.index', compact('orders')); 
    }

    public function show($id)
    {
        $order = Order::with('items.product')
                    ->where('user_id', Auth::id())
                    ->findOrFail($id);

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

        $pdf = Pdf::loadView('mitra.orders.invoice_pdf', compact('order'));

        return $pdf->stream('Invoice-AyamSuper-ORDER-'.$order->id.'.pdf');
    }
}
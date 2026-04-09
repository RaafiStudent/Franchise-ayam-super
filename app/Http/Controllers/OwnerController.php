<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class OwnerController extends Controller
{
    public function index()
    {
        // Ambil data ringkasan untuk dashboard owner
        $total_sales = Order::where('status', 'completed')->sum('total_price');
        $total_mitra = User::where('role', 'mitra')->count();
        $recent_orders = Order::with('user')->latest()->take(5)->get();

        return view('owner.dashboard', compact('total_sales', 'total_mitra', 'recent_orders'));
    }

    public function reports()
    {
        // Tampilkan semua data transaksi untuk dipantau
        $orders = Order::with('user')->latest()->paginate(10);
        return view('owner.reports', compact('orders'));
    }
}
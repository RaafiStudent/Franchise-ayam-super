<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;

class OwnerController extends Controller
{
    public function index()
    {
        // Mengambil ringkasan data untuk Owner
        $data = [
            'total_omset' => Order::where('status', 'completed')->sum('total_price'),
            'total_mitra' => User::where('role', 'mitra')->count(),
            'pesanan_terbaru' => Order::with('user')->latest()->take(5)->get(),
        ];

        return view('owner.dashboard', $data);
    }
}
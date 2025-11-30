<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuReportController extends Controller
{
    public function index()
    {
        // Ambil semua data menu, urutkan dari yang paling banyak LIKE-nya (Juara 1 di atas)
        // Kita juga bisa tambahkan logika rating, tapi urutkan by Loves dulu sudah cukup representatif
        $menus = Menu::orderBy('loves', 'desc')->get();

        return view('admin.reports.menus', compact('menus'));
    }
}
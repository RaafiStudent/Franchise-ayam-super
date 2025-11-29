<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session; // <--- WAJIB: Jangan lupa import ini!

class HomeController extends Controller
{
    public function toggleLove($id)
    {
        $product = Product::findOrFail($id);
        
        // 1. Ambil daftar ID produk yang sudah di-like dari session
        $likedProducts = Session::get('liked_products', []);

        // 2. Cek apakah ID produk ini sudah ada di daftar?
        if (in_array($id, $likedProducts)) {
            // Jika SUDAH ada, jangan tambah angka lagi (cegah spam like)
            return response()->json([
                'success' => true,
                'new_count' => $product->loves,
                'status' => 'already_liked' // Beri tanda status
            ]);
        }

        // 3. Jika BELUM ada, baru kita tambah angkanya
        $product->increment('loves');
        
        // 4. Catat ID produk ini ke dalam session
        Session::push('liked_products', $id);

        return response()->json([
            'success' => true,
            'new_count' => $product->loves,
            'status' => 'liked'
        ]);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    // 1. Tampilkan Katalog (Sama seperti sebelumnya)
    public function index()
    {
        $products = Product::where('is_available', true)->get();
        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();

        $totalPrice = 0;
        foreach($cartItems as $item) {
            $totalPrice += $item->product->price * $item->quantity;
        }

        return view('dashboard', compact('products', 'cartItems', 'totalPrice'));
    }

    // 2. Tambah Item (Versi AJAX / Tanpa Refresh)
    public function addToCart(Request $request, $productId)
    {
        $userId = Auth::id();
        
        $cart = Cart::where('user_id', $userId)->where('product_id', $productId)->first();

        if ($cart) {
            $cart->increment('quantity');
        } else {
            Cart::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => 1
            ]);
        }

        // Hitung ulang total untuk update Footer
        return $this->getCartSummary($userId);
    }

    // 3. Kurangi Item (Versi AJAX / Tanpa Refresh)
    public function decreaseCart($productId)
    {
        $userId = Auth::id();
        $cart = Cart::where('user_id', $userId)->where('product_id', $productId)->first();

        if ($cart) {
            if ($cart->quantity > 1) {
                $cart->decrement('quantity');
            } else {
                $cart->delete();
            }
        }

        // Hitung ulang total untuk update Footer
        return $this->getCartSummary($userId);
    }

    // Fungsi Pembantu untuk menghitung total belanjaan user
    private function getCartSummary($userId)
    {
        $carts = Cart::with('product')->where('user_id', $userId)->get();
        $totalPrice = 0;
        $totalQty = 0;

        foreach($carts as $c) {
            $totalPrice += $c->product->price * $c->quantity;
            $totalQty += $c->quantity;
        }

        // Cari qty produk spesifik yg baru diupdate tadi (opsional, tapi bagus buat UI)
        return response()->json([
            'status' => 'success',
            'total_price' => number_format($totalPrice, 0, ',', '.'),
            'total_qty' => $totalQty,
            'cart_items' => $carts->pluck('quantity', 'product_id') // Kirim list qty per produk
        ]);
    }
}
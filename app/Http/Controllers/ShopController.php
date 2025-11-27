<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    // 1. Tampilkan Katalog & Keranjang
    public function index()
    {
        $products = Product::where('is_available', true)->get();

        // Ambil keranjang milik user yang sedang login
        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();

        // Hitung Total Belanja
        $totalPrice = 0;
        foreach($cartItems as $item) {
            $totalPrice += $item->product->price * $item->quantity;
        }

        return view('dashboard', compact('products', 'cartItems', 'totalPrice'));
    }

    // 2. Tambah ke Keranjang
    public function addToCart(Request $request, $productId)
    {
        $cart = Cart::where('user_id', Auth::id())
                    ->where('product_id', $productId)
                    ->first();

        if ($cart) {
            // Jika sudah ada, tambah jumlahnya
            $cart->increment('quantity');
        } else {
            // Jika belum ada, buat baru
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'quantity' => 1
            ]);
        }

        return redirect()->back()->with('success', 'Masuk keranjang!');
    }

    // 3. Kurangi / Hapus Item
    public function decreaseCart($cartId)
    {
        $cart = Cart::where('id', $cartId)->where('user_id', Auth::id())->firstOrFail();

        if ($cart->quantity > 1) {
            $cart->decrement('quantity');
        } else {
            $cart->delete(); // Kalau sisa 1 dikurangi, jadi hapus
        }

        return redirect()->back();
    }
}
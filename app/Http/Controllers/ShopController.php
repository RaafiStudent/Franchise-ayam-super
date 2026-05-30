<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function index()
    {
        $products = Product::where('stock', '>', 0)->get();
        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();

        $totalPrice = 0;
        foreach($cartItems as $item) {
            // PELINDUNG 1: Cek apakah produk aslinya masih ada di database?
            if ($item->product) {
                $totalPrice += $item->product->price * $item->quantity;
            } else {
                // BUMM! Jika produk sudah dihapus Admin, hapus otomatis dari keranjang Mitra!
                $item->delete();
            }
        }

        // Ambil ulang data keranjang (berjaga-jaga jika barusan ada 'produk hantu' yang dihapus)
        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();

        return view('mitra.shop.index', compact('products', 'cartItems', 'totalPrice'));
    }

    public function addToCart(Request $request, $productId)
    {
        $userId = Auth::id();
        $product = Product::find($productId);
        $cart = Cart::where('user_id', $userId)->where('product_id', $productId)->first();

        // Pastikan produk tidak null sebelum ditambah ke keranjang
        if ($product) {
            if ($cart) {
                if ($cart->quantity < $product->stock) {
                    $cart->increment('quantity');
                }
            } else {
                Cart::create([
                    'user_id' => $userId,
                    'product_id' => $productId,
                    'quantity' => 1
                ]);
            }
        }

        return $this->getCartSummary($userId);
    }

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

        return $this->getCartSummary($userId);
    }

    public function updateCart(Request $request, $productId)
    {
        $userId = Auth::id();
        $quantity = (int) $request->query('quantity', 0); 
        
        $product = Product::find($productId);
        
        // Pastikan produknya masih ada
        if (!$product) {
            return $this->getCartSummary($userId);
        }

        if ($quantity > $product->stock) { 
            $quantity = $product->stock;
        }

        $cart = Cart::where('user_id', $userId)->where('product_id', $productId)->first();
        
        if ($quantity <= 0) {
            if ($cart) {
                $cart->delete();
            }
        } else {
            if ($cart) {
                $cart->update(['quantity' => $quantity]);
            } else {
                Cart::create([
                    'user_id' => $userId,
                    'product_id' => $productId,
                    'quantity' => $quantity
                ]);
            }
        }
        
        return $this->getCartSummary($userId);
    }

    private function getCartSummary($userId)
    {
        $carts = Cart::with('product')->where('user_id', $userId)->get();
        $totalPrice = 0;
        $totalQty = 0;

        foreach($carts as $c) {
            // PELINDUNG 2: Saat menghitung via AJAX, pastikan produk tidak null
            if ($c->product) {
                $totalPrice += $c->product->price * $c->quantity;
                $totalQty += $c->quantity;
            } else {
                $c->delete(); // Hapus 'produk hantu'
            }
        }

        // Ambil ulang jika barusan ada yang dihapus otomatis
        $carts = Cart::with('product')->where('user_id', $userId)->get();

        return response()->json([
            'status' => 'success',
            'total_price' => number_format($totalPrice, 0, ',', '.'),
            'total_qty' => $totalQty,
            'cart_items' => $carts->pluck('quantity', 'product_id')
        ]);
    }
}
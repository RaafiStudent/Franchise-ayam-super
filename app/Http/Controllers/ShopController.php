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
            if($item->product) {
                $totalPrice += $item->product->price * $item->quantity;
            }
        }
        return view('mitra.shop.index', compact('products', 'cartItems', 'totalPrice'));
    }

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

    // ===============================================
    // FITUR BARU: PROSES KETIKAN ANGKA MANUAL
    // ===============================================
    public function updateCart(Request $request, $productId)
    {
        $userId = Auth::id();
        $quantity = (int) $request->input('quantity', 0);
        
        $cart = Cart::where('user_id', $userId)->where('product_id', $productId)->first();
        
        // Jika diketik 0, maka hapus dari keranjang
        if ($quantity <= 0) {
            if ($cart) {
                $cart->delete();
            }
        } else {
            // Jika produk sudah ada, update jumlahnya
            if ($cart) {
                $cart->update(['quantity' => $quantity]);
            } else {
                // Jika belum ada, buat baru dengan jumlah ketikan
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
            if($c->product) {
                $totalPrice += $c->product->price * $c->quantity;
                $totalQty += $c->quantity;
            }
        }
        return response()->json([
            'status' => 'success',
            'total_price' => number_format($totalPrice, 0, ',', '.'),
            'total_qty' => $totalQty,
            'cart_items' => $carts->pluck('quantity', 'product_id')
        ]);
    }
}
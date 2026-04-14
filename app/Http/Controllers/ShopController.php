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
        // Pastikan kolom is_available ada di database, atau gunakan 'stock' > 0
        $products = Product::where('stock', '>', 0)->get();
        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();

        $totalPrice = 0;
        foreach($cartItems as $item) {
            $totalPrice += $item->product->price * $item->quantity;
        }

        // PERBAIKAN ALAMAT VIEW: mitra/shop/index.blade.php
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

    private function getCartSummary($userId)
    {
        $carts = Cart::with('product')->where('user_id', $userId)->get();
        $totalPrice = 0;
        $totalQty = 0;

        foreach($carts as $c) {
            $totalPrice += $c->product->price * $c->quantity;
            $totalQty += $c->quantity;
        }

        return response()->json([
            'status' => 'success',
            'total_price' => number_format($totalPrice, 0, ',', '.'),
            'total_qty' => $totalQty,
            'cart_items' => $carts->pluck('quantity', 'product_id')
        ]);
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    public function process()
    {
        // 1. Ambil Data Keranjang User
        $user = Auth::user();
        $carts = Cart::with('product')->where('user_id', $user->id)->get();

        if($carts->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang masih kosong!');
        }

        // 2. Hitung Total Harga
        $totalPrice = 0;
        foreach($carts as $cart) {
            $totalPrice += $cart->product->price * $cart->quantity;
        }

        // 3. Gunakan Database Transaction
        DB::beginTransaction();
        try {
            // A. Buat Order Baru
            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => $totalPrice,
                'payment_status' => 'unpaid',
                'order_status' => 'pending',
                'resi_number' => null,
            ]);

            // B. Pindahkan Item Keranjang ke OrderItems
            $itemDetails = [];
            foreach($carts as $cart) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cart->product_id,
                    'quantity' => $cart->quantity,
                    'price' => $cart->product->price,
                ]);

                $itemDetails[] = [
                    'id' => $cart->product_id,
                    'price' => (int) $cart->product->price,
                    'quantity' => $cart->quantity,
                    'name' => substr($cart->product->name, 0, 50),
                ];
            }

            // C. Kosongkan Keranjang
            Cart::where('user_id', $user->id)->delete();

            // 4. Konfigurasi Midtrans
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = config('midtrans.is_sanitized');
            Config::$is3ds = config('midtrans.is_3ds');

            // === JURUS SAKTI: OVERRIDE URL VIA KODINGAN ===
            // Ganti URL ini sesuai link Ngrok kamu yang sedang aktif sekarang
            Config::$overrideNotifUrl = 'https://sandie-retractible-semimagnetically.ngrok-free.dev/midtrans-callback';
            // ==============================================

            // 5. Siapkan Parameter Transaksi Midtrans
            $params = [
                'transaction_details' => [
                    // Kita gunakan ID Order + Time agar unik dan tidak error "Duplicate Order ID"
                    'order_id' => 'ORDER-' . $order->id . '-' . time(),
                    'gross_amount' => (int) $totalPrice,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->no_hp,
                ],
                'item_details' => $itemDetails,
            ];

            // 6. Minta Snap Token ke Midtrans
            $snapToken = Snap::getSnapToken($params);

            // 7. Simpan Snap Token ke Database Order
            $order->snap_token = $snapToken;
            $order->save();

            DB::commit();

            // 8. Redirect ke Halaman Pembayaran
            return redirect()->route('checkout.show', $order->id);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $order = Order::with('items.product')->where('user_id', Auth::id())->findOrFail($id);
        return view('checkout.show', compact('order'));
    }
}
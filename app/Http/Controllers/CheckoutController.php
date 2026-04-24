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
use App\Models\User;
use App\Notifications\SystemNotification;
use Illuminate\Support\Facades\Notification;

class CheckoutController extends Controller
{
    public function process()
    {
        $user = Auth::user();
        $carts = Cart::with('product')->where('user_id', $user->id)->get();

        if($carts->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang masih kosong!');
        }

        $totalPrice = 0;
        foreach($carts as $cart) {
            $totalPrice += $cart->product->price * $cart->quantity;
        }

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => $totalPrice,
                'payment_status' => 'unpaid',
                'order_status' => 'pending',
                'resi_number' => null,
            ]);

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

            Cart::where('user_id', $user->id)->delete();

            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = config('midtrans.is_sanitized');
            Config::$is3ds = config('midtrans.is_3ds');

            Config::$overrideNotifUrl = 'https://sandie-retractible-semimagnetically.ngrok-free.dev/midtrans-callback';

            $params = [
                'transaction_details' => [
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

            $snapToken = Snap::getSnapToken($params);

            $order->snap_token = $snapToken;
            $order->save();

            DB::commit();

            // FIX: Menggunakan path relatif agar tidak memicu ngrok warning
            $admins = User::where('role', 'admin')->get();
            if($admins->count() > 0) {
                $title = "Pesanan Baru Masuk! 🛒";
                $message = "Mitra {$user->name} baru saja membuat pesanan (#ORDER-{$order->id}). Segera cek!";
                $url = '/admin/orders'; // Path relatif
                
                Notification::send($admins, new SystemNotification($title, $message, $url));
            }

            return redirect()->route('checkout.show', $order->id);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $order = Order::with('items.product')->where('user_id', Auth::id())->findOrFail($id);
        return view('mitra.orders.show', compact('order'));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification as MidtransNotification;
use App\Models\User;
use App\Notifications\SystemNotification;
use Illuminate\Support\Facades\Notification;

class PaymentCallbackController extends Controller
{
    public function receive()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        try {
            $notif = new MidtransNotification();
            
            $transaction = $notif->transaction_status;
            $type = $notif->payment_type;
            $orderIdRaw = $notif->order_id;
            $fraud = $notif->fraud_status;

            $parts = explode('-', $orderIdRaw); 
            $orderId = $parts[1];

            $order = Order::findOrFail($orderId);

            // FIX: Menggunakan path relatif agar notifikasi bisa dibuka di localhost maupun ngrok
            $sendSuccessNotification = function($order) {
                // Notifikasi ke Owner
                $owners = User::where('role', 'owner')->get();
                if($owners->count() > 0) {
                    $title = "Dana Masuk! 💰";
                    $message = "Pembayaran untuk #ORDER-{$order->id} senilai Rp " . number_format($order->total_price, 0, ',', '.') . " telah LUNAS.";
                    $url = '/owner/dashboard'; // Path relatif
                    Notification::send($owners, new SystemNotification($title, $message, $url));
                }

                // Notifikasi ke Admin
                $admins = User::where('role', 'admin')->get();
                if($admins->count() > 0) {
                    $title = "Pembayaran Lunas! ✅";
                    $message = "#ORDER-{$order->id} sudah dibayar. Segera kemas dan proses pengiriman barang.";
                    $url = '/admin/orders'; // Path relatif
                    Notification::send($admins, new SystemNotification($title, $message, $url));
                }
            };

            if ($transaction == 'capture') {
                if ($type == 'credit_card') {
                    if ($fraud == 'challenge') {
                        $order->update(['payment_status' => 'pending']);
                    } else {
                        $isAlreadyPaid = $order->payment_status == 'paid';
                        $order->update(['payment_status' => 'paid', 'order_status' => 'processing']);
                        if (!$isAlreadyPaid) { $sendSuccessNotification($order); }
                    }
                }
            } else if ($transaction == 'settlement') {
                $isAlreadyPaid = $order->payment_status == 'paid';
                $order->update(['payment_status' => 'paid', 'order_status' => 'processing']);
                if (!$isAlreadyPaid) { $sendSuccessNotification($order); }
            } else if ($transaction == 'pending') {
                $order->update(['payment_status' => 'pending']);
            } else if ($transaction == 'deny' || $transaction == 'expire' || $transaction == 'cancel') {
                $order->update(['payment_status' => 'failed', 'order_status' => 'cancelled']);
            }

            return response()->json(['message' => 'Payment status updated']);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}
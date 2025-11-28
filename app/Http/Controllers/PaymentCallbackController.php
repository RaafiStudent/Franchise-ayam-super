<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification;

class PaymentCallbackController extends Controller
{
    public function receive()
    {
        // 1. Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        try {
            // 2. Tangkap Notifikasi dari Midtrans
            $notif = new Notification();
            
            $transaction = $notif->transaction_status;
            $type = $notif->payment_type;
            $orderIdRaw = $notif->order_id; // Format: ORDER-18-123456
            $fraud = $notif->fraud_status;

            // 3. Ambil ID Order Asli dari format "ORDER-18-..."
            // Kita pecah string berdasarkan tanda strip '-'
            $parts = explode('-', $orderIdRaw); 
            $orderId = $parts[1]; // Ambil angka '18' nya saja

            // 4. Cari Order di Database
            $order = Order::findOrFail($orderId);

            // 5. Cek Status Transaksi & Update Database
            if ($transaction == 'capture') {
                if ($type == 'credit_card') {
                    if ($fraud == 'challenge') {
                        $order->update(['payment_status' => 'pending']);
                    } else {
                        $order->update(['payment_status' => 'paid', 'order_status' => 'processing']);
                    }
                }
            } else if ($transaction == 'settlement') {
                // Pembayaran Berhasil (Transfer/GoPay/dll)
                $order->update(['payment_status' => 'paid', 'order_status' => 'processing']);
            
            } else if ($transaction == 'pending') {
                $order->update(['payment_status' => 'pending']);
            
            } else if ($transaction == 'deny') {
                $order->update(['payment_status' => 'failed', 'order_status' => 'cancelled']);
            
            } else if ($transaction == 'expire') {
                $order->update(['payment_status' => 'expired', 'order_status' => 'cancelled']);
            
            } else if ($transaction == 'cancel') {
                $order->update(['payment_status' => 'failed', 'order_status' => 'cancelled']);
            }

            return response()->json(['message' => 'Payment status updated']);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}
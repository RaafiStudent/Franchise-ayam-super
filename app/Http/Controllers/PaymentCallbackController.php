<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification as MidtransNotification; // Ubah nama alias agar tidak bentrok
// --- TAMBAHAN UNTUK NOTIFIKASI ---
use App\Models\User;
use App\Notifications\SystemNotification;
use Illuminate\Support\Facades\Notification;

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
            $notif = new MidtransNotification();
            
            $transaction = $notif->transaction_status;
            $type = $notif->payment_type;
            $orderIdRaw = $notif->order_id; // Format: ORDER-18-123456
            $fraud = $notif->fraud_status;

            // 3. Ambil ID Order Asli dari format "ORDER-18-..."
            $parts = explode('-', $orderIdRaw); 
            $orderId = $parts[1]; // Ambil angka '18' nya saja

            // 4. Cari Order di Database
            $order = Order::findOrFail($orderId);

            // ========================================================
            // KODE BARU: FUNGSI BANTUAN UNTUK KIRIM NOTIFIKASI (OWNER & ADMIN)
            // ========================================================
            $sendSuccessNotification = function($order) {
                // Notifikasi ke Owner
                $owners = User::where('role', 'owner')->get();
                if($owners->count() > 0) {
                    $title = "Dana Masuk! 💰";
                    $message = "Pembayaran untuk #ORDER-{$order->id} senilai Rp " . number_format($order->total_price, 0, ',', '.') . " telah LUNAS.";
                    $url = route('owner.dashboard');
                    Notification::send($owners, new SystemNotification($title, $message, $url));
                }

                // Notifikasi ke Admin
                $admins = User::where('role', 'admin')->get();
                if($admins->count() > 0) {
                    $title = "Pembayaran Lunas! ✅";
                    $message = "#ORDER-{$order->id} sudah dibayar. Segera kemas dan proses pengiriman barang.";
                    $url = route('admin.orders.index');
                    Notification::send($admins, new SystemNotification($title, $message, $url));
                }
            };
            // ========================================================

            // 5. Cek Status Transaksi & Update Database
            if ($transaction == 'capture') {
                if ($type == 'credit_card') {
                    if ($fraud == 'challenge') {
                        $order->update(['payment_status' => 'pending']);
                    } else {
                        // CEK AGAR TIDAK MENGIRIM NOTIFIKASI GANDA
                        $isAlreadyPaid = $order->payment_status == 'paid';
                        $order->update(['payment_status' => 'paid', 'order_status' => 'processing']);
                        
                        if (!$isAlreadyPaid) {
                            $sendSuccessNotification($order);
                        }
                    }
                }
            } else if ($transaction == 'settlement') {
                // Pembayaran Berhasil (Transfer/GoPay/dll)
                // CEK AGAR TIDAK MENGIRIM NOTIFIKASI GANDA
                $isAlreadyPaid = $order->payment_status == 'paid';
                $order->update(['payment_status' => 'paid', 'order_status' => 'processing']);
                
                if (!$isAlreadyPaid) {
                    $sendSuccessNotification($order);
                }
            
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
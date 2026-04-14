<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil ID salah satu mitra (pastikan sudah ada user dengan role mitra)
        $mitraId = User::where('role', 'mitra')->first()->id ?? 1;

        // Kita buat data dari Januari 2025 sampai April 2026
        $startDate = Carbon::create(2025, 1, 1);
        $endDate = Carbon::now();

        $this->command->info('Sedang meracik bumbu data transaksi... Mohon tunggu...');

        while ($startDate <= $endDate) {
            // Tentukan jumlah transaksi per hari (acak 0 - 3 transaksi)
            // Tip: Kalau mau ada lonjakan di bulan tertentu, tambah logic di sini
            $isHighSeason = in_array($startDate->month, [3, 12]); // Misal: Maret (Ramadhan) & Desember
            $countPerDay = $isHighSeason ? rand(3, 7) : rand(0, 2);

            for ($i = 0; $i < $countPerDay; $i++) {
                $totalPrice = rand(150, 1500) * 1000; // Rp 150rb - 1.5jt

                Order::create([
                    'user_id' => $mitraId,
                    'total_price' => $totalPrice,
                    'payment_status' => 'paid', // Kita buat paid semua biar masuk omset
                    'order_status' => 'completed',
                    'snap_token' => Str::random(20),
                    'created_at' => $startDate->copy()->addHours(rand(8, 20))->addMinutes(rand(0, 59)),
                    'updated_at' => $startDate,
                ]);
            }

            $startDate->addDay();
        }

        $this->command->info('Gorengan data selesai! Transaksi berhasil dibuat.');
    }
}
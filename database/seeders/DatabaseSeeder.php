<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Admin Pusat
        User::create([
            'name' => 'Administrator Pusat',
            'email' => 'admin@ayamsuper.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'status' => 'active',
            'no_hp' => '081234567890',
            'alamat_lengkap' => 'Kantor Pusat Ayam Super',
            'kota' => 'Tegal',
            'provinsi' => 'Jawa Tengah',
        ]);

        // 2. Buat Akun Owner
        User::create([
            'name' => 'Nida Nafila',
            'email' => 'owner2@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'owner',
            'status' => 'active',
        ]);

        // 3. Buat Akun Mitra Utama
        User::create([
            'name' => 'Rizki Nur Setiawan',
            'email' => 'mitra1@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'mitra',
            'status' => 'active',
            'kota' => 'Tegal',
        ]);

        // 4. Panggil Seeder Lainnya agar data muncul otomatis
        $this->call([
            ProductSeeder::class,      // Memunculkan Stok Bahan Baku
            MenuSeeder::class,         // Memunculkan Menu di Depan & Dashboard Owner
            TransactionSeeder::class,  // Membuat Riwayat Penjualan (Omset)
        ]);
    }
}
<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
<<<<<<< HEAD
        // ==========================================
        // 1. BUAT 3 AKUN UTAMA (Admin, Owner, Mitra)
        // ==========================================
        
        // Akun Admin
        User::create([
            'name' => 'Administrator Pusat',
            'email' => 'admin@ayamsuper.com',
            'password' => Hash::make('12345678'), // Password disamakan agar mudah ingat
            'role' => 'admin',
            'status' => 'active',
=======
        // Buat 1 Akun Admin Pusat
        User::create([
            'name' => 'Administrator Pusat',
            'email' => 'admin@ayamsuper.com',
            'password' => Hash::make('password123'), // Password Admin
            'role' => 'admin',       // Role Admin
            'status' => 'active',    // Langsung Active
>>>>>>> 95f10a05d42b30f04b8c9e70d81046c7a8489793
            'no_hp' => '081234567890',
            'alamat_lengkap' => 'Kantor Pusat Ayam Super',
            'kota' => 'Tegal',
            'provinsi' => 'Jawa Tengah',
        ]);
<<<<<<< HEAD

        // Akun Owner
        User::create([
            'name' => 'Nida Nafila',
            'email' => 'owner2@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'owner',
            'status' => 'active',
        ]);

        // Akun Mitra Asli
        User::create([
            'name' => 'Rizki Nur Setiawan',
            'email' => 'mitra1@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'mitra',
            'status' => 'active',
        ]);

        // ==========================================
        // 2. PANGGIL DATA BARANG DAN MENU
        // ==========================================
        $this->call([
            ProductSeeder::class, // Untuk memunculkan barang di katalog belanja
            MenuSeeder::class,    // Untuk memunculkan gambar slider di halaman depan
        ]);
=======
>>>>>>> 95f10a05d42b30f04b8c9e70d81046c7a8489793
    }
}
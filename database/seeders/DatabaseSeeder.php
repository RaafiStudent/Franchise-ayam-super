<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat 1 Akun Admin Pusat
        User::create([
            'name' => 'Administrator Pusat',
            'email' => 'admin@ayamsuper.com',
            'password' => Hash::make('password123'), // Password Admin
            'role' => 'admin',       // Role Admin
            'status' => 'active',    // Langsung Active
            'no_hp' => '081234567890',
            'alamat_lengkap' => 'Kantor Pusat Ayam Super',
            'kota' => 'Tegal',
            'provinsi' => 'Jawa Tengah',
        ]);
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu; // Panggil Model Menu

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // Data Menu Lengkap (6 Item)
        $menus = [
            [
                'name' => 'Paket Hemat Pelajar',
                'description' => 'Sayap/Paha Bawah Crispy + Nasi + Es Teh Manis.',
                'image' => 'https://placehold.co/400x300/orange/white?text=Paket+Hemat',
                'loves' => 0,
                'badge' => 'HEMAT',
                'badge_color' => 'green',
            ],
            [
                'name' => 'Ayam Geprek Level',
                'description' => 'Ayam crispy digeprek dengan sambal bawang super pedas.',
                'image' => 'https://placehold.co/400x300/d32f2f/white?text=Ayam+Geprek',
                'loves' => 0,
                'badge' => 'BEST SELLER',
                'badge_color' => 'yellow',
            ],
            [
                'name' => 'Chicken Wings BBQ',
                'description' => 'Sayap ayam gurih dengan saus BBQ manis dan smoky.',
                'image' => 'https://placehold.co/400x300/brown/white?text=BBQ+Wings',
                'loves' => 0,
                'badge' => 'FAVORIT',
                'badge_color' => 'purple',
            ],
            [
                'name' => 'Ayam Sambal Matah',
                'description' => 'Ayam crispy disajikan dengan sambal matah segar khas Bali.',
                'image' => 'https://placehold.co/400x300/purple/white?text=Sambal+Matah',
                'loves' => 0,
                'badge' => 'PEDAS',
                'badge_color' => 'red',
            ],
            [
                'name' => 'Burger Ayam Crispy',
                'description' => 'Burger isi ayam crispy, selada, dan saus spesial.',
                'image' => 'https://placehold.co/400x300/green/white?text=Burger+Ayam',
                'loves' => 0,
                'badge' => 'BARU',
                'badge_color' => 'blue',
            ],
            [
                'name' => 'Paket Keluarga',
                'description' => '4 Ayam crispy + 2 Nasi + 2 Kentang + 2 Es Teh Jumbo.',
                'image' => 'https://placehold.co/400x300/blue/white?text=Paket+Keluarga',
                'loves' => 0,
                'badge' => 'FAMILY',
                'badge_color' => 'indigo',
            ],
        ];

        // Masukkan data ke database
        foreach ($menus as $menu) {
            Menu::create($menu);
        }
    }
}
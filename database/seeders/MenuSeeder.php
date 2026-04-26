<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // Data Menu Ala Fried Chicken Umum (Loves & Hates direset ke 0)
        $menus = [
            [
                'name' => 'Ayam Crispy (Dada / Paha Atas)',
                'description' => 'Ayam goreng tepung renyah dengan potongan besar, daging juicy dan kulit super krispi.',
                'image' => 'https://placehold.co/400x300/ff9800/white?text=Ayam+Dada',
                'loves' => 0,
                'hates' => 0,
                'badge' => 'FAVORIT',
                'badge_color' => 'orange',
            ],
            [
                'name' => 'Ayam Crispy (Sayap / Paha Bawah)',
                'description' => 'Potongan ayam goreng tepung yang gurih bumbunya meresap sampai ke tulang.',
                'image' => 'https://placehold.co/400x300/f44336/white?text=Ayam+Sayap',
                'loves' => 0,
                'hates' => 0,
                'badge' => null,
                'badge_color' => null,
            ],
            [
                'name' => 'Paket Super Hemat',
                'description' => '1 Nasi + 1 Ayam Crispy (Sayap/Paha Bawah) + 1 Es Teh Manis.',
                'image' => 'https://placehold.co/400x300/4caf50/white?text=Paket+Hemat',
                'loves' => 0,
                'hates' => 0,
                'badge' => 'HEMAT',
                'badge_color' => 'green',
            ],
            [
                'name' => 'Paket Super Mantap',
                'description' => '1 Nasi + 1 Ayam Crispy (Dada/Paha Atas) + 1 Es Teh Manis.',
                'image' => 'https://placehold.co/400x300/f44336/white?text=Paket+Mantap',
                'loves' => 0,
                'hates' => 0,
                'badge' => 'BEST SELLER',
                'badge_color' => 'red',
            ],
            [
                'name' => 'Burger Ayam Super',
                'description' => 'Burger lembut dengan isian fillet ayam krispi tanpa tulang, selada segar, dan saus mayo.',
                'image' => 'https://placehold.co/400x300/2196f3/white?text=Burger+Ayam',
                'loves' => 0,
                'hates' => 0,
                'badge' => 'BARU',
                'badge_color' => 'blue',
            ],
            [
                'name' => 'Kentang Goreng (French Fries)',
                'description' => 'Kentang goreng renyah dengan taburan bumbu gurih, cocok untuk cemilan santai.',
                'image' => 'https://placehold.co/400x300/ffc107/white?text=Kentang+Goreng',
                'loves' => 0,
                'hates' => 0,
                'badge' => 'SNACK',
                'badge_color' => 'yellow',
            ],
        ];

        // Masukkan data ke database
        foreach ($menus as $menu) {
            Menu::create($menu);
        }
    }
}
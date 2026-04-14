<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Ayam Marinasi (Pre-Cut)',
                'description' => '1 Ekor ayam potong 8/10 bagian yang sudah dimarinasi.',
                'price' => 45000,
                'stock' => 500,
                'image' => null,
                'loves' => 0,
                'is_available' => true,
            ],
            [
                'name' => 'Tepung Biang Premium',
                'description' => 'Tepung bumbu krispi rahasia Ayam Super.',
                'price' => 28000,
                'stock' => 150,
                'image' => null,
                'loves' => 0,
                'is_available' => true,
            ],
            [
                'name' => 'Minyak Goreng Padat',
                'description' => 'Minyak beku khusus deep frying.',
                'price' => 32000,
                'stock' => 100,
                'image' => null,
                'loves' => 0,
                'is_available' => true,
            ],
            [
                'name' => 'Saus Sambal Sachet',
                'description' => 'Saus sambal kemasan sachet.',
                'price' => 45000,
                'stock' => 200,
                'image' => null,
                'loves' => 0,
                'is_available' => true,
            ],
            [
                'name' => 'Kertas Pembungkus Nasi',
                'description' => 'Kertas nasi anti lengket.',
                'price' => 15000,
                'stock' => 300,
                'image' => null,
                'loves' => 0,
                'is_available' => true,
            ],
            [
                'name' => 'Kantong Kertas (Paper Bag)',
                'description' => 'Paper bag ramah lingkungan.',
                'price' => 25000,
                'stock' => 250,
                'image' => null,
                'loves' => 0,
                'is_available' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
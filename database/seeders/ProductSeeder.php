<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Data produk permanen
        $products = [
            [
                'product_name' => 'Golek Ayun',
                'variation' => 'L. Abu Polos',
                'sale' => '10% Off',
                'price' => '100000',
                'stock' => 50,
                'image' => 'images/GolekAyun_AbuPolos.webp',
                'is_permanent' => true,
            ],
            [
                'product_name' => 'Sonokeling',
                'variation' => 'L. Khaki',
                'sale' => '15% Off',
                'price' => '250000',
                'stock' => 30,
                'image' => 'images/Sonokeling_Khaki.webp',
                'is_permanent' => true,
            ],
            [
                'product_name' => 'SeriGambyong',
                'variation' => 'L. Orange',
                'sale' => '5% Off',
                'price' => '350000',
                'stock' => 20,
                'image' => 'images/SeriGambyong_Orange.webp',
                'is_permanent' => true,
            ],
        ];

        // Masukkan data ke tabel products
        foreach ($products as $product) {
            Product::updateOrCreate(
                ['product_name' => $product['product_name'], 'variation' => $product['variation']],
                $product
            );
        }
    }
}
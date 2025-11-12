<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        $categories = Category::all();

        // Daftar produk beserta kategori
        $products = [
            ['name' => 'Laptop ASUS', 'category' => 'Elektronik', 'price' => 15000000],
            ['name' => 'Smartphone Samsung', 'category' => 'Elektronik', 'price' => 8000000],
            ['name' => 'Kulkas Polytron', 'category' => 'Peralatan Rumah Tangga', 'price' => 4500000],
            ['name' => 'TV LED LG', 'category' => 'Elektronik', 'price' => 5500000],
            ['name' => 'Mesin Cuci Panasonic', 'category' => 'Peralatan Rumah Tangga', 'price' => 4000000],
            ['name' => 'Headphone Sony', 'category' => 'Audio & Aksesori', 'price' => 1200000],
            ['name' => 'Meja Belajar Kayu', 'category' => 'Furniture', 'price' => 750000],
            ['name' => 'Kursi Kantor', 'category' => 'Furniture', 'price' => 500000],
            ['name' => 'Speaker Bluetooth', 'category' => 'Audio & Aksesori', 'price' => 900000],
            ['name' => 'AC Panasonic', 'category' => 'Peralatan Rumah Tangga', 'price' => 6000000],
        ];

        foreach ($products as $item) {
            $category = $categories->where('name', $item['category'])->first();

            $product = Product::create([
                'name' => $item['name'],
                'price' => $item['price'],
                'category_id' => $category->id ?? null,
            ]);

            // Buat product detail
            $product->detail()->create([
                'description' => $faker->sentence(12, true),
                'weight' => $faker->randomFloat(2, 0.5, 20),
                'size' => $faker->randomElement(['Small', 'Medium', 'Large', '15 inch', '17 inch', 'XL']),
            ]);
        }
    }
}

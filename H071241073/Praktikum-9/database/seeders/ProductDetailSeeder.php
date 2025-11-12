<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductDetailSeeder extends Seeder
{
    public function run()
    {
        $categories = Category::all();

        $products = [
            ['name' => 'Laptop ASUS', 'category' => 'Elektronik', 'price' => 15000000, 'weight' => 2.0, 'size' => '15 inch'],
            ['name' => 'Smartphone Samsung', 'category' => 'Elektronik', 'price' => 8000000, 'weight' => 0.2, 'size' => '6 inch'],
            ['name' => 'Kulkas Polytron', 'category' => 'Peralatan Rumah Tangga', 'price' => 4500000, 'weight' => 35, 'size' => 'Large'],
            ['name' => 'TV LED LG', 'category' => 'Elektronik', 'price' => 5500000, 'weight' => 8, 'size' => '32 inch'],
            ['name' => 'Mesin Cuci Panasonic', 'category' => 'Peralatan Rumah Tangga', 'price' => 4000000, 'weight' => 30, 'size' => 'Medium'],
            ['name' => 'Headphone Sony', 'category' => 'Audio & Aksesori', 'price' => 1200000, 'weight' => 0.3, 'size' => 'One Size'],
            ['name' => 'Meja Belajar Kayu', 'category' => 'Furniture', 'price' => 750000, 'weight' => 15, 'size' => 'Medium'],
            ['name' => 'Kursi Kantor', 'category' => 'Furniture', 'price' => 500000, 'weight' => 10, 'size' => 'Medium'],
            ['name' => 'Speaker Bluetooth', 'category' => 'Audio & Aksesori', 'price' => 900000, 'weight' => 3, 'size' => 'Small'],
            ['name' => 'AC Panasonic', 'category' => 'Peralatan Rumah Tangga', 'price' => 6000000, 'weight' => 12, 'size' => 'Medium'],
        ];

        foreach ($products as $item) {
            $category = $categories->where('name', $item['category'])->first();

            $product = Product::create([
                'name' => $item['name'],
                'price' => $item['price'],
                'category_id' => $category->id ?? null,
            ]);

            
            $product->detail()->create([
                'description' => "Deskripsi untuk {$item['name']}", // bisa diganti dengan teks lain
                'weight' => $item['weight'],
                'size' => $item['size'],
            ]);
        }
    }
}

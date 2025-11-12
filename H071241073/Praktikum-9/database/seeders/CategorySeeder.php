<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Elektronik', 'description' => 'Perangkat elektronik seperti TV, Laptop, Smartphone.'],
            ['name' => 'Peralatan Rumah Tangga', 'description' => 'Kulkas, Mesin Cuci, AC, dan peralatan rumah lainnya.'],
            ['name' => 'Furniture', 'description' => 'Meja, Kursi, Lemari, dan furnitur lainnya.'],
            ['name' => 'Audio & Aksesori', 'description' => 'Headphone, Speaker, dan perangkat audio lainnya.'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}

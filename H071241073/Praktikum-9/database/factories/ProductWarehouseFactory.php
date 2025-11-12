<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProductWarehouseSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        $products = Product::all();
        $warehouses = Warehouse::all();

        foreach ($products as $product) {
            foreach ($warehouses as $warehouse) {
                DB::table('product_warehouse')->insert([
                    'product_id' => $product->id,
                    'warehouse_id' => $warehouse->id,
                    'quantity' => $faker->numberBetween(0, 100),
                ]);
            }
        }
    }
}

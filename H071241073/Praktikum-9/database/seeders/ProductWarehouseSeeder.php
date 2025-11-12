<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Warehouse;

class ProductWarehouseSeeder extends Seeder
{
    public function run()
    {
        $products = Product::all();
        $warehouses = Warehouse::all();

        foreach ($products as $product) {
            // Set stok random di 1-3 gudang
            $assignedWarehouses = $warehouses->random(rand(1, 3));
            foreach ($assignedWarehouses as $warehouse) {
                $product->warehouses()->attach($warehouse->id, [
                    'quantity' => rand(5, 50)
                ]);
            }
        }
    }
}

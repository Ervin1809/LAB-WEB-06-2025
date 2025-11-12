<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Warehouse;

class WarehouseSeeder extends Seeder
{
    public function run()
    {
        $warehouses = [
            ['name' => 'Gudang Jakarta', 'location' => 'Jl. Merdeka No.1, Jakarta'],
            ['name' => 'Gudang Surabaya', 'location' => 'Jl. Pahlawan No.10, Surabaya'],
            ['name' => 'Gudang Makassar', 'location' => 'Jl. Hasanuddin No.5, Makassar'],
        ];

        foreach ($warehouses as $warehouse) {
            Warehouse::create($warehouse);
        }
    }
}

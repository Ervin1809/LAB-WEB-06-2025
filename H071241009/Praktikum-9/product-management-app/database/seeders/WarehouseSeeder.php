<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Warehouse; 

class WarehouseSeeder extends Seeder 
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat data untuk Warehouse
        Warehouse::create([
            'name' => 'Gudang Utama Makassar', 
            'location' => 'Jl. Perintis Kemerdekaan KM. 10'
        ]);
        
        Warehouse::create([
            'name' => 'Gudang Cabang Gowa', 
            'location' => 'Jl. Malino, Somba Opu'
        ]);

        Warehouse::create([
            'name' => 'Gudang Stok Opname', 
            'location' => 'Kawasan Industri Maros'
        ]);
    }
}
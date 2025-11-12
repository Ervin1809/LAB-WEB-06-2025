<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products_warehouses', function (Blueprint $table) {
            $table->id(); // bigint, PRIMARY KEY, AUTO_INCREMENT
            
            // Relasi N:M ke products
            // Sesuai permintaan: onDelete('cascade')
            $table->foreignId('product_id')
                  ->constrained('products')
                  ->onDelete('cascade');
            
            // Relasi N:M ke warehouses
            // Sesuai permintaan: onDelete('cascade')
            $table->foreignId('warehouse_id')
                  ->constrained('warehouses')
                  ->onDelete('cascade');
            
            $table->integer('quantity')->default(0);

            // Tambahan (poin 5: "buat sebagus mungkin")
            // Memastikan 1 produk tidak duplikat dalam 1 gudang
            $table->unique(['product_id', 'warehouse_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products_warehouses');
    }
};
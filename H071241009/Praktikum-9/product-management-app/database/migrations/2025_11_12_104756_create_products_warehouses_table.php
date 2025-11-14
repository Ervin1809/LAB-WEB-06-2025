<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Nama tabel pivot: 'products_warehouses'
        Schema::create('products_warehouses', function (Blueprint $table) {

            // Foreign key ke tabel 'products'
            $table->foreignId('product_id')
                  ->constrained('products')
                  ->onDelete('cascade'); // Sesuai 'onDelete cascade' 

            // Foreign key ke tabel 'warehouses'
            $table->foreignId('warehouse_id')
                  ->constrained('warehouses')
                  ->onDelete('cascade'); // Sesuai 'onDelete cascade' 

            // Atribut tambahan di tabel pivot 
            $table->integer('quantity')->default(0); // quantity, integer, DEFAULT 0 

            // Menetapkan primary key gabungan 
            $table->primary(['product_id', 'warehouse_id']);

        });
    }
    public function down(): void {
        Schema::dropIfExists('products_warehouses');
    }
};
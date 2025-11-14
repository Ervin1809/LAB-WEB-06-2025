<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // id, bigint, PRIMARY KEY, AUTO_INCREMENT
            $table->string('name'); // name, varchar(255), NOT NULL
            $table->decimal('price', 15, 2); // price, decimal(15,2), NOT NULL

            // Foreign key ke tabel 'categories'
            $table->foreignId('category_id')
                  ->nullable() // Sesuai 'NULLABLE' 
                  ->constrained('categories') // Merujuk ke 'id' di tabel 'categories'
                  ->onDelete('set null'); // Sesuai 'onDelete set null' 

            $table->timestamps(); // created_at dan updated_at
        });
    }
    public function down(): void {
        Schema::dropIfExists('products');
    }
};
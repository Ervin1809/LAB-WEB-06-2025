<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('product_details', function (Blueprint $table) {
            $table->id(); // id, bigint, PRIMARY KEY, AUTO_INCREMENT

            // Foreign key ke tabel 'products' (Relasi 1:1)
            $table->foreignId('product_id')
                  ->unique() // Sesuai 'UNIQUE' (Kunci dari 1:1) 
                  ->constrained('products') // Merujuk ke 'id' di tabel 'products'
                  ->onDelete('cascade'); // Sesuai 'onDelete cascade' 

            $table->text('description')->nullable(); // description, text, NULLABLE
            $table->decimal('weight', 8, 2); // weight, decimal(8,2), NOT NULL
            $table->string('size')->nullable(); // size, varchar(255), NULLABLE
            $table->timestamps(); // created_at dan updated_at
        });
    }
    public function down(): void {
        Schema::dropIfExists('product_details');
    }
};
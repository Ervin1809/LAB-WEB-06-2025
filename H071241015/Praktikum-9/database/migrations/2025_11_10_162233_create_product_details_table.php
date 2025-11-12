<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_details', function (Blueprint $table) {
            $table->id(); // bigint, PRIMARY KEY, AUTO_INCREMENT
            
            // Relasi 1:1 dengan products
            // Sesuai permintaan: unique() dan onDelete('cascade')
            $table->foreignId('product_id')
                  ->unique()
                  ->constrained('products')
                  ->onDelete('cascade');
                  
            $table->text('description')->nullable();
            $table->decimal('weight', 8, 2); // decimal(8,2), NOT NULL
            $table->string('size')->nullable();
            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_details');
    }
};
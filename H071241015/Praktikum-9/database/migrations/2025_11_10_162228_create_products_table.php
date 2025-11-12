<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // bigint, PRIMARY KEY, AUTO_INCREMENT
            $table->string('name'); // varchar(255), NOT NULL
            $table->decimal('price', 15, 2); // decimal(15,2), NOT NULL
            
            // Relasi 1:N ke categories
            // Sesuai permintaan: nullable() dan onDelete('set null')
            $table->foreignId('category_id')
                  ->nullable()
                  ->constrained('categories')
                  ->onDelete('set null');
                  
            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
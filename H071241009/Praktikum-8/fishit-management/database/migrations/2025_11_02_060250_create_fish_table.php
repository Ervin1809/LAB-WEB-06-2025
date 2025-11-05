<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fishes', function (Blueprint $table) {
            $table->id(); // Sesuai dengan BIGINT UNSIGNED, PK, AUTO_INCREMENT
            $table->string('name', 100); // NOT NULL adalah default
            $table->enum('rarity', [
                'Common', 
                'Uncommon', 
                'Rare', 
                'Epic', 
                'Legendary', 
                'Mythic', 
                'Secret'
            ]);
            $table->decimal('base_weight_min', 8, 2);
            $table->decimal('base_weight_max', 8, 2);
            $table->integer('sell_price_per_kg');
            $table->decimal('catch_probability', 5, 2);
            $table->text('description')->nullable(); // NULLABLE
            $table->timestamps(); // Membuat created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fish');
    }
};

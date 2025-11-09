<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFishTable extends Migration
{
    public function up(): void
    {
        Schema::create('fishes', function (Blueprint $table) {

            $table->id(); 
            
            $table->string('name', 100)->unique()->notNull();

            $table->enum('rarity', [
                'Common', 'Uncommon', 'Rare', 'Epic', 'Legendary', 'Mythic', 'Secret'
            ])->notNull();

            $table->decimal('base_weight_min', 8, 2)->notNull();
            $table->decimal('base_weight_max', 8, 2)->notNull();
            $table->integer('sell_price_per_kg')->notNull();
            $table->decimal('catch_probability', 5, 2)->notNull();
            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fishes');
    }
}

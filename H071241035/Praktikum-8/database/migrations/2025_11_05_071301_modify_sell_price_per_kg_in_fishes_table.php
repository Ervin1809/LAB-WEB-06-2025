<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('fishes', function (Blueprint $table) {
            $table->bigInteger('sell_price_per_kg')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('fishes', function (Blueprint $table) {
            $table->integer('sell_price_per_kg')->nullable(false)->change();
        });
    }
};

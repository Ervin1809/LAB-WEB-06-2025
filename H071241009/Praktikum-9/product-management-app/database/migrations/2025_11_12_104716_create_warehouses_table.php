<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id(); // id, bigint, PRIMARY KEY, AUTO_INCREMENT
            $table->string('name'); // name, varchar(255), NOT NULL
            $table->text('location')->nullable(); // location, text, NULLABLE
            $table->timestamps(); // created_at dan updated_at
        });
    }
    public function down(): void {
        Schema::dropIfExists('warehouses');
    }
};
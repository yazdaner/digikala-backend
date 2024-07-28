<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products__sizes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id');
            $table->foreignId('category_id');
            $table->foreignId('size_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products__sizes');
    }
};

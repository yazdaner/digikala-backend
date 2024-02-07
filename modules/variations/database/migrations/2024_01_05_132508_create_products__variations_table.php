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
        Schema::create('products__variations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->integer('price1');
            $table->integer('price2')->nullable();
            $table->smallInteger('preparation_time')->default(0);
            $table->integer('product_count')->nullable();
            $table->smallInteger('max_product_cart')->nullable();
            $table->morphs('param1');
            $table->morphs('param2');
            $table->string('sender')->default('self');
            $table->boolean('selected_by_box')->default(0);
            $table->boolean('status')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products__variations');
    }
};

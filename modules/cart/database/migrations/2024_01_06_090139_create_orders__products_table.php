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
        Schema::create('orders__products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id');
            $table->foreignId('variation_id');
            $table->foreignId('order_id');
            $table->foreignId('seller_id')->default(0);
            $table->foreignId('submission_id')->constrained('orders__submissions')->cascadeOnDelete();
            $table->integer('price1');
            $table->integer('price2');
            $table->bigInteger('preparation_time')->default(0);
            $table->smallInteger('count');
            $table->bigInteger('created_at');
            $table->bigInteger('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders__products');
    }
};

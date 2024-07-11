<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('statistics__products_sales', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('year');
            $table->smallInteger('month');
            $table->smallInteger('day');
            $table->integer('order_count');
            $table->integer('total_sales');
            $table->foreignId('product_id');
            $table->bigInteger('created_at');
            $table->bigInteger('updated_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('statistics__products_sales');
    }
};

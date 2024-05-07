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
        Schema::create('orders__submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id');
            $table->bigInteger('delivery_date')->nullable();
            $table->string('delivery_time')->nullable();
            $table->smallInteger('send_status')->default(0);
            $table->string('send_type');
            $table->integer('shipping_cost')->default(0);
            $table->bigInteger('shipping_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders__submissions');
    }
};

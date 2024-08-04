<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sellers__address', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained()->cascadeOnDelete();
            $table->text('address');
            $table->foreignId('province_id');
            $table->foreignId('city_id');
            $table->smallInteger('plaque')->nullable();
            $table->bigInteger('postal_code')->nullable();
            $table->string('latitude');
            $table->string('longitude');
            $table->string('type')->default('shop');
            $table->string('warehouse_name')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sellers__address');
    }
};

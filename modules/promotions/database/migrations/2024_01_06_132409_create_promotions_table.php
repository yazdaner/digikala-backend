<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->default('amazing');
            $table->integer('start_time');
            $table->integer('end_time');
            $table->smallInteger('min_discount');
            $table->smallInteger('min_products');
            $table->bigInteger('category_id');
            $table->string('status')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};

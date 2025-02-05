<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('discount_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->integer('expiration_date');
            $table->tinyInteger('percent')->nullable();
            $table->integer('amount')->nullable();
            $table->integer('max_amount')->nullable();
            $table->integer('min_purchase')->default(0);
            $table->foreignId('category_id')->default(0);
            $table->integer('used_count')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('discounts');
    }
};

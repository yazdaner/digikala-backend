<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sellers__commissions', function (Blueprint $table) {
            $table->id();
            $table->double('percent',4,2)->default(0.0);
            $table->foreignId('category_id');
            $table->foreignId('brand_id');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sellers__commissions');
    }
};

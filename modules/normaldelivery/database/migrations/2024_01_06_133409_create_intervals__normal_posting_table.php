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
        Schema::create('intervals__normal_posting', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('city_id');
            $table->string('date');
            $table->string('time');
            $table->smallInteger('capacity')->default(0);
            $table->integer('sender')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intervals__normal_posting');
    }
};

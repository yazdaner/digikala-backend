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
        Schema::create('statistics__visit', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('year');
            $table->smallInteger('month');
            $table->smallInteger('day');
            $table->bigInteger('view');
            $table->integer('google_input');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statistics__visit');
    }
};

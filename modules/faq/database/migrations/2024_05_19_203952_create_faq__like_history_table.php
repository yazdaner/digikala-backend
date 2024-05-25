<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('faq__like_history', function (Blueprint $table) {
            $table->id();
            $table->morphs('user');
            $table->foreignId('faq_id');
            $table->boolean('like');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faq__like_history');
    }
};

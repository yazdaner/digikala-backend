<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id');
            $table->morphs('user');
            $table->text('content');
            $table->boolean('status')->default(false);
            $table->foreignId('parent_id')->default(0);
            $table->bigInteger('answer_count')->default(0);
            $table->bigInteger('like')->default(0);
            $table->bigInteger('dislike')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};

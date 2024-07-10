<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog__post_tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tag_id');
            $table->foreignId('post_id')->constrained('blog__posts')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog__post_tags');
    }
};

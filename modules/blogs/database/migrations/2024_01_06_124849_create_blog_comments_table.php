<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog__comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('blog__posts')->cascadeOnDelete();
            $table->string('name');
            $table->boolean('status')->default(0);
            $table->boolean('like')->default(0);
            $table->foreignId('parent_id')->default(0);
            $table->text('content');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog__comments');
    }
};

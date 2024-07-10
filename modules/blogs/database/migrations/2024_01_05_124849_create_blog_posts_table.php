<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog__posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('en_title');
            $table->string('slug');
            $table->foreignId('category_id');
            $table->bigInteger('study_time')->nullable();
            $table->string('author')->nullable();
            $table->text('content');
            $table->text('description')->nullable();
            $table->string('videoLink')->nullable();
            $table->string('image')->nullable();
            $table->boolean('status');
            $table->bigInteger('deleted_at')->nullable();
            $table->bigInteger('created_at');
            $table->bigInteger('updated_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog__posts');
    }
};

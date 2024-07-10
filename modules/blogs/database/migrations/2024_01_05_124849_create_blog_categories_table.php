<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog__categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('en_name');
            $table->string('slug');
            $table->string('icon')->nullable();
            $table->foreignId('parent_id')->default(0);
            $table->text('description')->nullable();
            $table->text('tags')->nullable();
            $table->boolean('selected')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog__categories');
    }
};

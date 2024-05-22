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
        Schema::create('faq__questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('faq__categories');
            $table->string('title');
            $table->text('answer');
            $table->text('short_answer');
            $table->boolean('popular')->default(0);
            $table->integer('like')->default(0);
            $table->integer('dislike')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faq__questions');
    }
};

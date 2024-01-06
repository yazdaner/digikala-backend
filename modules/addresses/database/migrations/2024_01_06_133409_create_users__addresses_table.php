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
        Schema::create('users__addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->text('address');
            $table->foreignId('province_id');
            $table->foreignId('city_id');
            $table->smallInteger('plaque')->nullable();
            $table->integer('postal_code')->nullable();
            $table->string('latitude');
            $table->string('longitude');
            $table->string('recipient_name');
            $table->string('recipient_last_name');
            $table->string('recipient_mobile_number');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users__addresses');
    }
};

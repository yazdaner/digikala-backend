<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('online_payments', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('price');
            $table->string('gateway');
            $table->string('status');
            $table->morphs('table');

            $table->string('type')->nullable();
            $table->string('code1')->nullable();
            $table->string('code2')->nullable();
            $table->string('callbackUrl')->nullable();

            $table->bigInteger('created_at');
            $table->bigInteger('updated_at');
            $table->bigInteger('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('online_payments');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders__products', function (Blueprint $table) {
            $table->foreignId('seller_id')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('orders__products', function (Blueprint $table) {
            $table->dropColumn('seller_id');
        });
    }
};

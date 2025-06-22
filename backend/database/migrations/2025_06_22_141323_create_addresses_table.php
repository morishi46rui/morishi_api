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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->comment('住所コード');
            $table->string('name')->comment('町丁目名');
            $table->decimal('latitude', 10, 7)->nullable()->comment('緯度');
            $table->decimal('longitude', 10, 7)->nullable()->comment('経度');
            $table->foreignId('city_id')->constrained()->comment('市区町村ID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
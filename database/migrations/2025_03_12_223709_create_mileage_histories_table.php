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
        Schema::create('mileage_histories', function (Blueprint $table) {
            $table->unsignedBigInteger('vehicle_id');
            $table->timestamp('created_at')->useCurrent();
            $table->primary(['vehicle_id', 'created_at']);

            $table->foreign('vehicle_id')->references('id')->on('vehicles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mileage_histories');
    }
};

<?php

/*
 * @copyright (c) 2025 Pragith Lakshan Thilakarathna
 * All rights reserved. 
 * This code is proprietary to CJNextGenSys. 
 * Unauthorized use, reproduction, modification, distribution, or sale 
 * without the explicit written permission of CJNextGenSys is strictly prohibited.
 * For inquiries, please contact: [info@cjnextgensys.com]
*/

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
        Schema::create('vehicle_ownerships', function (Blueprint $table) {
            $table->unsignedBigInteger('vehicle_id');
            $table->unsignedBigInteger('vehicle_owner_id');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            
            $table->unique(['vehicle_id', 'vehicle_owner_id', 'start_date'], 'vehicle_owner_date_unique');
            $table->foreign('vehicle_id')->references('id')->on('vehicles');
            $table->foreign('vehicle_owner_id')->references('id')->on('vehicle_owners');
            $table->foreign('created_by')->references('id')->on('users')
                ->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_ownerships');
    }
};

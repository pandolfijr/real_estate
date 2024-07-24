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
        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('id_property')->nullable();
            $table->foreign('id_property')->references('id')->on('properties');

            $table->unsignedBigInteger('id_condo')->nullable();
            $table->foreign('id_condo')->references('id')->on('condos');
         });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

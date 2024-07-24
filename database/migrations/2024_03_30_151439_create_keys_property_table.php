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
        Schema::create('keys_property', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->integer('quantity');
            $table->string('description', 150);
            $table->string('observations', 150)->nullable();
            $table->unsignedBigInteger('id_property');
            $table->foreign('id_property')->references('id')->on('properties');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keys_property');
    }
};

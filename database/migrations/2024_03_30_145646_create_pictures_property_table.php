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
        Schema::create('images_property', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('description', 150);
            $table->boolean('main')->default(false);
            $table->string('folder', 150);
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
        Schema::dropIfExists('images_property');
    }
};

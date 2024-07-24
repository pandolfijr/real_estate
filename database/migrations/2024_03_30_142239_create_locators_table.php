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
        Schema::create('locators', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->decimal('income', 12,2)->nullable();
            $table->string('income_proof', 255)->nullable();
            $table->string('address_proof', 255)->nullable();
            $table->string('rg', 255)->nullable();
            $table->string('cpf', 255)->nullable();
            $table->unsignedBigInteger('id_people');
            $table->foreign('id_people')->references('id')->on('people');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locators');
    }
};

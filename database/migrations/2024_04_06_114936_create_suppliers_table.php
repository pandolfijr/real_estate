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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->integer('type_person');
            $table->string('cpf', 11)->nullable();
            $table->string('name', 100)->nullable();
            $table->string('cnpj', 14)->nullable();
            $table->string('address', 100)->nullable();
            $table->string('telephone', 11)->nullable();
            $table->string('cellphone', 11)->nullable();
            $table->string('email', 140)->nullable();
            $table->string('site', 100)->nullable();
            $table->string('responsible', 50)->nullable();
            $table->integer('category');
            $table->string('observations', 100)->nullable();
            $table->unsignedBigInteger('id_city');
            $table->foreign('id_city')->references('id')->on('cities');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};

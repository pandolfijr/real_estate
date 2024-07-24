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
        Schema::create('people', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('name', 20);
            $table->string('surname', 70);
            $table->string('cpf', 11)->unique();
            $table->string('rg', 12)->unique()->nullable();
            $table->string('cellphone', 11)->unique();
            $table->string('email')->unique()->nullable();
            $table->string('address', 255);
            $table->string('complement', 255)->nullable();
            $table->string('number', 11);
            $table->string('cep', 8);
            $table->boolean('marital_status')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('district', 50)->nullable();
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
        Schema::dropIfExists('people');
    }
};

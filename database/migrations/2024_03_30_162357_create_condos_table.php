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
        Schema::create('condos', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('description', 255);
            $table->integer('type');
            $table->integer('number_floors')->nullable();
            $table->integer('number_towers')->nullable();
            $table->integer('number_lots')->nullable();
            $table->integer('number_courts')->nullable();
            $table->string('address', 255);
            $table->string('number', 8);
            $table->string('district', 30);
            $table->string('cep', 9);
            $table->unsignedBigInteger('id_city');
            $table->foreign('id_city')->references('id')->on('cities');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('condos');
    }
};

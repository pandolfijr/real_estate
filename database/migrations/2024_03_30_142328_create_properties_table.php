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
        Schema::create('properties', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('reference', 10);
            $table->string('description', 255);
            $table->string('address', 255);
            $table->string('number', 8);
            $table->string('district', 50);
            $table->boolean('display_address')->default(true);
            $table->integer('status'); //  1: "Disponível", 2: "Vendido", 3: "Alugado", 4: "Indisponível"
            $table->integer('purpose'); //    1: "Venda", 2: "Locação", 3: "Venda e Locação", 4: "Temporada"
            $table->integer('type'); // properties_type utils
            $table->string('cep', 9);
            $table->string('area', 8)->nullable();
            $table->integer('bedrooms')->default('0');
            $table->integer('suites')->default(0);
            $table->integer('bathrooms')->default(0);
            $table->integer('parking_space')->default(0);
            $table->boolean('emphasis')->nullable();
            $table->decimal('sale_value', 10, 2)->nullable();
            $table->decimal('rental_value', 10, 2)->nullable();
            $table->decimal('iptu_value', 10, 2)->nullable();
            $table->decimal('condo_value', 10, 2)->nullable();
            $table->string('chronic_problem', 255)->nullable();
            $table->string('apartment_number', 5)->nullable();
            $table->integer('court')->nullable();
            $table->integer('tower')->nullable();
            $table->integer('floor')->nullable();
            $table->integer('lot')->nullable();
            $table->unsignedBigInteger('id_city');
            $table->unsignedBigInteger('id_locator');
            $table->unsignedBigInteger('id_condo');
            $table->foreign('id_city')->references('id')->on('cities');
            $table->foreign('id_locator')->references('id')->on('locators');
            $table->foreign('id_condo')->references('id')->on('condos')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};

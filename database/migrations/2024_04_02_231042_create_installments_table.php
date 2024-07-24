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
        Schema::create('installments', function (Blueprint $table) {
            $table->id();

            $table->integer('current_installment');
            $table->integer('total_installments');
            $table->integer('status'); // em aberto, pago, vencido
            $table->date('due_date');
            $table->date('date_received')->nullable();
            $table->string('description', 80);
            $table->string('identification_code', 15)->nullable();
            $table->string('observations', 100)->nullable();
            $table->integer('type_installment'); // parcela aluguel , caucao, seguro fianca


            $table->unsignedBigInteger('id_transact');
            $table->unsignedBigInteger('id_locator');
            $table->unsignedBigInteger('id_property');

            $table->foreign('id_transact')->references('id')->on('transactions');
            $table->foreign('id_locator')->references('id')->on('locators');
            $table->foreign('id_property')->references('id')->on('properties');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('installments');
    }
};

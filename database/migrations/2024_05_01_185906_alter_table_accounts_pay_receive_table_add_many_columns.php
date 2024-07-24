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
        Schema::table('accounts_pay_receive', function (Blueprint $table) {
            $table->unsignedBigInteger('id_property')->nullable();
            $table->foreign('id_property')->references('id')->on('properties');

            $table->unsignedBigInteger('id_transaction')->nullable();
            $table->foreign('id_transaction')->references('id')->on('transactions');

            $table->unsignedBigInteger('id_renter')->nullable();
            $table->foreign('id_renter')->references('id')->on('renters');

            $table->unsignedBigInteger('id_bank_account')->nullable();
            $table->foreign('id_bank_account')->references('id')->on('bank_accounts');
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

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
        Schema::create('casher', function (Blueprint $table) {
            $table->id();
            $table->integer('action');
            $table->string('previous_value', 10)->default('0');
            $table->decimal('current_value', 10, 2);
            $table->date('date_last_action');
            $table->date('date_current_action');

            $table->unsignedBigInteger('id_bank_account');
            $table->foreign('id_bank_account')->references('id')->on('bank_accounts');

            $table->unsignedBigInteger('id_installment')->nullable();
            $table->foreign('id_installment')->references('id')->on('installments');

            $table->unsignedBigInteger('id_transaction')->nullable();
            $table->foreign('id_transaction')->references('id')->on('transactions');

            $table->unsignedBigInteger('id_account_pay_receive')->nullable();
            $table->foreign('id_account_pay_receive')->references('id')->on('accounts_pay_receive');

            $table->unsignedBigInteger('id_check')->nullable();
            $table->foreign('id_check')->references('id')->on('checks');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('casher');
    }
};

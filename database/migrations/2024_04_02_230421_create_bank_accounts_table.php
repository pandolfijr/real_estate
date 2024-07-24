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
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('bank_code', 10);
            $table->string('bank_name', 30);
            $table->string('agency', 10);
            $table->string('account', 15);
            $table->integer('account_type'); // poupança, corrente
            $table->string('account_name', 30);
            $table->string('owner', 50)->nullable();
            $table->string('agreement', 10)->nullable(); //contrato
            $table->string('covenant', 10)->nullable(); // convenio
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
    }
};

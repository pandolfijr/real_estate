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
        Schema::create('checks', function (Blueprint $table) {
            $table->id();
            $table->string('number',20)->nullable();
            $table->date('issuance_date');
            $table->date('due_date');
            $table->date('deposit_date')->nullable();
            $table->date('compensation_date')->nullable();
            $table->string('bank_name',30);
            $table->string('type_transaction',40);

            $table->string('bank_agency',10)->nullable();
            $table->string('bank_account',20)->nullable();
            $table->string('favored_name',80);
            $table->string('description',100)->nullable();
            $table->integer('status');
            $table->integer('type');

            $table->unsignedBigInteger('id_transaction')->nullable();
            $table->foreign('id_transaction')->references('id')->on('transactions');



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checks');
    }
};

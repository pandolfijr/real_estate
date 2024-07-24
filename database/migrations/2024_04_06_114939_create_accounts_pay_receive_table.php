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
        Schema::create('accounts_pay_receive', function (Blueprint $table) {
            $table->id();
            $table->string('description', 80);
            $table->decimal('original_value', 10, 2);
            $table->decimal('penalty_value', 10, 2)->nullable();
            $table->decimal('final_value', 10, 2)->nullable();
            $table->integer('type');
            $table->integer('status');
            $table->integer('payment_method')->nullable();
            $table->integer('category')->nullable();
            $table->longText('observations')->nullable();
            $table->date('discharge_date')->nullable();
            $table->date('expect_date')->nullable();
            
            $table->unsignedBigInteger('id_supplier');
            $table->foreign('id_supplier')->references('id')->on('suppliers');

            $table->unsignedBigInteger('id_check')->nullable();
            $table->foreign('id_check')->references('id')->on('checks');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts_pay_receive');
    }
};

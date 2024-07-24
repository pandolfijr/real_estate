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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->date('contract_start_date')->nullable();
            $table->date('contract_end_date')->nullable();
            $table->date('first_due_date')->nullable();
            $table->date('generation_date')->nullable();

            $table->integer('due_day')->nullable();
            $table->integer('transaction_type')->nullable(); // 1 venda / 2 aluguel
            $table->integer('modality')->nullable(); // 1 fiador, 2 caucao, 3 seguro fianca
            $table->integer('responsible_insurance')->nullable(); // responsável seguro (1 proprietário, 2 Imobiliaria)
            $table->integer('responsible_iptu')->nullable(); // responsável iptu (1 proprietário, 2 Locatario, 3 Imobiliaria)
            $table->integer('type_of_charge')->nullable(); //boleto, pix, cartão
            // $table->integer('apartment_number')->nullable();
            $table->integer('number_installments')->nullable(); // numero de parcelas

            $table->string('observations', 255)->nullable();
            $table->string('witness', 100)->nullable(); //testemunha
            $table->string('insurance_number', 30)->nullable(); // número do seguro
            // $table->string('quad', 20)->nullable(); //quadra
            // $table->string('tower', 20)->nullable(); //torre
            // $table->string('lot', 10)->nullable(); // lote
            $table->string('contract_status', 10)->nullable(); // 1 Ativo, 2 Vencido, 3 Abandonado

            // $table->integer('floor')->nullable(); // andar
            $table->integer('status_transact')->nullable(); //status da transação efetivada/simulação

            $table->decimal('security_deposit', 10,2)->nullable(); //caucao
            $table->decimal('penalty_value', 10,2)->nullable(); // valor da multa
            $table->decimal('interest_month_value', 10,2)->nullable(); // juros mensal
            $table->decimal('administrative_tax', 10,2)->nullable(); // taxa administrativa
            $table->decimal('other_transfers', 10,2)->nullable(); // outros repasses
            $table->decimal('property_value', 10,2)->nullable();  // valor da propriedade
            $table->decimal('insurance_value', 10,2)->nullable(); // valor da parcela
            $table->decimal('condo_value', 10,2)->nullable(); // valor do condominio
            $table->decimal('iptu_value', 10,2)->nullable(); // valor do iptu
            $table->decimal('final_value', 10,2)->nullable(); // valor final

            $table->unsignedBigInteger('id_renter');
            $table->unsignedBigInteger('id_property');
            $table->unsignedBigInteger('id_locator');
            $table->unsignedBigInteger('id_first_guarantor')->nullable();
            $table->unsignedBigInteger('id_second_guarantor')->nullable();
            $table->unsignedBigInteger('id_keys')->nullable();
            $table->unsignedBigInteger('id_broker');


            $table->foreign('id_property')->references('id')->on('properties');
            $table->foreign('id_locator')->references('id')->on('locators');
            $table->foreign('id_renter')->references('id')->on('renters');
            $table->foreign('id_first_guarantor')->references('id')->on('guarantors');
            $table->foreign('id_second_guarantor')->references('id')->on('guarantors');
            $table->foreign('id_keys')->references('id')->on('keys_property');
            $table->foreign('id_broker')->references('id')->on('users');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

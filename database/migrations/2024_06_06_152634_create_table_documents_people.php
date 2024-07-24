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
        Schema::create('documents_people', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('description', 150);
            $table->string('type_document', 150);
            $table->boolean('main')->default(false);
            $table->string('folder', 150);
            $table->unsignedBigInteger('id_people');
            $table->foreign('id_people')->references('id')->on('people');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents_people');
    }
};

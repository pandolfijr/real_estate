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
        Schema::create('settings', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('fantasy_name', 30);
            $table->string('company_name', 50);
            $table->string('owner_name', 100);
            $table->string('menu_logo', 255)->nullable();
            $table->string('icon_logo', 255)->nullable();
            $table->longText('map')->nullable();
            $table->string('address', 100);
            $table->string('number', 5);
            $table->string('district', 30)->nullable();
            $table->string('cep', 9);
            $table->string('first_email', 40);
            $table->string('second_email', 40)->nullable();
            $table->string('third_email', 40)->nullable();
            $table->string('first_telephone', 11);
            $table->string('second_telephone', 11)->nullable();
            $table->string('third_telephone', 11)->nullable();
            $table->string('first_whatsapp', 11);
            $table->string('second_whatsapp', 11)->nullable();
            $table->string('third_whatsapp', 11)->nullable();
            $table->string('twitter', 150)->nullable();
            $table->string('facebook', 150)->nullable();
            $table->string('instagram', 150)->nullable();
            $table->string('skype', 50)->nullable();
            $table->string('linkedin', 150)->nullable();
            $table->string('youtube', 150)->nullable();
            $table->time('opening_time')->nullable();
            $table->time('closing_time')->nullable();
            $table->unsignedBigInteger('id_city');
            $table->foreign('id_city')->references('id')->on('cities');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};

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
        Schema::table('users', function (Blueprint $table) {
            $table->string('cellphone', 11)->nullable()->after('password');
            $table->string('cpf', 11)->nullable()->after('password');
            $table->integer('status')->comment("1 = Active, 2 = Inactive")->after('password');
            $table->integer('type')->comment("1 = Administrator, 2 = User, 3 = Master")->after('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('cellphone');
            $table->dropColumn('cpf');
            $table->dropColumn('status');
            $table->dropColumn('type');
        });
    }
};

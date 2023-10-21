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
            $table->unsignedBigInteger('empresa_id')->nullable()->after('id');
            $table->foreign('empresa_id')->on('empresas')->references('id');
            $table->string('firma')->after('email');
            $table->string('telefono')->after('firma');
            
            $table->enum('rol',['Técnico','Cliente'])->default('Cliente')->after('empresa_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('empresa_id');
            $table->dropColumn('telefono','rol');
        });
    }
};

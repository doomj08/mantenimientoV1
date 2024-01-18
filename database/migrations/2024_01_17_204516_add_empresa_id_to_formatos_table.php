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
        Schema::table('formatos', function (Blueprint $table) {
            // $table->unsignedBigInteger('empresa_id')->nullable()->after('id');
            // $table->foreign('empresa_id')->on('empresas')->references('id');
            // $table->unique(['empresa_id','version']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('formatos', function (Blueprint $table) {
            //$table->dropUnique(['empresa_id','cliente_id']);
        });
    }
};

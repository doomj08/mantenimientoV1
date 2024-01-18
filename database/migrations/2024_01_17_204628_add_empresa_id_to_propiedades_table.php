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
        Schema::table('propiedades', function (Blueprint $table) {
            $table->unsignedBigInteger('empresa_id')->nullable()->after('id');
            $table->foreign('empresa_id')->on('empresas')->references('id');
            //$table->unique(['empresa_id','articulo_id','campo_propiedad_id']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('propiedades', function (Blueprint $table) {
            // $table->unique(['empresa_id','articulo_id','campo_propiedad_id']);
            // $table->dropUnique('propiedades_empresa_id_articulo_id_unique');
        });
    }
};

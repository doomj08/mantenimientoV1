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
        Schema::table('tipo_articulos', function (Blueprint $table) {
            $table->unsignedBigInteger('empresa_id')->nullable()->after('id');
            $table->foreign('empresa_id')->on('empresas')->references('id');
            $table->unique(['empresa_id','tipo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tipo_articulos', function (Blueprint $table) {
            
            $table->dropUnique(['empresa_id','tipo']);
            //$table->dropConstrainedForeignId('empresa_id');
            //$table->dropColumn('empresa_id');
        });
    }
};

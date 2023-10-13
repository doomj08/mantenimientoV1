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
        Schema::create('campos_propiedades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_articulo_id')->constrained();
            $table->string('nombre_propiedad');
            $table->foreignId('seccion_formato_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campos_propiedades');
    }
};

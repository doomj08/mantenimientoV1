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
        Schema::create('articulos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_interno');
            $table->foreignId('tipo_articulo_id')->constrained();

            $table->unsignedBigInteger('articulo_padre_id')->nullable();
            $table->foreign('articulo_padre_id')->on('articulos')->references('id');

            $table->string('fabricante')->nullable();
            $table->string('modelo')->nullable();
            $table->string('no_serie')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articulos');
    }
};

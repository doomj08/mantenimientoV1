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
        Schema::create('servicio_pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('servicio_id')->constrained();
            $table->date('fecha');
            $table->enum('tipo_pago',['transferencia', 'efectivo', 'consignación']);
            $table->string('banco')->nullable();
            $table->string('num_cuenta')->nullable();
            $table->string('referencia')->nullable();
            $table->string('concepto');
            $table->double('valor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicio_pagos');
    }
};

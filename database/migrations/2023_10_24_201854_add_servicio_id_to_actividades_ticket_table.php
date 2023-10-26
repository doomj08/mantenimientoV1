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
        Schema::table('actividad_tickets', function (Blueprint $table) {
           $table->unsignedBigInteger('servicio_id')->nullable();
           $table->foreign('servicio_id')->on('servicio')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('actividad_tickets', function (Blueprint $table) {
            $table->dropForeign('servicio_id');
        });
    }
};

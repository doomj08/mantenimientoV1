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
            $table->datetime('fecha_cierre')->nullable()->after('estado_ticket');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('actividad_tickets', function (Blueprint $table) {
            $table->dropColumn('fecha_cierre');
        });
    }
};

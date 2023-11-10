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
            $table->unsignedBigInteger('tecnico_user_id')->nullable()->after('estado_ticket');
            $table->foreign('tecnico_user_id')->on('users')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('actividad_tickets', function (Blueprint $table) {
            $table->dropForeign('tecnico_user_id');
            $table->dropColumn('tecnico_user_id');
        });
    }
};

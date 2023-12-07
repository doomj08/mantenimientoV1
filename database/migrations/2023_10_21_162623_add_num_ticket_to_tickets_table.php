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
        Schema::table('tickets', function (Blueprint $table) {
            $table->foreignId('empresa_id')->constrained()->after('id');
            //$table->foreign('empresa_id')->on('empresas')->references('id');

            $table->string('num_ticket')->after('id')->default('id');
            $table->unique(['empresa_id','num_ticket']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            //$table->dropConstrainedForeignId('empresa_id');
            $table->dropUnique(['empresa_id','num_ticket']);
            $table->dropColumn('num_ticket');
                     
        });
    }
};

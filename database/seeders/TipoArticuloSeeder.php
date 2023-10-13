<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoArticuloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipo_articulos')->insert([
            'tipo' => "Computador",
        ]);

        DB::table('tipo_articulos')->insert([
            'tipo' => "Motherboard",
        ]);

        DB::table('tipo_articulos')->insert([
            'tipo' => "Chasis",
        ]);

        DB::table('tipo_articulos')->insert([
            'tipo' => "Computador",
        ]);
    }
}

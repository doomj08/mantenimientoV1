<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ArticuloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('articulos')->insert([
            'tipo_articulo_id' => 1,
            'nombre_interno' => Str::random(10),
        ]);
        DB::table('articulos')->insert([
            'tipo_articulo_id' => 2,
            'nombre_interno' => Str::random(10),
        ]);
        DB::table('articulos')->insert([
            'tipo_articulo_id' => 3,
            'nombre_interno' => Str::random(10),
        ]);
        DB::table('articulos')->insert([
            'tipo_articulo_id' => 4,
            'nombre_interno' => Str::random(10),
        ]);
    }
}

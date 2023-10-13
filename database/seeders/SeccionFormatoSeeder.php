<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeccionFormatoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('seccion_formatos')->insert([
            'formato_id' => 1,
            'seccion'=> 'Informe',
            'order'=>1
        ]);
        DB::table('seccion_formatos')->insert([
            'formato_id' => 1,
            'seccion'=> 'Resumen',
            'order'=>2
        ]);
        DB::table('seccion_formatos')->insert([
            'formato_id' => 1,
            'seccion'=> 'Ficha Técnica',
            'order'=>3
        ]);
        DB::table('seccion_formatos')->insert([
            'formato_id' => 1,
            'seccion'=> 'Propiedades del procesador',
            'order'=>1
        ]);
    }
}

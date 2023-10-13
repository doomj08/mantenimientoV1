<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CampoPropiedadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('campos_propiedades')->insert([
            'tipo_articulo_id' => 1,
            'nombre_propiedad' => "Fabricante del sistema",
            'seccion_formato_id' => 3,
        ]);
        DB::table('campos_propiedades')->insert([
            'tipo_articulo_id' => 1,
            'nombre_propiedad' => "Modelo",
            'seccion_formato_id' => 3,
        ]);
        DB::table('campos_propiedades')->insert([
            'tipo_articulo_id' => 1,
            'nombre_propiedad' => "Número de serie del sistema",
            'seccion_formato_id' => 3,
        ]);
        DB::table('campos_propiedades')->insert([
            'tipo_articulo_id' => 1,
            'nombre_propiedad' => "UUID del sistema",
            'seccion_formato_id' => 3,
        ]);
        DB::table('campos_propiedades')->insert([
            'tipo_articulo_id' => 1,
            'nombre_propiedad' => "Fabricante del motherboard",
            'seccion_formato_id' => 3,
        ]);
        DB::table('campos_propiedades')->insert([
            'tipo_articulo_id' => 1,
            'nombre_propiedad' => "Nombre del motherboard",
            'seccion_formato_id' => 3,
        ]);
        DB::table('campos_propiedades')->insert([
            'tipo_articulo_id' => 1,
            'nombre_propiedad' => "Versión del motherboard",
            'seccion_formato_id' => 3,
        ]);
        DB::table('campos_propiedades')->insert([
            'tipo_articulo_id' => 1,
            'nombre_propiedad' => "Número de serie del motherboard",
            'seccion_formato_id' => 3,
        ]);
        DB::table('campos_propiedades')->insert([
            'tipo_articulo_id' => 1,
            'nombre_propiedad' => "Fabricante del chasis",
            'seccion_formato_id' => 3,
        ]);
        DB::table('campos_propiedades')->insert([
            'tipo_articulo_id' => 1,
            'nombre_propiedad' => "Tipo de chasis",
            'seccion_formato_id' => 3,
        ]);
    }
}

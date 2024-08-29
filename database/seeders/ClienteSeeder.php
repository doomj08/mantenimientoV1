<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('clientes')->insert([
            'nombre' => Str::random(10),
            'num_documento'=>1,
            'contacto'=>1,
            'direccion'=>1,
            'ciudad'=>1,
            'correo'=>1,
            'telefono'=>1,
        ]);
        DB::table('clientes')->insert([
            'nombre' => Str::random(10),
            'num_documento'=>2,
            'contacto'=>2,
            'direccion'=>2,
            'ciudad'=>2,
            'correo'=>2,
            'telefono'=>2,
        ]);
        DB::table('clientes')->insert([
            'nombre' => Str::random(10),
            'num_documento'=>3,
            'contacto'=>3,
            'direccion'=>3,
            'ciudad'=>3,
            'correo'=>3,
            'telefono'=>3,
        ]);
    }
}

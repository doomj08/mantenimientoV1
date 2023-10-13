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
            'nombre' => Str::random(10)
        ]);
        DB::table('clientes')->insert([
            'nombre' => Str::random(10)
        ]);
        DB::table('clientes')->insert([
            'nombre' => Str::random(10)
        ]);
    }
}

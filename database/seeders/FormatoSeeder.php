<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormatoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('formatos')->insert([
            'cliente_id' => 1,
            'version'=> '1'
        ]);
        DB::table('formatos')->insert([
            'cliente_id' => 2,
            'version'=> '1'
        ]);
        DB::table('formatos')->insert([
            'cliente_id' => 3,
            'version'=> '1'
        ]);
    }
}

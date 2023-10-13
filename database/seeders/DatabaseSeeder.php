<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(TipoArticuloSeeder::class);
        $this->call(ClienteSeeder::class);
        $this->call(ClienteSeeder::class);
        $this->call(FormatoSeeder::class);
        $this->call(SeccionFormatoSeeder::class);
        $this->call(CampoPropiedadSeeder::class);
        $this->call(ArticuloSeeder::class);

    }
}

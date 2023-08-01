<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IdentificationTypeSedder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('identification_types')->insert([
            ['name'=>'Cedula de ciudadania'],         
            ['name'=>'Tarjeta de identidad'],    
            ['name'=>'Pasaporte'],    
        ]);
        //
    }
}

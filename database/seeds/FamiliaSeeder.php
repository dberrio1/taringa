<?php

use Illuminate\Database\Seeder;

class FamiliaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Familia::create(['nombre'=> 'lacteos']);
        \App\Familia::create(['nombre'=> 'abarrotes']);
        \App\Familia::create(['nombre'=> 'carnes']);
        \App\Familia::create(['nombre'=> 'destilados']);
        \App\Familia::create(['nombre'=> 'cervezas']);
    }
}

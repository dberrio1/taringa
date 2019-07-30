<?php

use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Unit::create(['unit'=>'unidad']);
        \App\Unit::create(['unit'=>'litro']);
        \App\Unit::create(['unit'=>'kilo']);
    }
}

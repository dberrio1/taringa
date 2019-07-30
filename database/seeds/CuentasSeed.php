<?php

use Illuminate\Database\Seeder;

class CuentasSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Cuenta::create(['cuenta'=>'personal']);
        \App\Cuenta::create(['cuenta'=>'cocina']);
        \App\Cuenta::create(['cuenta'=>'bar']);
    }
}

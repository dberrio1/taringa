<?php

use Illuminate\Database\Seeder;

class ObservationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \App\Observation::create([
            'cuenta' => 'bodega',
            'observacion' => 'producto en mal estado',
        ]);
        \App\Observation::create([
            'cuenta' => 'bodega',
            'observacion' => 'producto descompuesto',
        ]);
        \App\Observation::create([
            'cuenta' => 'bodega',
            'observacion' => 'producto calibre menor',
        ]);
        \App\Observation::create([
            'cuenta' => 'bodega',
            'observacion' => 'sin stock de proveedor',
        ]);
    }
}

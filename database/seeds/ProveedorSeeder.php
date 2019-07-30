<?php

use Illuminate\Database\Seeder;

class ProveedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Provider::create([
            'rut'=> '55555555-5',
            'nombre' => 'CCU',
            'contacto' => 'Pepito los Palotes',
            'correo' => 'pepito@ccu.cl',
            'fono' => '2221144'
        ]);
        \App\Provider::create([
            'rut'=> '99999999-9',
            'nombre' => 'Los Molinos',
            'contacto' => 'Calamardo',
            'correo' => 'calamardo@molinos.cl',
            'fono' => '9955447'
        ]);
        \App\Provider::create([
            'rut'=> '77777777-7',
            'nombre' => 'La Botica',
            'contacto' => 'Kenishi',
            'correo' => 'keny@botica.cl',
            'fono' => '3457698'
        ]);
        \App\Provider::create([
            'rut'=> '66666666-6',
            'nombre' => 'Carnicería Don Claudio',
            'contacto' => 'Chancho Man',
            'correo' => 'cm@gmail.cl',
            'fono' => '885574   '
        ]);
    }
}

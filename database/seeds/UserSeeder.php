<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'rut' => '15455766-0',
            'nombre' => 'Danilo Berríos',
            'password' => bcrypt('123456'),
            'profile_id' => '1',
            'div_id' => '1',
        ]);
        \App\User::create([
            'rut' => '11111111-1',
            'nombre' => 'Bodeguero Prueba',
            'password' => bcrypt('123456'),
            'profile_id' => '2',
            'div_id' => '1',
        ]);
        \App\User::create([
            'rut' => '22222222-2',
            'nombre' => 'Pablo Escobar',
            'password' => bcrypt('123456'),
            'profile_id' => '2',
            'div_id' => '2',
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;

class PerfilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Profile::create([
            'profile'=> 'Administrador',
        ]);
        \App\Profile::create([
            'profile'=> 'Bodega',
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;

class DivisionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Divisiones::create([
            'rut' => '99999999-9',
            'nombre' => 'Central',
            'nombre_corto'=>'Central',
            'giro' => 'Bodega centrra y administrador general',
            'direccion' => 'Sin direccion',
            'comuna' => 'Sin comuna',
            'correo' => 'sin Correo',
            'fono' => '1111111',
        ]);
        \App\Divisiones::create([
            'rut' => '76981933-9',
            'nombre' => 'Fenix SPA.',
            'nombre_corto'=>'Fenix',
            'giro' => 'Actividades de Restaurantes y de Servicio Movil de Comidas',
            'direccion' => 'La Dehesa #1822',
            'comuna' => 'Lo Barnechea',
            'correo' => 'sp@peito.cl',
            'fono' => '3334466',
        ]);
        \App\Divisiones::create([
            'rut' => '76085503-0',
            'nombre' => 'Invesiones y Servicios Gastronomicos Alianza Ltda.',
            'nombre_corto'=>'Taringa',
            'giro' => 'Restaurant, Establecimientos Similares, Prod. de Enventos e Inversiones',
            'direccion' => 'Av. Vitacura # 5336',
            'comuna' => 'Vitacura',
            'correo' => 'sp@peito.cl',
            'fono' => '3334466',
        ]);
        \App\Divisiones::create([
            'rut' => '76458097-4',
            'nombre' => 'Invesiones y Servicios Gastronomicos Taringuita Ltda.',
            'nombre_corto'=>'Taringuita',
            'giro' => 'Servicios Gastronomicos e Inversiones',
            'direccion' => 'hj Puertesillo Lt 1 hda t s/n',
            'comuna' => 'Lituache',
            'correo' => 'sp@peito.cl',
            'fono' => '3334466',
        ]);
    }
}

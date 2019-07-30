<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(PerfilSeeder::class);
        $this->call(DivisionesSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(FamiliaSeeder::class);
        $this->call(CuentasSeed::class);
        $this->call(UnitSeeder::class);
        $this->call(ProveedorSeeder::class);
        $this->call(ProductosSeeder::class);
        $this->call(RelProvProdSeeder::class);
        $this->call(ObservationsSeeder::class);
    }
}

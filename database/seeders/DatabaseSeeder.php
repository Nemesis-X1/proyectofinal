<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $this->call(DocumentoSeeder::class);
        $this->call(ComprobanteSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(UbicacioneSeeder::class);
        $this->call(MonedaSeeder::class);
        $this->call(EmpresaSeeder::class);

        // Test Data
        $this->call(CategoriaSeeder::class);
        $this->call(MarcaSeeder::class);
        $this->call(PresentacioneSeeder::class);
        $this->call(ProductoSeeder::class);
        $this->call(ClienteSeeder::class);
        $this->call(ProveedorSeeder::class);
        $this->call(InventarioSeeder::class);
    }
}

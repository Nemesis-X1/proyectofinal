<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Administrador',
                'password' => bcrypt('admin')
            ]
        );

        //Usuario administrador
        $rolAdmin = Role::firstOrCreate(['name' => 'administrador']);
        $permisos = Permission::pluck('id', 'id')->all();
        $rolAdmin->syncPermissions($permisos);
        $user->assignRole($rolAdmin);

        // Otros roles
        $rolEncargado = Role::firstOrCreate(['name' => 'encargado de sucursal']);
        $rolEncargado->syncPermissions($permisos); // Encargado gets everything too for now

        $rolVendedor = Role::firstOrCreate(['name' => 'vendedor']);
        $rolVendedor->syncPermissions([
            'ver-venta', 'crear-venta', 'mostrar-venta',
            'ver-cliente', 'crear-cliente',
            'ver-producto'
        ]);

        $rolAlmacen = Role::firstOrCreate(['name' => 'almacen']);
        $rolAlmacen->syncPermissions([
            'ver-inventario', 'editar-inventario', 'ajustar-inventario', 'ver-reporte-inventario',
            'ver-producto', 'ver-categoria', 'ver-marca', 'ver-presentacione'
        ]);
    }
}

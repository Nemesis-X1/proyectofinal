<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productos = [
            [
                'nombre' => 'Choco Fun',
                'descripcion' => 'Crema tinte hidratante para labios con aroma a chocolate.',
                'codigo' => '6969696969',
                'precio' => 0,
                'categoria_id' => 1,
                'marca_id' => 1,
                'presentacione_id' => 1
            ]
        ];

        foreach ($productos as $data) {
            \App\Models\Producto::updateOrCreate(
                ['codigo' => $data['codigo']],
                $data
            );
        }
    }
}

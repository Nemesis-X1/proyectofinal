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
                'nombre' => 'Amoxicilina 500mg',
                'descripcion' => 'Caja de 30 tabletas',
                'codigo' => '770123456789',
                'precio' => 15.50,
                'categoria_id' => 1,
                'marca_id' => 1,
                'presentacione_id' => 3
            ],
            [
                'nombre' => 'Paracetamol 1g',
                'descripcion' => 'Sobre de 10 tabletas',
                'codigo' => '770987654321',
                'precio' => 2.00,
                'categoria_id' => 2,
                'marca_id' => 2,
                'presentacione_id' => 5
            ],
            [
                'nombre' => 'Vitamina C Efervescente',
                'descripcion' => 'Tubo con 10 tabletas',
                'codigo' => '770555444333',
                'precio' => 8.50,
                'categoria_id' => 3,
                'marca_id' => 3,
                'presentacione_id' => 4
            ],
            [
                'nombre' => 'Jabón de Tocador Johnson',
                'descripcion' => 'Fragancia original',
                'codigo' => '770111222333',
                'precio' => 3.25,
                'categoria_id' => 4,
                'marca_id' => 5,
                'presentacione_id' => 1
            ],
            [
                'nombre' => 'Alcohol Antiséptico 70%',
                'descripcion' => 'Frasco de 500ml',
                'codigo' => '770444555666',
                'precio' => 5.00,
                'categoria_id' => 5,
                'marca_id' => 4,
                'presentacione_id' => 2
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

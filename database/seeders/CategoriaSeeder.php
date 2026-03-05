<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            ['nombre' => 'Cosméticos', 'descripcion' => 'Productos de belleza y cuidado personal.']
        ];

        foreach ($categorias as $item) {
            $caracteristica = \App\Models\Caracteristica::firstOrCreate(
                ['nombre' => $item['nombre']],
                ['descripcion' => $item['descripcion'], 'estado' => 1]
            );

            \App\Models\Categoria::firstOrCreate([
                'caracteristica_id' => $caracteristica->id
            ]);
        }
    }
}

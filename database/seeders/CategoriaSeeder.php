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
            ['nombre' => 'Antibióticos', 'descripcion' => 'Medicamentos para infecciones'],
            ['nombre' => 'Analgésicos', 'descripcion' => 'Alivio del dolor'],
            ['nombre' => 'Vitaminas', 'descripcion' => 'Suplementos alimenticios'],
            ['nombre' => 'Cuidado Personal', 'descripcion' => 'Higiene y belleza'],
            ['nombre' => 'Primeros Auxilios', 'descripcion' => 'Material de curación']
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

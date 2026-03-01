<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MarcaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $marcas = [
            ['nombre' => 'Bayer', 'descripcion' => 'Laboratorio internacional'],
            ['nombre' => 'Pfizer', 'descripcion' => 'Laboratorio internacional'],
            ['nombre' => 'Genfar', 'descripcion' => 'Medicamentos genéricos'],
            ['nombre' => 'Colgate', 'descripcion' => 'Cuidado bucal'],
            ['nombre' => 'Johnson & Johnson', 'descripcion' => 'Cuidado infantil y personal']
        ];

        foreach ($marcas as $item) {
            $caracteristica = \App\Models\Caracteristica::firstOrCreate(
                ['nombre' => $item['nombre']],
                ['descripcion' => $item['descripcion'], 'estado' => 1]
            );

            \App\Models\Marca::firstOrCreate([
                'caracteristica_id' => $caracteristica->id
            ]);
        }
    }
}

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
            ['nombre' => 'Fenzza', 'descripcion' => 'Cosméticos de calidad brasileros.']
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

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PresentacioneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $presentaciones = [
            ['nombre' => 'Envase de Plástico', 'descripcion' => 'Envase de Plastico', 'sigla' => 'EP']
        ];

        foreach ($presentaciones as $item) {
            $caracteristica = \App\Models\Caracteristica::firstOrCreate(
                ['nombre' => $item['nombre']],
                ['descripcion' => $item['descripcion'], 'estado' => 1]
            );

            \App\Models\Presentacione::firstOrCreate(
                ['caracteristica_id' => $caracteristica->id],
                ['sigla' => $item['sigla']]
            );
        }
    }
}

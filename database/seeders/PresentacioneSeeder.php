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
            ['nombre' => 'Caja', 'descripcion' => 'Caja de cartón', 'sigla' => 'CJ'],
            ['nombre' => 'Frasco', 'descripcion' => 'Envase de vidrio o plástico', 'sigla' => 'FR'],
            ['nombre' => 'Tableta', 'descripcion' => 'Blister de pastillas', 'sigla' => 'TB'],
            ['nombre' => 'Tubo', 'descripcion' => 'Crema o gel', 'sigla' => 'TU'],
            ['nombre' => 'Sobre', 'descripcion' => 'Polvo o granulado', 'sigla' => 'SB']
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

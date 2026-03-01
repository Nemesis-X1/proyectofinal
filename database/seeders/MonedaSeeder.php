<?php

namespace Database\Seeders;

use App\Models\Moneda;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MonedaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $monedas = [
            ['iso' => 'USD', 'nombre' => 'Dólar estadounidense', 'simbolo' => '$'],
            ['iso' => 'EUR', 'nombre' => 'Euro', 'simbolo' => '€'],
            ['iso' => 'MXN', 'nombre' => 'Peso mexicano', 'simbolo' => '$'],
            ['iso' => 'PEN', 'nombre' => 'Sol peruano', 'simbolo' => 'S/'],
            ['iso' => 'ARS', 'nombre' => 'Peso Argentino', 'simbolo' => '$'],
            ['iso' => 'CLP', 'nombre' => 'Peso Chileno', 'simbolo' => '$'],
            ['iso' => 'BOB', 'nombre' => 'Boliviano', 'simbolo' => 'Bs.'],
        ];

        foreach ($monedas as $moneda) {
            Moneda::firstOrCreate(
                ['estandar_iso' => $moneda['iso']],
                ['nombre_completo' => $moneda['nombre'], 'simbolo' => $moneda['simbolo']]
            );
        }
    }
}

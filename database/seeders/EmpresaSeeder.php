<?php

namespace Database\Seeders;

use App\Models\Empresa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $moneda = \App\Models\Moneda::where('estandar_iso', 'BOB')->first();

        Empresa::updateOrCreate(
            ['ruc' => '123456789'],
            [
                'nombre' => 'KRALICENTER',
                'propietario' => 'Marcelo Guzman Beltran',
                'porcentaje_impuesto' => '0',
                'abreviatura_impuesto' => 'N/A',
                'direccion' => 'Villa 1ro de Mayo',
                'moneda_id' => $moneda->id ?? 1
            ]
        );
    }
}

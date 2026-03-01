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
            ['ruc' => '1089674538'],
            [
                'nombre' => 'SK SAC',
                'propietario' => 'Sak Code',
                'porcentaje_impuesto' => '0',
                'abreviatura_impuesto' => 'IGV',
                'direccion' => 'Av. Los Pinos n°789',
                'moneda_id' => $moneda->id ?? 1
            ]
        );
    }
}

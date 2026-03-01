<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clientes = [
            [
                'razon_social' => 'Juan Pérez',
                'direccion' => 'Calle 10 # 5-20',
                'tipo_documento_id' => 1,
                'numero_documento' => '10203040',
                'tipo_persona' => \App\Enums\TipoPersonaEnum::Natural
            ],
            [
                'razon_social' => 'Maria López',
                'direccion' => 'Av. Principal # 50',
                'tipo_documento_id' => 1,
                'numero_documento' => '50607080',
                'tipo_persona' => \App\Enums\TipoPersonaEnum::Natural
            ],
            [
                'razon_social' => 'Farmacia Central S.A.',
                'direccion' => 'Centro Comercial Gran Plaza',
                'tipo_documento_id' => 1,
                'numero_documento' => '900100200',
                'tipo_persona' => \App\Enums\TipoPersonaEnum::Juridica
            ]
        ];

        foreach ($clientes as $data) {
            $persona = \App\Models\Persona::firstOrCreate(
                ['numero_documento' => $data['numero_documento']],
                [
                    'razon_social' => $data['razon_social'],
                    'direccion' => $data['direccion'],
                    'documento_id' => $data['tipo_documento_id'],
                    'tipo' => $data['tipo_persona'],
                    'estado' => 1
                ]
            );

            $persona->cliente()->firstOrCreate([]);
        }
    }
}

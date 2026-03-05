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
                'razon_social' => 'Cliente Predeterminado',
                'direccion' => 'Villa 1ro de Mayo',
                'tipo_documento_id' => 1,
                'numero_documento' => '123456',
                'tipo_persona' => \App\Enums\TipoPersonaEnum::Natural
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

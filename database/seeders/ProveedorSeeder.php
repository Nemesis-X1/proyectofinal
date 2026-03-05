<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProveedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $proveedores = [
            [
                'razon_social' => 'Fenzza Bolivia',
                'direccion' => 'Av. Mutualista #76',
                'tipo_documento_id' => 1,
                'numero_documento' => '567419874',
                'tipo_persona' => \App\Enums\TipoPersonaEnum::Juridica
            ]
        ];

        foreach ($proveedores as $data) {
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

            $persona->proveedore()->firstOrCreate([]);
        }
    }
}

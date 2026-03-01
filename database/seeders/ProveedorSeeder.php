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
                'razon_social' => 'Laboratorios Roche',
                'direccion' => 'Zona Industrial Bloque A',
                'tipo_documento_id' => 1,
                'numero_documento' => '800500100',
                'tipo_persona' => \App\Enums\TipoPersonaEnum::Juridica
            ],
            [
                'razon_social' => 'Droguería San Jorge',
                'direccion' => 'Av. de las Américas 12-32',
                'tipo_documento_id' => 1,
                'numero_documento' => '700400200',
                'tipo_persona' => \App\Enums\TipoPersonaEnum::Juridica
            ],
            [
                'razon_social' => 'Insumos Médicos Express',
                'direccion' => 'Calle 45 # 12-05',
                'tipo_documento_id' => 1,
                'numero_documento' => '600300400',
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

<?php

namespace Database\Seeders;

use App\Models\Ubicacione;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UbicacioneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ubicaciones = [
            'Estante 1', 'Estante 2', 'Estante 3',
            'Estante 4', 'Estante 5', 'Estante 6',
            'Estante 7', 'Estante 8', 'Estante 9'
        ];

        foreach ($ubicaciones as $nombre) {
            Ubicacione::firstOrCreate(['nombre' => $nombre]);
        }
    }
}

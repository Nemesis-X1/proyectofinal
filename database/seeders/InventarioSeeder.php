<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InventarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productos = \App\Models\Producto::all();
        $ubicaciones = \App\Models\Ubicacione::all();

        foreach ($productos as $index => $producto) {
            $cantidad = ($index == 1 || $index == 3) ? 3 : 50; // Some low stock
            $stock_minimo = 10;
            
            $inventario = \App\Models\Inventario::firstOrCreate(
                ['producto_id' => $producto->id],
                [
                    'cantidad' => $cantidad,
                    'ubicacione_id' => $ubicaciones->random()->id,
                    'fecha_vencimiento' => now()->addMonths(6)->addDays($index),
                    'stock_minimo' => $stock_minimo
                ]
            );

            // Kardex entry for initialization - only if not exists for this product and Apertura
            $existeKardex = \App\Models\Kardex::where('producto_id', $producto->id)
                ->where('tipo_transaccion', \App\Enums\TipoTransaccionEnum::Apertura)
                ->exists();

            if (!$existeKardex) {
                $kardex = new \App\Models\Kardex();
                $kardex->crearRegistro([
                    'producto_id' => $producto->id,
                    'cantidad' => $cantidad,
                    'costo_unitario' => $producto->precio * 0.7,
                ], \App\Enums\TipoTransaccionEnum::Apertura);
            }
        }
    }
}

<?php

namespace App\Observers;

use App\Models\Inventario;
use App\Models\Kardex;
use App\Models\Producto;

class InventarioObserver
{
    /**
     * Handle the Inventario "created" event.
     */
    public function created(Inventario $inventario): void
    {
        //Sincronizar estado del producto con su inventario.
        Producto::where('id', $inventario->producto_id)
            ->update([
                'estado' => (int)$inventario->estado,
            ]);
    }

    /**
     * Handle the Inventario "updated" event.
     */
    public function updated(Inventario $inventario): void
    {
        //
    }

    public function saved(Inventario $inventario): void
    {
        $producto = Producto::findOrfail($inventario->producto_id);
        $kardex = new Kardex();

        // Evita sobrescribir manualmente el precio de venta inicial del producto.
        if (!is_null($producto->precio)) {
            return;
        }

        $precioCalculado = $kardex->calcularPrecioVenta($producto->id);
        if ($precioCalculado <= 0) {
            return;
        }

        $producto->update([
            'precio' => $precioCalculado,
        ]);
    }

    /**
     * Handle the Inventario "deleted" event.
     */
    public function deleted(Inventario $inventario): void
    {
        //
    }

    /**
     * Handle the Inventario "restored" event.
     */
    public function restored(Inventario $inventario): void
    {
        //
    }

    /**
     * Handle the Inventario "force deleted" event.
     */
    public function forceDeleted(Inventario $inventario): void
    {
        //
    }
}

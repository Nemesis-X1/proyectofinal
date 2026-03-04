<?php

namespace App\Listeners;

use App\Events\CreateCompraDetalleEvent;
use App\Models\Inventario;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateInventarioCompraListener
{
    /**
     * Create the event listener.
     */
    public function __construct() {}

    /**
     * Handle the event.
     */
    public function handle(CreateCompraDetalleEvent $event): void
    {
        $registro = Inventario::where('producto_id', $event->producto_id)->first();

        if (!$registro) {
            $ubicacionDefault = \App\Models\Ubicacione::first();
            Inventario::create([
                'producto_id' => $event->producto_id,
                'ubicacione_id' => $ubicacionDefault ? $ubicacionDefault->id : 1,
                'cantidad' => $event->cantidad,
                'fecha_vencimiento' => $event->fecha_vencimiento,
                'margen_porcentaje' => $event->margen_porcentaje,
                'margen_fijo' => $event->margen_fijo,
                'estado' => true,
            ]);
        } else {
            $registro->update([
                'cantidad' => ($registro->cantidad + $event->cantidad),
                'fecha_vencimiento' => $event->fecha_vencimiento,
                'margen_porcentaje' => $event->margen_porcentaje,
                'margen_fijo' => $event->margen_fijo,
            ]);
        }
    }
}

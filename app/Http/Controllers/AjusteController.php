<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Enums\TipoTransaccionEnum;
use App\Models\Inventario;
use App\Models\Kardex;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class AjusteController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ajustar-inventario', ['only' => ['create', 'store']]);
    }

    public function create(Inventario $inventario): View
    {
        return view('inventario.ajuste', compact('inventario'));
    }

    public function store(Request $request, Inventario $inventario): RedirectResponse
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1',
            'tipo_ajuste' => 'required|in:positivo,negativo',
            'motivo' => 'required|string|max:255'
        ]);

        DB::beginTransaction();
        try {
            $tipo = $request->tipo_ajuste === 'positivo' 
                    ? TipoTransaccionEnum::AjustePositivo 
                    : TipoTransaccionEnum::AjusteNegativo;

            // Actualizar Inventario
            if ($tipo === TipoTransaccionEnum::AjustePositivo) {
                $inventario->increment('cantidad', $request->cantidad);
            } else {
                if ($inventario->cantidad < $request->cantidad) {
                    return back()->with('error', 'No hay suficiente stock para realizar este ajuste negativo.');
                }
                $inventario->decrement('cantidad', $request->cantidad);
            }

            // Registrar en Kardex
            $kardex = new Kardex();
            $kardex->crearRegistro([
                'producto_id' => $inventario->producto_id,
                'cantidad' => $request->cantidad,
                'motivo' => $request->motivo,
                'costo_unitario' => $inventario->producto->precio // Asumiendo precio como costo actual, idealmente debería venir de Kardex
            ], $tipo);

            DB::commit();
            return redirect()->route('inventario.index')->with('success', 'Ajuste realizado correctamente');

        } catch (Throwable $e) {
            DB::rollBack();
            Log::error('Error en ajuste de inventario: ' . $e->getMessage());
            return back()->with('error', 'Error al realizar el ajuste');
        }
    }
}

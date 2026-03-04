<?php

namespace App\Http\Controllers;

use App\Enums\TipoTransaccionEnum;
use App\Http\Requests\StoreInventarioRequest;
use App\Models\Inventario;
use App\Models\Kardex;
use App\Models\Producto;
use App\Models\Ubicacione;
use App\Services\ActivityLogService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Throwable;

class InventarioController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-inventario|crear-inventario|editar-inventario|ajustar-inventario|ver-reporte-inventario', ['only' => ['index']]);
        $this->middleware('permission:editar-inventario', ['only' => ['edit', 'update']]);
        $this->middleware('permission:ver-reporte-inventario', ['only' => ['reporte', 'exportarReportePDF']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $inventario = Inventario::latest()->get();
        return view('inventario.index', compact('inventario'));
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $inventario = Inventario::with('producto', 'ubicacione')->findOrFail($id);
        $ubicaciones = Ubicacione::all();
        return view('inventario.edit', compact('inventario', 'ubicaciones'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:0',
            'ubicacione_id' => 'required|exists:ubicaciones,id',
            'fecha_vencimiento' => 'nullable|date',
            'stock_minimo' => 'nullable|integer|min:0',
        ]);

        try {
            $inventario = Inventario::findOrFail($id);
            $inventario->update($request->all());
            return redirect()->route('inventario.index')->with('success', 'Inventario actualizado exitosamente');
        } catch (Throwable $e) {
            Log::error('Error actualizando inventario: ' . $e->getMessage());
            return redirect()->route('inventario.index')->with('error', 'Ocurrió un error al actualizar el inventario');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function reporte(): View
    {
        $inventario = Inventario::with('producto')->get();
        $rotacion = DB::table('producto_venta')
            ->join('productos', 'productos.id', '=', 'producto_venta.producto_id')
            ->select('productos.nombre', DB::raw('SUM(producto_venta.cantidad) as total_vendido'))
            ->groupBy('productos.id', 'productos.nombre')
            ->orderBy('total_vendido', 'desc')
            ->get();

        return view('inventario.reporte', compact('inventario', 'rotacion'));
    }

    public function exportarReportePDF()
    {
        $inventario = Inventario::with('producto')->get();
        $rotacion = DB::table('producto_venta')
            ->join('productos', 'productos.id', '=', 'producto_venta.producto_id')
            ->select('productos.nombre', DB::raw('SUM(producto_venta.cantidad) as total_vendido'))
            ->groupBy('productos.id', 'productos.nombre')
            ->orderBy('total_vendido', 'desc')
            ->get();

        $pdf = Pdf::loadView('pdf.reporte-inventario', compact('inventario', 'rotacion'));
        return $pdf->stream('reporte-inventario.pdf');
    }
}

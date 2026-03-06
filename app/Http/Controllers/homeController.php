<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class homeController extends Controller
{
    public function index(): View|RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login.index');
        }

        $filter = request('filter', 'week');
        $fechaInicio = null;
        $fechaFin = Carbon::now();

        switch ($filter) {
            case 'day':
                $fechaInicio = Carbon::today();
                break;
            case 'month':
                $fechaInicio = Carbon::now()->startOfMonth();
                break;
            case 'custom':
                $fechaInicio = request('fecha_inicio') ? Carbon::parse(request('fecha_inicio')) : Carbon::now()->subDays(7);
                $fechaFin = request('fecha_fin') ? Carbon::parse(request('fecha_fin'))->endOfDay() : Carbon::now();
                break;
            case 'week':
            default:
                $fechaInicio = Carbon::now()->subDays(7);
                break;
        }

        $totalVentasPorDia = DB::table('ventas')
            ->selectRaw('DATE(fecha_hora) as fecha, SUM(total) as total')
            ->whereBetween('fecha_hora', [$fechaInicio, $fechaFin])
            ->groupBy(DB::raw('DATE(fecha_hora)'))
            ->orderBy('fecha', 'asc')
            ->get()->toArray();

        // Top 5 productos más vendidos
        $masVendidos = DB::table('producto_venta')
            ->join('ventas', 'producto_venta.venta_id', '=', 'ventas.id')
            ->join('productos', 'producto_venta.producto_id', '=', 'productos.id')
            ->whereBetween('ventas.fecha_hora', [$fechaInicio, $fechaFin])
            ->selectRaw('productos.nombre, SUM(producto_venta.cantidad) as total_vendido, SUM(producto_venta.cantidad * producto_venta.precio_venta) as total_bs')
            ->groupBy('productos.id', 'productos.nombre')
            ->orderByDesc('total_vendido')
            ->limit(5)
            ->get();

        // Top 5 productos menos vendidos (que tienen al menos 1 venta)
        $menosVendidos = DB::table('producto_venta')
            ->join('ventas', 'producto_venta.venta_id', '=', 'ventas.id')
            ->join('productos', 'producto_venta.producto_id', '=', 'productos.id')
            ->whereBetween('ventas.fecha_hora', [$fechaInicio, $fechaFin])
            ->selectRaw('productos.nombre, SUM(producto_venta.cantidad) as total_vendido, SUM(producto_venta.cantidad * producto_venta.precio_venta) as total_bs')
            ->groupBy('productos.id', 'productos.nombre')
            ->orderBy('total_vendido', 'asc')
            ->limit(5)
            ->get();

        $moneda = \App\Models\Empresa::with('moneda')->first()->moneda->simbolo ?? 'Bs.';

        // Productos con stock bajo: cantidad actual <= cantidad_minima (o 10 si no está definido)
        $stockBajo = DB::table('inventario')
            ->join('productos', 'inventario.producto_id', '=', 'productos.id')
            ->whereRaw('inventario.cantidad <= COALESCE(inventario.cantidad_minima, 10)')
            ->orderBy('inventario.cantidad', 'asc')
            ->limit(10)
            ->select('productos.nombre', 'inventario.cantidad', 'inventario.cantidad_minima')
            ->get();

        return view('panel.index', compact('totalVentasPorDia', 'masVendidos', 'menosVendidos', 'moneda', 'stockBajo'));
    }
}

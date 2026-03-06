<?php

namespace App\Http\Controllers;

use App\Jobs\DownloadExcelVentasAllJob;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ExportExcelController extends Controller
{
    /**
     * Exportar en EXCEL todas las ventas
     */
    public function exportExcelVentasAll(): RedirectResponse
    {
        $filename = 'ventas_' . now()->format('Y_m_d_His') . '.xlsx';
        DownloadExcelVentasAllJob::dispatch($filename, Auth::id());

        return redirect()->route('ventas.index')->with('success', 'Procesando descarga');
    }

    /**
     * Descargar el archivo EXCEL de ventas
     */
    public function downloadExcelVentas(string $filename)
    {
        $path = 'reportesExcelVentas/' . $filename;
        if (!\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
            abort(404);
        }

        return \Illuminate\Support\Facades\Storage::disk('public')->download($path);
    }
}

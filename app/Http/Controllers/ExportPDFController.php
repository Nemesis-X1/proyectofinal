<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Venta;
use App\Models\Compra;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Crypt;

class ExportPDFController extends Controller
{
    /**
     * Exportar en formato PDF el comprobante de venta
     */
    public function exportPdfComprobanteVenta(Request $request): Response
    {
        $id = Crypt::decrypt($request->id);

        $venta = Venta::findOrfail($id);
        $empresa = Empresa::first();

        $pdf = Pdf::loadView('pdf.comprobante-venta', [
            'venta' => $venta,
            'empresa' => $empresa
        ]);

        return $pdf->stream('venta-' . $venta->id);
    }

    /**
     * Exportar en formato PDF el reporte de compra
     */
    public function exportPdfComprobanteCompra(Request $request): Response
    {
        $id = Crypt::decrypt($request->id);

        $compra = Compra::findOrfail($id);
        $empresa = Empresa::first();

        $pdf = Pdf::loadView('pdf.comprobante-compra', [
            'compra' => $compra,
            'empresa' => $empresa
        ]);

        return $pdf->stream('compra-' . $compra->id);
    }
}

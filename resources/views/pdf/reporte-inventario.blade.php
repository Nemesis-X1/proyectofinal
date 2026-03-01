<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Inventario</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .title { font-size: 18px; font-weight: bold; margin-bottom: 5px; }
        .section-title { font-size: 14px; font-weight: bold; margin-top: 20px; margin-bottom: 10px; color: #333; border-bottom: 2px solid #ccc; padding-bottom: 5px; }
        .badge { padding: 3px 6px; border-radius: 4px; color: white; }
        .bg-danger { background-color: #dc3545; }
        .bg-success { background-color: #28a745; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">REPORTE DE INVENTARIO Y ROTACIÓN</div>
        <div>Fecha de generación: {{ date('d/m/Y H:i') }}</div>
    </div>

    <div class="section-title">Niveles de Stock Atual</div>
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Stock Actual</th>
                <th>Stock Mínimo</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($inventario as $item)
            <tr>
                <td>{{ $item->producto->nombre }}</td>
                <td>{{ $item->cantidad }}</td>
                <td>{{ $item->stock_minimo }}</td>
                <td>
                    @if($item->cantidad <= $item->stock_minimo)
                        BAJO STOCK
                    @else
                        NORMAL
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">Rotación de Productos (Ventas Totales)</div>
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Total Vendido</th>
                <th>Nivel de Rotación</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rotacion as $item)
            <tr>
                <td>{{ $item->nombre }}</td>
                <td>{{ $item->total_vendido }}</td>
                <td>
                    @if($item->total_vendido > 50)
                        ALTA
                    @elseif($item->total_vendido > 10)
                        MEDIA
                    @else
                        BAJA
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

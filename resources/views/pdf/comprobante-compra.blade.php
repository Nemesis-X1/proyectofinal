<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobante de compra</title>
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }

    .boleta {
        max-width: 600px;
        margin: 20px auto;
        padding: 20px;
        background: #fff;
        border: 1px solid #ddd;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .header {
        margin-bottom: 15px;
    }

    .header .column .column {
        text-align: center;
        margin-bottom: 10px;
    }

    .header .column h1 {
        font-size: 14px;
        margin-bottom: 5px;
    }

    .header .column div {
        font-size: 12px;
        margin-bottom: 5px;
    }

    .header .bordered {
        border: 1px solid #000;
        padding: 10px;
        font-size: 12px;
    }

    .datos {
        margin-bottom: 20px;
    }

    .datos div {
        font-size: 12px;
        margin-bottom: 5px;
    }

    .tabla {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .tabla th,
    .tabla td {
        border: 1px solid #ddd;
        text-align: left;
        padding: 8px;
        font-size: 14px;
    }

    .tabla th {
        background-color: #f4f4f4;
        font-weight: bold;
    }

    .footer {
        text-align: center;
        font-size: 12px;
        margin-top: 20px;
    }
</style>

<body>
    <div class="boleta">
        <div class="header">
            <div class="column">
                <div class="column bordered">
                    <div><strong>{{strtoupper($compra->comprobante->nombre)}} DE COMPRA</strong></div>
                    <div><strong>{{$compra->numero_comprobante}}</strong></div>
                </div>

                <h1>{{$empresa->nombre}}</h1>
                <div>RUC N°: {{$empresa->ruc}}</div>
                <div>{{strtoupper($empresa->direccion)}} - {{strtoupper($empresa->ubicacion)}}</div>
                <div>CEL: {{$empresa->telefono ?? ''}}</div>
                <div>Correo: {{$empresa->correo ?? ''}}</div>
            </div>

        </div>

        <div class="datos">
            <div><strong>Proveedor/Razón Social:</strong> {{strtoupper($compra->proveedore->persona->razon_social)}}</div>
            <div><strong>Dirección:</strong> {{strtoupper($compra->proveedore->persona->direccion)}}</div>
            <div><strong>{{strtoupper($compra->proveedore->persona->documento->nombre)}}:</strong> {{$compra->proveedore->persona->numero_documento}}</div>
            <div><strong>Fecha:</strong> {{date("d/m/Y", strtotime($compra->fecha_hora))}}</div>
            <div><strong>Hora:</strong> {{date("H:i", strtotime($compra->fecha_hora))}}</div>
        </div>

        <table class="tabla">
            <thead>
                <tr>
                    <th>Cant.</th>
                    <th>Unidad</th>
                    <th>Descripción</th>
                    <th>Precio Compra</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($compra->productos as $detalle)
                <tr>
                    <td>{{$detalle->pivot->cantidad}}</td>
                    <td>{{$detalle->presentacione->sigla}}</td>
                    <td>{{$detalle->nombre}}</td>
                    <td>{{$detalle->pivot->precio_compra}}</td>
                    <td>{{$detalle->pivot->cantidad * $detalle->pivot->precio_compra}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="datos">
            @php
                $suma = 0;
                foreach($compra->productos as $p){
                    $suma += $p->pivot->cantidad * $p->pivot->precio_compra;
                }
            @endphp
            <div><strong>Subtotal:</strong> {{$suma}} {{$empresa->moneda->simbolo}}</div>
            <div style="display: none;"><strong>{{$empresa->abreviatura_impuesto}}:</strong> {{$compra->impuesto}} {{$empresa->moneda->simbolo}}</div>
            <div><strong>Total:</strong> {{$compra->total}} {{$empresa->moneda->simbolo}}</div>
            <div><strong>Modalidad de Pago:</strong> {{$compra->metodo_pago->name}}</div>
            <div><strong>Realizado por:</strong> {{$compra->user->name}}</div>
        </div>

        <div class="footer">
            COMPROBANTE DE COMPRA REGISTRADO EN EL SISTEMA
        </div>
    </div>
</body>

</html>

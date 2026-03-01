@extends('layouts.app')

@section('title','Reportes de Inventario')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Reportes de Inventario</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('inventario.index')}}">Inventario</a></li>
        <li class="breadcrumb-item active">Reportes</li>
    </ol>

    <div class="mb-4 text-end">
        <a href="{{ route('inventario.reporte.pdf') }}" class="btn btn-danger" target="_blank">
            <i class="fas fa-file-pdf me-1"></i>Exportar PDF
        </a>
    </div>

    <div class="row g-4">
        <!----Niveles de Stock---->
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-layer-group me-1"></i>Niveles de Stock Actual
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Stock</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inventario as $item)
                            <tr>
                                <td>{{ $item->producto->nombre }}</td>
                                <td>{{ $item->cantidad }}</td>
                                <td>
                                    @if($item->cantidad <= $item->stock_minimo)
                                        <span class="badge bg-danger">Bajo Stock</span>
                                    @else
                                        <span class="badge bg-success">Normal</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!----Rotación de Productos---->
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <i class="fas fa-sync me-1"></i>Rotante de Productos (Ventas Totales)
                </div>
                <div class="card-body">
                    <table class="table table-striped">
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
                                        <span class="text-success fw-bold">Alta</span>
                                    @elseif($item->total_vendido > 10)
                                        <span class="text-warning fw-bold">Media</span>
                                    @else
                                        <span class="text-muted">Baja</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            @if($rotacion->isEmpty())
                            <tr>
                                <td colspan="3" class="text-center">No hay datos de ventas aún</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

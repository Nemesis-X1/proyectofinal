@extends('layouts.app')

@section('title','Inventario')

@push('css-datatable')
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
@endpush

@push('css')
@endpush

@section('content')

<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Inventario</h1>

    <x-breadcrumb.template>
        <x-breadcrumb.item :href="route('panel')" content="Inicio" />
        <x-breadcrumb.item active='true' content="Inventario" />
    </x-breadcrumb.template>

    <div class="mb-4">
        @can('ver-reporte-inventario')
        <a href="{{ route('inventario.reporte') }}" class="btn btn-secondary">
            <i class="fas fa-chart-line me-1"></i>Ver Reportes
        </a>
        @endcan
    </div>

    <div class="card">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Tabla inventario
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table-striped fs-6">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Stock</th>
                        <th>Ubicación</th>
                        <th>Fecha de Vencimiento</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($inventario as $item)
                    <tr>
                        <td>
                            {{$item->producto->nombre_completo}}
                        </td>
                        <td>
                            {{$item->cantidad}}
                        </td>
                        <td>
                            {{$item->ubicacione->nombre}}
                        </td>
                        <td>
                            {{$item->fecha_vencimiento_format ?? $item->fecha_vencimiento_format}}
                        </td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <!-----Editar Inventario--->
                                @can('editar-inventario')
                                <a href="{{route('inventario.edit',['inventario' => $item])}}" class="btn btn-warning btn-sm" title="Editar">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                @endcan

                                <!-----Ajustar Inventario--->
                                @can('ajustar-inventario')
                                <a href="{{route('inventario.ajuste.create',['inventario' => $item])}}" class="btn btn-info btn-sm text-white" title="Ajustar">
                                    <i class="fa-solid fa-sliders"></i>
                                </a>
                                @endcan
                            </div>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
<script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
@endpush

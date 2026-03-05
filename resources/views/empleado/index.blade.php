@extends('layouts.app')

@section('title','empleados')

@push('css-datatable')
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
@endpush

@push('css')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    .img {
        width: 80px;
    }
</style>
@endpush

@section('content')

<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Empleados</h1>

    <x-breadcrumb.template>
        <x-breadcrumb.item :href="route('panel')" content="Inicio" />
        <x-breadcrumb.item active='true' content="Empleados" />
    </x-breadcrumb.template>

    @can('crear-empleado')
    <div class="mb-4">
        <a href="{{route('empleados.create')}}">
            <button type="button" class="btn btn-primary">Añadir nuevo registro</button>
        </a>
    </div>
    @endcan

    <div class="card">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Tabla empleados
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table-striped fs-6">
                <thead>
                    <tr>
                        <th>Nombres y Apellidos</th>
                        <th>Cargo</th>
                        <th>Imagen</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($empleados as $item)
                    <tr>
                        <td>
                            {{$item->razon_social}}
                        </td>
                        <td>
                            {{$item->cargo}}
                        </td>
                        <td>
                            @if ($item->img_path)
                            <img class="img-thumbnail img rounded mx-auto d-block"
                                src="{{ asset($item->img_path)}}"
                                alt="{{$item->razon_social}}">
                            @else
                            <p class="text-muted text-center">No tiene una imagen</p>
                            @endif

                        </td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <!-----Editar -->
                                @can('editar-empleado')
                                <a href="{{route('empleados.edit',['empleado'=>$item])}}" class="btn btn-warning btn-sm" title="Editar">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                @endcan

                                <!------Eliminar ---->
                                @can('eliminar-empleado')
                                <button title="Eliminar" data-bs-toggle="modal" data-bs-target="#confirmModal-{{$item->id}}" class="btn btn-danger btn-sm">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                                @endcan
                            </div>
                        </td>
                    </tr>

                    <!-- Modal -->
                    <div class="modal fade" id="confirmModal-{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Mensaje de confirmación</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    ¿Seguro que quieres eliminar el empleado?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <form action="{{ route('empleados.destroy',['empleado'=>$item->id]) }}" method="post">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Confirmar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
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
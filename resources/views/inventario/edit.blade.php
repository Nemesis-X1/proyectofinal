@extends('layouts.app')

@section('title','Editar Inventario')

@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Editar Inventario</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('inventario.index')}}">Inventario</a></li>
        <li class="breadcrumb-item active">Editar inventario</li>
    </ol>

    <div class="card text-bg-light">
        <form action="{{route('inventario.update',['inventario'=>$inventario])}}" method="post">
            @method('PATCH')
            @csrf
            <div class="card-body">

                <div class="row g-4">

                    <!----Producto (Read Only)---->
                    <div class="col-md-6">
                        <label for="producto" class="form-label">Producto:</label>
                        <input type="text" disabled class="form-control" value="{{$inventario->producto->nombre}}">
                    </div>

                    <!----Cantidad---->
                    <div class="col-md-6">
                        <label for="cantidad" class="form-label">Stock:</label>
                        <input type="number" name="cantidad" id="cantidad" class="form-control" value="{{old('cantidad', $inventario->cantidad)}}">
                        @error('cantidad')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>

                    <!----Ubicacion---->
                    <div class="col-md-6">
                        <label for="ubicacione_id" class="form-label">Ubicación:</label>
                        <select data-size="4" title="Seleccione una ubicación" data-live-search="true" name="ubicacione_id" id="ubicacione_id" class="form-control selectpicker show-tick">
                            @foreach ($ubicaciones as $item)
                            <option value="{{$item->id}}" {{$inventario->ubicacione_id == $item->id || old('ubicacione_id') == $item->id ? 'selected' : '' }}>
                                {{$item->nombre}}
                            </option>
                            @endforeach
                        </select>
                        @error('ubicacione_id')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>

                    <!----Fecha Vencimiento---->
                    <div class="col-md-6">
                        <label for="fecha_vencimiento" class="form-label">Fecha de Vencimiento:</label>
                        <input type="date" name="fecha_vencimiento" id="fecha_vencimiento" class="form-control" value="{{old('fecha_vencimiento', $inventario->fecha_vencimiento ? $inventario->fecha_vencimiento->format('Y-m-d') : '')}}">
                        @error('fecha_vencimiento')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>

                    <!----Stock Mínimo---->
                    <div class="col-md-6">
                        <label for="stock_minimo" class="form-label">Stock Mínimo:</label>
                        <input type="number" name="stock_minimo" id="stock_minimo" class="form-control" value="{{old('stock_minimo', $inventario->stock_minimo)}}">
                        @error('stock_minimo')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>

                </div>

            </div>
            <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('inventario.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
@endpush

@extends('layouts.app')

@section('title','Ajuste de Inventario')

@push('css')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Ajuste de Inventario</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('inventario.index')}}">Inventario</a></li>
        <li class="breadcrumb-item active">Realizar ajuste</li>
    </ol>

    <div class="card text-bg-light">
        <form action="{{route('inventario.ajuste.store',['inventario' => $inventario])}}" method="post">
            @csrf
            <div class="card-body">
                <div class="row g-4">
                    <!----Producto (Info)---->
                    <div class="col-md-6 text-center">
                        <label class="form-label fw-bold">Producto:</label>
                        <p class="fs-5">{{$inventario->producto->nombre}}</p>
                    </div>

                    <!----Stock Actual (Info)---->
                    <div class="col-md-6 text-center">
                        <label class="form-label fw-bold">Stock Actual:</label>
                        <p class="fs-5 badge bg-primary">{{$inventario->cantidad}}</p>
                    </div>

                    <!----Tipo de Ajuste---->
                    <div class="col-md-6">
                        <label for="tipo_ajuste" class="form-label">Tipo de Ajuste:</label>
                        <select name="tipo_ajuste" id="tipo_ajuste" class="form-select" required>
                            <option value="" disabled selected>Seleccione un tipo</option>
                            <option value="positivo">Positivo (Aumento de stock)</option>
                            <option value="negativo">Negativo (Disminución de stock)</option>
                        </select>
                        @error('tipo_ajuste')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>

                    <!----Cantidad---->
                    <div class="col-md-6">
                        <label for="cantidad" class="form-label">Cantidad a ajustar:</label>
                        <input type="number" name="cantidad" id="cantidad" class="form-control" required min="1" value="{{old('cantidad')}}">
                        @error('cantidad')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>

                    <!----Motivo---->
                    <div class="col-12">
                        <label for="motivo" class="form-label">Motivo del ajuste:</label>
                        <textarea name="motivo" id="motivo" rows="3" class="form-control" required placeholder="Ej: Pérdida, Devolución de cliente, Error de conteo, etc.">{{old('motivo')}}</textarea>
                        @error('motivo')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary">Realizar Ajuste</button>
                <a href="{{ route('inventario.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection

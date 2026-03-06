@extends('layouts.app')

@section('title','compras')
@push('css-datatable')
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
@endpush
@push('css')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    .row-not-space {
        width: 110px;
    }
</style>
@endpush

@section('content')

<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Compras</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item active">Compras</li>
    </ol>

    @can('crear-compra')
    <div class="mb-4">
        <a href="{{route('compras.create')}}">
            <button type="button" class="btn btn-primary">Añadir nuevo registro</button>
        </a>
    </div>
    @endcan

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Tabla compras
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped">
                <thead>
                    <tr>
                        <th>Comprobante</th>
                        <th>Proveedor</th>
                        <th>Fecha y hora</th>
                        <th>Usuario</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($compras as $item)
                    <tr>
                        <td>
                            <p class="fw-semibold mb-1">{{$item->comprobante->nombre}}</p>
                            <p class="text-muted mb-0">{{$item->numero_comprobante}}</p>
                        </td>
                        <td>
                            <p class="fw-semibold mb-1">{{ ucfirst($item->proveedore->persona->tipo->value) }}</p>
                            <p class="text-muted mb-0">{{$item->proveedore->persona->razon_social}}</p>
                        </td>
                        <td>
                            <div class="row-not-space">
                                <p class="fw-semibold mb-1">
                                    <span class="m-1"><i class="fa-solid fa-calendar-days"></i>
                                    </span>{{$item->fecha}}
                                </p>
                                <p class="fw-semibold mb-0">
                                    <span class="m-1"><i class="fa-solid fa-clock"></i>
                                    </span>{{$item->hora}}
                                </p>
                            </div>
                        </td>
                        <td>
                            {{$item->user->name}}
                        </td>
                        <td>
                            {{$item->total}}
                        </td>
                        <td>
                            <div class="btn-group" role="group">

                                @can('mostrar-compra')
                                <form action="{{route('compras.show', ['compra'=>$item]) }}" method="get" class="d-inline">
                                    <button type="submit" class="btn btn-success btn-sm" title="Ver detalles">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </form>
                                @endcan

                                <a href="{{ route('export.pdf-comprobante-compra',['id' => Crypt::encrypt($item->id)]) }}" 
                                    target="_blank" class="btn btn-danger btn-sm" title="Exportar reporte PDF">
                                    <i class="fa-solid fa-file-pdf"></i>
                                </a>

                                {{-- Botón que carga el PDF adjunto dinámicamente en el modal global --}}
                                <button type="button"
                                    class="btn btn-secondary btn-sm btn-ver-pdf"
                                    data-path="{{ $item->comprobante_path ? asset($item->comprobante_path) : '' }}"
                                    title="Ver comprobante adjunto">
                                    <i class="fa-solid fa-paperclip"></i>
                                </button>

                            </div>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- Modal único y global para visualizar el PDF --}}
<div class="modal fade" id="modalPDFGlobal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5"><i class="fa-solid fa-file-pdf me-2" style="color:#924ab0;"></i>Comprobante PDF</h1>
                <div class="ms-auto d-flex gap-2 me-3">
                    <a id="btnAbrirPDF" href="#" target="_blank" class="btn btn-sm btn-primary" title="Abrir en nueva pestaña">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i> Abrir en pestaña
                    </a>
                    <a id="btnDescargarPDF" href="#" download class="btn btn-sm btn-secondary" title="Descargar PDF">
                        <i class="fa-solid fa-download"></i> Descargar
                    </a>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0" style="min-height:300px;">
                {{-- Primero intentamos con embed (mejor soporte que iframe para PDFs) --}}
                <embed id="embedPDF" src="" type="application/pdf" style="width:100%; height:650px;" class="w-100">
                <div id="noPDFMessage" class="text-center d-none p-5">
                    <i class="fa-solid fa-file-circle-xmark fa-3x mb-3 text-muted"></i>
                    <p class="text-muted mb-2">No se ha cargado un comprobante para esta compra.</p>
                </div>
                {{-- Fallback si el embed no funciona (ej. Firefox en modo estricto) --}}
                <div id="pdfFallback" class="text-center d-none p-4">
                    <i class="fa-solid fa-triangle-exclamation fa-2x mb-3 text-warning"></i>
                    <p class="mb-3">Tu navegador no puede mostrar el PDF aquí. Puedes abrirlo directamente:</p>
                    <a id="btnFallbackPDF" href="#" target="_blank" class="btn btn-primary">
                        <i class="fa-solid fa-external-link-alt me-1"></i> Ver PDF
                    </a>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
<script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modalElement = document.getElementById('modalPDFGlobal');
        const modal = new bootstrap.Modal(modalElement);
        const embedPDF = document.getElementById('embedPDF');
        const noPDFMessage = document.getElementById('noPDFMessage');
        const pdfFallback = document.getElementById('pdfFallback');
        const btnAbrir = document.getElementById('btnAbrirPDF');
        const btnDescargar = document.getElementById('btnDescargarPDF');
        const btnFallback = document.getElementById('btnFallbackPDF');

        document.querySelectorAll('.btn-ver-pdf').forEach(function(btn) {
            btn.addEventListener('click', function () {
                const path = this.getAttribute('data-path');

                // Ocultar todo primero
                embedPDF.classList.add('d-none');
                noPDFMessage.classList.add('d-none');
                pdfFallback.classList.add('d-none');

                if (path && path.trim() !== '') {
                    // Actualizar botones de cabecera
                    btnAbrir.href = path;
                    btnDescargar.href = path;
                    btnFallback.href = path;

                    // Intentar cargar el PDF con embed
                    embedPDF.src = path;
                    embedPDF.classList.remove('d-none');

                    // Si después de 3 segundos el embed no muestra nada, mostrar fallback
                    embedPDF.onerror = function() {
                        embedPDF.classList.add('d-none');
                        pdfFallback.classList.remove('d-none');
                    };
                } else {
                    btnAbrir.href = '#';
                    btnDescargar.href = '#';
                    noPDFMessage.classList.remove('d-none');
                }

                modal.show();
            });
        });

        // Limpiar al cerrar el modal para liberar memoria
        modalElement.addEventListener('hidden.bs.modal', function () {
            embedPDF.src = '';
            embedPDF.classList.remove('d-none');
            noPDFMessage.classList.add('d-none');
            pdfFallback.classList.add('d-none');
        });
    });
</script>
@endpush
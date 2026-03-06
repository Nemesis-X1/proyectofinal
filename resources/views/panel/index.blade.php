@extends('layouts.app')

@section('title','Panel')

@push('css')
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    /* Asegurar que el contenedor del gráfico tenga altura */
    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 mt-4">
        <div>
            <h2 class="fw-bold mb-0">Dashboard</h2>
            <p class="text-muted small">Resumen general del sistema</p>
        </div>
        <div class="d-flex align-items-center gap-2 mt-3 mt-md-0">
            <form action="{{ route('panel') }}" method="GET" id="filterForm" class="d-flex align-items-center gap-2">
                <select name="filter" class="form-select form-select-sm border-0 shadow-sm" style="border-radius: 10px; width: 140px;" onchange="this.value === 'custom' ? document.getElementById('customDates').classList.remove('d-none') : this.form.submit()">
                    <option value="day" {{ request('filter') == 'day' ? 'selected' : '' }}>Hoy</option>
                    <option value="week" {{ request('filter') == 'week' || !request('filter') ? 'selected' : '' }}>Esta Semana</option>
                    <option value="month" {{ request('filter') == 'month' ? 'selected' : '' }}>Este Mes</option>
                    <option value="custom" {{ request('filter') == 'custom' ? 'selected' : '' }}>Personalizado</option>
                </select>
                
                <div id="customDates" class="d-flex align-items-center gap-2 {{ request('filter') == 'custom' ? '' : 'd-none' }}">
                    <input type="date" name="fecha_inicio" class="form-control form-control-sm border-0 shadow-sm" style="border-radius: 10px;" value="{{ request('fecha_inicio') }}">
                    <input type="date" name="fecha_fin" class="form-control form-control-sm border-0 shadow-sm" style="border-radius: 10px;" value="{{ request('fecha_fin') }}">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="fas fa-filter"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <!----Clientes--->
        <div class="col-xl-3 col-md-6">
            <div class="dash-card">
                <div class="dash-card-icon bg-orange">
                    <i class="fa-solid fa-people-group" style="color: white !important;"></i>
                </div>
                <div class="dash-card-content">
                    <p class="dash-card-category">Clientes</p>
                    <h3 class="dash-card-title">
                        <?php
                        use App\Models\Cliente;
                        echo count(Cliente::all());
                        ?>
                    </h3>
                </div>
                <div class="dash-card-footer">
                    <i class="fas fa-sync-alt"></i> Actualizado ahora
                </div>
            </div>
        </div>

        <!----Compra--->
        <div class="col-xl-3 col-md-6">
            <div class="dash-card">
                <div class="dash-card-icon bg-green">
                    <i class="fa-solid fa-store" style="color: white !important;"></i>
                </div>
                <div class="dash-card-content">
                    <p class="dash-card-category">Compras</p>
                    <h3 class="dash-card-title">
                        <?php
                        use App\Models\Compra;
                        echo count(Compra::all());
                        ?>
                    </h3>
                </div>
                <div class="dash-card-footer">
                    <i class="far fa-calendar-alt"></i> Últimas 24 horas
                </div>
            </div>
        </div>

        <!----Producto--->
        <div class="col-xl-3 col-md-6">
            <div class="dash-card">
                <div class="dash-card-icon bg-blue">
                    <i class="fa-solid fa-boxes-stacked" style="color: white !important;"></i>
                </div>
                <div class="dash-card-content">
                    <p class="dash-card-category">Productos</p>
                    <h3 class="dash-card-title">
                        <?php
                        use App\Models\Producto;
                        echo count(Producto::all());
                        ?>
                    </h3>
                </div>
                <div class="dash-card-footer">
                    <i class="fas fa-history"></i> Justo ahora
                </div>
            </div>
        </div>

        <!----Users--->
        <div class="col-xl-3 col-md-6">
            <div class="dash-card">
                <div class="dash-card-icon bg-red">
                    <i class="fa-solid fa-user" style="color: white !important;"></i>
                </div>
                <div class="dash-card-content">
                    <p class="dash-card-category">Usuarios</p>
                    <h3 class="dash-card-title">
                        <?php
                        use App\Models\User;
                        echo count(User::all());
                        ?>
                    </h3>
                </div>
                <div class="dash-card-footer">
                    <i class="fas fa-user-shield"></i> Control activo
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Gráfico de Ventas -->
        <div class="col-lg-8">
            <div class="chart-card">
                <div class="chart-card-header">
                    <h5 class="chart-card-title">Rendimiento de Ventas</h5>
                    <p class="text-muted small mb-0">Ventas en los últimos 7 días</p>
                </div>
                <div class="chart-container">
                    <canvas id="ventasChart"></canvas>
                </div>
                <div class="chart-legend mt-3">
                    <div class="legend-item"><span class="legend-dot" style="background: #924ab0;"></span> Ventas Actuales</div>
                </div>
            </div>
        </div>


        <!-- Lista de Productos Más/Menos Vendidos -->
        <div class="col-lg-4">
            <div class="chart-card h-100">
                <!-- Botones tipo pill para alternar -->
                <div class="d-flex mb-3" style="background:#f1f3f4; border-radius:30px; padding:4px; gap:4px;">
                    <button id="btn-mas" onclick="toggleLista('mas')"
                        style="flex:1; border:none; border-radius:26px; padding:7px 0; font-size:11px; font-weight:800; text-transform:uppercase; letter-spacing:.8px; cursor:pointer; transition: all .3s; background:#3c4858; color:#fff; box-shadow:0 2px 5px rgba(0,0,0,.2);">
                        + Vendidos
                    </button>
                    <button id="btn-menos" onclick="toggleLista('menos')"
                        style="flex:1; border:none; border-radius:26px; padding:7px 0; font-size:11px; font-weight:800; text-transform:uppercase; letter-spacing:.8px; cursor:pointer; transition: all .3s; background:transparent; color:#666;">
                        - Vendidos
                    </button>
                </div>

                <div id="lista-mas">
                    @forelse($masVendidos as $i => $p)
                    <div class="d-flex align-items-center justify-content-between py-2" style="border-bottom: 1px solid var(--border-color);">
                        <div class="d-flex align-items-center gap-3">
                            <span style="width:26px;height:26px;border-radius:50%;background:{{ ['#642582','#8e44ad','#9b59b6','#ab47bc','#da70d6'][$i] }};display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:12px;">{{ $i+1 }}</span>
                            <span style="font-size:13px;color:var(--text-main);">{{ $p->nombre }}</span>
                        </div>
                        <div style="font-size:13px;font-weight:700;color:#924ab0;">{{ $moneda }} {{ number_format($p->total_bs, 2) }}</div>
                    </div>
                    @empty
                    <p class="text-muted small text-center mt-3">Sin datos en este período</p>
                    @endforelse
                </div>

                <!-- Lista: Menos Vendidos -->
                <div id="lista-menos" style="display:none;">
                    @forelse($menosVendidos as $i => $p)
                    <div class="d-flex align-items-center justify-content-between py-2" style="border-bottom: 1px solid var(--border-color);">
                        <div class="d-flex align-items-center gap-3">
                            <span style="width:26px;height:26px;border-radius:50%;background:{{ ['#ef5350','#ffa726','#26c6da','#66bb6a','#ab47bc'][$i] }};display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:12px;">{{ $i+1 }}</span>
                            <span style="font-size:13px;color:var(--text-main);">{{ $p->nombre }}</span>
                        </div>
                        <div style="font-size:13px;font-weight:700;color:#ef5350;">{{ $moneda }} {{ number_format($p->total_bs, 2) }}</div>
                    </div>
                    @empty
                    <p class="text-muted small text-center mt-3">Sin datos en este período</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('js')
<!-- Usar Chart.js v3 para mejor soporte de temas y opciones -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
<script src="{{ asset('js/datatables-simple-demo.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Colores dinámicos basados en el tema
        const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
        const textColor = isDark ? '#eee' : '#333';
        const gridColor = isDark ? 'rgba(255, 255, 255, 0.05)' : 'rgba(100, 37, 130, 0.05)';

        // Datos de Ventas
        let datosVenta = @json($totalVentasPorDia);
        const fechas = datosVenta.map(venta => {
            if (!venta.fecha) return 'Sin fecha';
            const partes = venta.fecha.split('-');
            return partes.length === 3 ? `${partes[2]}/${partes[1]}/${partes[0].substring(2)}` : venta.fecha;
        });
        const montos = datosVenta.map(venta => parseFloat(venta.total) || 0);

        // Si no hay datos, mostrar algo simbólico para que el gráfico no esté vacío
        const finalMontos = montos.length > 0 ? montos : [0, 0, 0, 0, 0, 0, 0];
        const finalFechas = fechas.length > 0 ? fechas : ['Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab', 'Dom'];

        const ctxVentas = document.getElementById('ventasChart').getContext('2d');
        new Chart(ctxVentas, {
            type: 'bar',
            data: {
                labels: finalFechas,
                datasets: [{
                    label: "Ventas",
                    data: finalMontos,
                    backgroundColor: "#924ab0",
                    borderRadius: 8,
                    borderWidth: 0
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: textColor }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: gridColor },
                        ticks: { color: textColor }
                    }
                }
            }
        });
    });

    function toggleLista(tipo) {
        const btnMas   = document.getElementById('btn-mas');
        const btnMenos = document.getElementById('btn-menos');
        const listaMas   = document.getElementById('lista-mas');
        const listaMenos = document.getElementById('lista-menos');

        if (tipo === 'mas') {
            listaMas.style.display = 'block';
            listaMenos.style.display = 'none';
            btnMas.style.background = 'linear-gradient(90deg, #642582, #8e44ad)';
            btnMas.style.color = '#fff';
            btnMas.style.boxShadow = '0 4px 10px rgba(100, 37, 130, 0.3)';
            btnMenos.style.background = 'transparent';
            btnMenos.style.color = '#8e87a2';
            btnMenos.style.boxShadow = 'none';
        } else {
            listaMenos.style.display = 'block';
            listaMas.style.display = 'none';
            btnMenos.style.background = 'linear-gradient(90deg, #642582, #8e44ad)';
            btnMenos.style.color = '#fff';
            btnMenos.style.boxShadow = '0 4px 10px rgba(100, 37, 130, 0.3)';
            btnMas.style.background = 'transparent';
            btnMas.style.color = '#8e87a2';
            btnMas.style.boxShadow = 'none';
        }
    }
</script>
@endpush
@extends('layouts.app')

@section('title','Panel')

@push('css')
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4 mt-4">
        <div>
            <h2 class="fw-bold text-dark mb-0">Dashboard</h2>
            <p class="text-muted small">Resumen general del sistema</p>
        </div>
    </div>

    <div class="row">
        <!----Clientes--->
        <div class="col-xl-3 col-md-6">
            <div class="dash-card">
                <div class="dash-card-icon bg-orange">
                    <i class="fa-solid fa-people-group"></i>
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
                    <i class="fas fa-tag"></i> <a href="{{ route('clientes.index') }}" class="text-decoration-none text-muted">Gestionar clientes</a>
                </div>
            </div>
        </div>

        <!----Compra--->
        <div class="col-xl-3 col-md-6">
            <div class="dash-card">
                <div class="dash-card-icon bg-green">
                    <i class="fa-solid fa-store"></i>
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
                    <i class="fas fa-calendar"></i> <a href="{{ route('compras.index') }}" class="text-decoration-none text-muted">Ver historial</a>
                </div>
            </div>
        </div>

        <!----Producto--->
        <div class="col-xl-3 col-md-6">
            <div class="dash-card">
                <div class="dash-card-icon bg-blue">
                    <i class="fa-brands fa-shopify"></i>
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
                    <i class="fas fa-box"></i> <a href="{{ route('productos.index') }}" class="text-decoration-none text-muted">Inventario total</a>
                </div>
            </div>
        </div>

        <!----Users--->
        <div class="col-xl-3 col-md-6">
            <div class="dash-card">
                <div class="dash-card-icon bg-red">
                    <i class="fa-solid fa-user"></i>
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
                    <i class="fas fa-clock"></i> <a href="{{ route('users.index') }}" class="text-decoration-none text-muted">Control de acceso</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Gráfico de Ventas -->
        <div class="col-lg-8">
            <div class="chart-card">
                <div class="chart-card-header">
                    <h5 class="chart-card-title text-success"><i class="fas fa-chart-line me-2"></i> Rendimiento de Ventas</h5>
                    <p class="text-muted small mb-0">Ventas en los últimos 7 días</p>
                </div>
                <div class="chart-body">
                    <canvas id="ventasChart" width="100%" height="45"></canvas>
                </div>
                <div class="dash-card-footer">
                    <i class="fas fa-history"></i> Actualizado recientemente
                </div>
            </div>
        </div>

        <!-- Gráfico de Stock -->
        <div class="col-lg-4">
            <div class="chart-card">
                <div class="chart-card-header">
                    <h5 class="chart-card-title text-warning"><i class="fas fa-exclamation-triangle me-2"></i> Alerta de Stock</h5>
                    <p class="text-muted small mb-0">Productos con stock bajo</p>
                </div>
                <div class="chart-body">
                    <canvas id="productosChart" width="100%" height="100"></canvas>
                </div>
                <div class="dash-card-footer">
                    <i class="fas fa-sync"></i> Revisión automática
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
<script src="{{ asset('js/datatables-simple-demo.js') }}"></script>

<script>
    let datosVenta = @json($totalVentasPorDia);

    const fechas = datosVenta.map(venta => {
        if (!venta.fecha) return 'Sin fecha';
        const partes = venta.fecha.split('-');
        if (partes.length < 3) return venta.fecha;
        const [year, month, day] = partes;
        return `${day}/${month}/${year}`;
    });
    const montos = datosVenta.map(venta => parseFloat(venta.total) || 0);

    const ventasChart = document.getElementById('ventasChart');

    new Chart(ventasChart, {
        type: 'line',
        data: {
            labels: fechas,
            datasets: [{
                label: "Ventas",
                lineTension: 0.3,
                backgroundColor: "rgba(102, 187, 106, 0.2)",
                borderColor: "rgba(102, 187, 106, 1)",
                pointRadius: 5,
                pointBackgroundColor: "rgba(102, 187, 106, 1)",
                pointBorderColor: "rgba(255,255,255,0.8)",
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(102, 187, 106, 1)",
                pointHitRadius: 50,
                pointBorderWidth: 2,
                data: montos,
            }],
        },
        options: {
            scales: {
                xAxes: [{
                    time: {
                        unit: 'date'
                    },
                    gridLines: {
                        display: false
                    },
                    ticks: {
                        //maxTicksLimit: 7
                    }
                }],
                yAxes: [{
                    ticks: {
                        min: 0,
                        //max: 40000,
                        // maxTicksLimit: 5
                    },
                    gridLines: {
                        color: "rgba(0, 0, 0, .05)",
                    }
                }],
            },
            legend: {
                display: false
            }
        }
    });


    let datosProductos = @json($productosStockBajo);

    const nombres = datosProductos.map(obj => obj.nombre);
    const stock = datosProductos.map(i => i.cantidad);

    const productosChart = document.getElementById('productosChart');

    new Chart(productosChart, {
        type: 'horizontalBar',
        data: {
            labels: nombres,
            datasets: [{
                label: 'stock',
                backgroundColor: "rgba(255, 167, 38, 0.8)",
                borderColor: "rgba(255, 167, 38, 1)",
                data: stock,
                borderWidth: 2,
                hoverBorderColor: '#aaa',
                base: 0
            }]
        },
        options: {
            legend: {
                display: false
            },
            scales: {
                xAxes: [{
                    ticks: {
                        beginAtZero: true
                    },
                    gridLines: {
                        display: false
                    }
                }]
            }
        }
    });
</script>
@endpush
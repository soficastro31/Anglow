<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes Estadísticos - Anglow</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: sans-serif; padding: 0; margin: 0; background: #f4f4f9; }
        nav { background: #fff; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        nav a { color: #4f8cff; text-decoration: none; font-weight: bold; }
        .container { max-width: 1000px; margin: 40px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
        h1 { color: #333; margin-top: 0; }
        p.subtitle { color: #6b7280; margin-top: -10px; margin-bottom: 25px; }
        .grid-reportes { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-top: 25px; }
        .card-reporte { background: #f9fafb; border: 1px solid #e5e7eb; padding: 25px; border-radius: 8px; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.02); transition: 0.3s; }
        .card-reporte:hover { border-color: #4f8cff; }
        .card-reporte i { font-size: 30px; color: #4f8cff; margin-bottom: 12px; }
        .card-reporte h3 { margin: 5px 0; color: #333; font-size: 16px; }
        .monto { font-size: 22px; font-weight: bold; color: #111827; margin: 10px 0; }
        .btn-imprimir-box { background: #eef2ff !important; border: 1px solid #c7d2fe !important; text-decoration: none; display: block; }
        .seccion-alerta { margin-top: 40px; background: #fff8f8; border: 1px solid #fee2e2; padding: 20px; border-radius: 8px; }
        .seccion-alerta h2 { color: #9b1c1c; font-size: 18px; margin-top: 0; }
        .item-critico { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #fecaca; }
        .item-critico:last-child { border-bottom: none; }
    </style>
</head>
<body>

<nav>
    <div><a href="{{ url('/admin') }}"><i class="fa-solid fa-arrow-left"></i> Volver al Panel Admin</a></div>
    <div><span><i class="fa-solid fa-user"></i> {{ Auth::user()?->name ?? 'Admin' }}</span></div>
</nav>

<div class="container">
    <h1>Reportes y Estadísticas</h1>
    <p class="subtitle">Analiza el rendimiento general y genera documentos de impresión.</p>

    <div class="grid-reportes">
        <div class="card-reporte">
            <i class="fa-solid fa-chart-line" style="color: #10b981;"></i>
            <h3>Ingresos por Ventas</h3>
            <div class="monto">${{ number_format($totalVentas, 2) }}</div>
        </div>
        <div class="card-reporte">
            <i class="fa-solid fa-truck-ramp-box" style="color: #3b82f6;"></i>
            <h3>Costos de Proveedores</h3>
            <div class="monto">${{ number_format($totalInversion, 2) }}</div>
        </div>
        <div class="card-reporte">
            <i class="fa-solid fa-box" style="color: #f59e0b;"></i>
            <h3>Artículos en Catálogo</h3>
            <div class="monto">{{ $totalProductos }}</div>
        </div>
    </div>

    <div class="grid-reportes" style="margin-top: 30px;">
        <a href="{{ route('reportes.index', ['tipo' => 'ventas']) }}" class="card-reporte btn-imprimir-box">
            <i class="fa-solid fa-print"></i> <h3>Imprimir Ventas</h3>
        </a>
        <a href="{{ route('reportes.index', ['tipo' => 'facturacion']) }}" class="card-reporte btn-imprimir-box">
            <i class="fa-solid fa-file-invoice"></i> <h3>Imprimir Facturas</h3>
        </a>
        <a href="{{ route('reportes.index', ['tipo' => 'inventario']) }}" class="card-reporte btn-imprimir-box">
            <i class="fa-solid fa-boxes-stacked"></i> <h3>Imprimir Inventario</h3>
        </a>
        <a href="{{ route('reportes.index', ['tipo' => 'compras']) }}" class="card-reporte btn-imprimir-box">
            <i class="fa-solid fa-cart-shopping"></i> <h3>Imprimir Compras</h3>
        </a>
    </div>

    <div class="seccion-alerta">
        <h2><i class="fa-solid fa-triangle-exclamation"></i> Alerta de Inventario Crítico</h2>
        @forelse($productosCriticos as $prod)
            <div class="item-critico">
                <span><strong>{{ $prod->nombre }}</strong></span>
                <span style="color: #b91c1c; font-weight: bold;">{{ $prod->stock }} unidades</span>
            </div>
        @empty
            <p style="color: #10b981;">Todo el inventario está en niveles óptimos.</p>
        @endforelse
    </div>
</div>

</body>
</html>
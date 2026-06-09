<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Facturación - Anglow</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: sans-serif; padding: 0; margin: 0; background: #f4f4f9; }
        nav { background: #fff; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        nav a { color: #4f8cff; text-decoration: none; font-weight: bold; }
        .container { max-width: 1000px; margin: 40px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
        h1 { color: #333; margin-top: 0; }
        p.subtitle { color: #6b7280; margin-top: -10px; margin-bottom: 25px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: #fff; }
        th, td { padding: 12px 15px; border: 1px solid #e5e7eb; text-align: left; }
        th { background: #f8f9fa; color: #4b5563; font-weight: 600; }
        tr:hover { background-color: #f9fafb; }
        .btn-ver { background: #4f8cff; color: white; padding: 6px 12px; text-decoration: none; border-radius: 4px; font-size: 13px; font-weight: bold; display: inline-block; }
        .btn-ver:hover { background: #3b71db; }
        .badge { padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: bold; display: inline-block; }
        .badge-pagada { background: #d1e7dd; color: #0f5132; }
        .badge-emitida { background: #fef3c7; color: #92400e; }
    </style>
</head>
<body>

<nav>
    <div>
        <a href="{{ url('/admin') }}">
            <i class="fa-solid fa-arrow-left"></i> Volver al Panel Admin
        </a>
    </div>
    <div>
        <span><i class="fa-solid fa-user"></i> {{ Auth::user()->name }}</span>
    </div>
</nav>

<div class="container">
    <h1>Control de Facturación</h1>
    <p class="subtitle">Historial de comprobantes fiscales y recibos de pago emitidos por Anglow.</p>

    <table>
        <thead>
            <tr>
                <th>Nº Factura</th>
                <th>Cliente</th>
                <th>Método de Pago</th>
                <th>Total ($)</th>
                <th>Fecha Emisión</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($facturas as $factura)
            <tr>
                <td><strong>{{ $factura->numero_factura }}</strong></td>
                <td>{{ $factura->cliente_nombre }}</td>
                <td><i class="fa-solid fa-credit-card"></i> {{ $factura->metodo_pago }}</td>
                <td><strong>${{ number_format($factura->total, 2) }}</strong></td>
                <td>{{ $factura->created_at->format('d/m/Y h:i A') }}</td>
                <td>
                    @if(strtolower($factura->estado) == 'pagada')
                        <span class="badge badge-pagada">Pagada</span>
                    @else
                        <span class="badge badge-emitida">{{ ucfirst($factura->estado) }}</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('facturacion.show', $factura->id) }}" class="btn-ver">
                        <i class="fa-solid fa-eye"></i> Ver Detalle
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; color: #6b7280; padding: 30px;">
                    <i class="fa-solid fa-file-invoice-dollar" style="font-size: 32px; display:block; margin-bottom: 10px;"></i>
                    No se han generado facturas en el sistema todavía.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

</body>
</html>
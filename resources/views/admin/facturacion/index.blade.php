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
        
        /* ================= ESTILOS NUEVOS PARA LA BARRA DE FILTROS ================= */
        .filtros-wrapper { background: #f8f9fa; padding: 20px; border-radius: 6px; border: 1px solid #e5e7eb; margin-bottom: 25px; }
        .filtros-form { display: flex; flex-wrap: wrap; gap: 15px; align-items: flex-end; }
        .grupo-filtro { display: flex; flex-direction: column; gap: 6px; }
        .grupo-filtro label { font-weight: bold; font-size: 13px; color: #4b5563; }
        .grupo-filtro input, .grupo-filtro select { padding: 10px; border: 1px solid #cbd5e0; border-radius: 6px; font-size: 14px; background: white; box-sizing: border-box; height: 40px; }
        .btn-filtrar { background: #2ec4b6; color: white; border: none; padding: 0 20px; border-radius: 6px; font-weight: bold; height: 40px; cursor: pointer; font-size: 14px; }
        .btn-filtrar:hover { background: #24b0a3; }
        .btn-limpiar { background: #e5e7eb; color: #374151; padding: 0 15px; border-radius: 6px; text-decoration: none; font-weight: bold; font-size: 14px; display: inline-flex; align-items: center; height: 40px; border: 1px solid #d1d5db; box-sizing: border-box; }
        .btn-limpiar:hover { background: #d1d5db; }
        /* ========================================================================== */

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

    <div class="filtros-wrapper">
        <form action="{{ url('/admin/facturas') }}" method="GET" class="filtros-form">
            
            <div class="grupo-filtro" style="flex: 2; min-width: 250px;">
                <label>Buscar Consecutivo o Cliente:</label>
                <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Ej: ANG-000001 o nombre del cliente...">
            </div>

            <div class="grupo-filtro" style="flex: 1; min-width: 180px;">
                <label>Estado de Factura:</label>
                <select name="estado">
                    <option value="">-- Todos --</option>
                    <option value="pagada" {{ request('estado') == 'pagada' ? 'selected' : '' }}>Pagada</option>
                    <option value="emitida" {{ request('estado') == 'emitida' ? 'selected' : '' }}>Emitida</option>
                </select>
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn-filtrar">Buscar</button>
                @if(request('buscar') || request('estado'))
                    <a href="{{ url('/admin/facturas') }}" class="btn-limpiar">Limpiar</a>
                @endif
            </div>
        </form>
    </div>
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
                    No se encontraron facturas con los criterios seleccionados.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

</body>
</html>
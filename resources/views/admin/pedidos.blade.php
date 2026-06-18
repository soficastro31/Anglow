<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de Pedidos - Anglow Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* ✅ Unificación global de fuentes para Anglow */
        body, input, select, button, table {
            font-family: 'Poppins', sans-serif !important;
        }

        .badge { padding: 5px 10px; border-radius: 4px; font-weight: bold; font-size: 12px; display: inline-block; }
        .badge-aprobado { background: #d1fae5; color: #065f46; }
        .badge-pendiente { background: #fef3c7; color: #92400e; }
        .badge-rechazado { background: #fee2e2; color: #991b1b; }
        
        .tabla-pedidos { width: 100%; border-collapse: collapse; margin-top: 15px; background: white; border-radius: 8px; overflow: hidden; border: 1px solid #e5e7eb; }
        .tabla-pedidos th, .tabla-pedidos td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #e5e7eb; }
        .tabla-pedidos th { background: #f9fafb; color: #4b5563; font-weight: bold; }
        .tabla-pedidos tr:hover { background: #f3f4f6; }
    </style>
</head>
<body style="background: #f9fafb; margin: 0; padding: 0;">

<div style="max-width: 1300px; margin: 40px auto; padding: 0 20px;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <div>
            <h1 style="color: #1f2937; margin: 0; font-weight: 600;"> Auditoría de Pedidos</h1>
            <p style="color: #6b7280; margin: 5px 0 0 0; font-weight: 400;">Monitorea los flujos de entrega, direcciones de envío y estados de pago.</p>
        </div>
        <a href="/admin" style="text-decoration: none; background: #4f8cff; color: white; padding: 10px 15px; border-radius: 6px; font-weight: bold; font-size: 14px;">
            <i class="fa-solid fa-arrow-left"></i> Volver al Panel
        </a>
    </div>

    <form action="{{ url('/admin/pedidos') }}" method="GET" style="background: white; padding: 20px; border-radius: 8px; border: 1px solid #e5e7eb; display: flex; flex-wrap: wrap; gap: 15px; align-items: flex-end; margin-bottom: 25px;">
        
        <div style="flex: 2; min-width: 250px; display: flex; flex-direction: column; gap: 6px;">
            <label style="font-weight: 600; font-size: 13px; color: #4b5563;">Buscar Cliente / Destino:</label>
            <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Nombre, teléfono o ciudad..." style="padding: 10px; border: 1px solid #cbd5e0; border-radius: 6px; font-size: 14px;">
        </div>

        <div style="flex: 1; min-width: 180px; display: flex; flex-direction: column; gap: 6px;">
            <label style="font-weight: 600; font-size: 13px; color: #4b5563;">Estado de Pasarela:</label>
            <select name="estado_pago" style="padding: 10px; border: 1px solid #cbd5e0; border-radius: 6px; font-size: 14px; background: white; height: 40px;">
                <option value="">-- Todos los estados --</option>
                <option value="aprobado" {{ request('estado_pago') == 'aprobado' ? 'selected' : '' }}>🟢 Aprobado</option>
                <option value="pendiente" {{ request('estado_pago') == 'pendiente' ? 'selected' : '' }}>🟡 Pendiente</option>
                <option value="rechazado" {{ request('estado_pago') == 'rechazado' ? 'selected' : '' }}>🔴 Rechazado</option>
            </select>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" style="background: #2ec4b6; color: white; border: none; padding: 0 20px; border-radius: 6px; font-weight: bold; height: 40px; cursor: pointer;">Filtrar</button>
            @if(request('buscar') || request('estado_pago'))
                <a href="{{ url('/admin/pedidos') }}" style="background: #e5e7eb; color: #374151; padding: 0 15px; border-radius: 6px; text-decoration: none; font-weight: bold; font-size: 14px; display: inline-flex; align-items: center; height: 40px; border: 1px solid #d1d5db;">Limpiar</a>
            @endif
        </div>
    </form>

    @if($pedidos->isEmpty())
        <div style="background: white; padding: 40px; border-radius: 8px; text-align: center; border: 1px solid #e5e7eb;">
            <p style="color: #6b7280; font-size: 16px; margin: 0;">No se encontraron pedidos con los criterios seleccionados.</p>
        </div>
    @else
        <table class="tabla-pedidos">
            <thead>
                <tr>
                    <th style="font-weight: 600;">ID Orden</th>
                    <th style="font-weight: 600;">Comprador</th>
                    <th style="font-weight: 600;">Contacto</th>
                    <th style="font-weight: 600;">Destino Logístico</th>
                    <th style="font-weight: 600;">Total Solicitado</th>
                    <th style="font-weight: 600;">Estado Pago</th>
                    <th style="font-weight: 600;">Fecha de Registro</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pedidos as $pedido)
                <tr>
                    <td><strong>#{{ $pedido->id }}</strong></td>
                    <td>{{ $pedido->user->name ?? 'Cliente Desconocido' }}</td>
                    <td>📞 {{ $pedido->telefono }}</td>
                    <td>
                        <span style="font-size: 13px; color: #374151;">
                            📍 {{ $pedido->ciudad_departamento }} - {{ $pedido->barrio_sector }}<br>
                            <small style="color: #6b7280;">{{ $pedido->direccion }}</small>
                        </span>
                    </td>
                    <td><strong>${{ number_format($pedido->total, 2) }}</strong></td>
                    <td>
                        <span class="badge badge-{{ $pedido->estado_pago }}">
                            {{ strtoupper($pedido->estado_pago) }}
                        </span>
                    </td>
                    <td style="font-size: 13px;">{{ $pedido->created_at->format('d/m/Y h:i A') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

</body>
</html>
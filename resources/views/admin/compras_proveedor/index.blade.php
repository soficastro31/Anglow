<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Compras - Anglow</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: sans-serif; padding: 0; margin: 0; background: #f4f4f9; }
        nav { background: #fff; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        nav a { color: #4f8cff; text-decoration: none; font-weight: bold; }
        .container { max-width: 1000px; margin: 40px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
        h1, h2 { color: #333; margin-top: 0; }
        p.subtitle { color: #6b7280; margin-top: -10px; margin-bottom: 25px; }
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 4px; font-weight: bold; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: #fff; }
        th, td { padding: 12px 15px; border: 1px solid #e5e7eb; text-align: left; }
        th { background: #f8f9fa; color: #4b5563; font-weight: 600; }
        tr:hover { background-color: #f9fafb; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; color: #4b5563; font-weight: 500; }
        input, select { padding: 10px; width: 100%; box-sizing: border-box; border: 1px solid #d1d5db; border-radius: 4px; font-size: 14px; }
        input:focus, select:focus { outline: none; border-color: #2a9d8f; box-shadow: 0 0 0 3px rgba(42, 157, 143, 0.1); }
        button { padding: 11px 20px; background: #2a9d8f; color: white; border: none; cursor: pointer; border-radius: 4px; font-weight: bold; font-size: 14px; transition: background 0.2s; }
        button:hover { background: #21867a; }
        
        /* Estilos específicos para el botón de confirmar acción */
        .btn-recibido { background: #2196F3; padding: 6px 12px; font-size: 12px; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; transition: background 0.2s; }
        .btn-recibido:hover { background: #1976D2; }
        
        .badge { padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: bold; display: inline-block; }
        .badge-pendiente { background: #fef3c7; color: #92400e; }
        .badge-completado { background: #d1e7dd; color: #0f5132; }
    </style>
</head>
<body>

{{-- BARRA DE NAVEGACIÓN SUPERIOR --}}
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
    <div>
        <h1>Módulo de Compras a Proveedores</h1>
        <p class="subtitle">Gestiona y registra el abastecimiento de productos para el inventario de Anglow.</p>
    </div>

    {{-- Mensajes de Éxito de Sesión --}}
    @if(session('success'))
        <div class="alert success">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Errores de Validación del Formulario --}}
    @if($errors->any())
        <div class="alert error">
            <h4 style="margin: 0 0 10px 0;"><i class="fa-solid fa-triangle-exclamation"></i> Por favor corrige los siguientes errores:</h4>
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORMULARIO DE REGISTRO --}}
    <form action="{{ route('compras-proveedor.store') }}" method="POST">
        @csrf
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px; margin-bottom: 15px;">
            <div class="form-group">
                <label>Proveedor</label>
                <input type="text" name="proveedor" placeholder="Nombre del proveedor" value="{{ old('proveedor') }}" required>
            </div>
            <div class="form-group">
                <label>Producto</label>
                <input type="text" name="producto" placeholder="¿Qué artículo compraste?" value="{{ old('producto') }}" required>
            </div>
            <div class="form-group">
                <label>Cantidad</label>
                <input type="number" name="cantidad" min="1" placeholder="0" value="{{ old('cantidad') }}" required>
            </div>
            <div class="form-group">
                <label>Costo Total ($)</label>
                <input type="number" step="0.01" min="0" name="costo_total" placeholder="0.00" value="{{ old('costo_total') }}" required>
            </div>
            <div class="form-group">
                <label>Fecha Entrega</label>
                <input type="date" name="fecha_entrega" value="{{ old('fecha_entrega') }}" required>
            </div>
        </div>
        <button type="submit"><i class="fa-solid fa-plus"></i> Registrar Compra</button>
    </form>
<br>
<div style="background: white; padding: 15px; border-radius: 6px; border: 1px solid #e5e7eb; margin-bottom: 20px;">
    <form action="{{ url('/admin/compras') }}" method="GET" style="display: flex; flex-wrap: wrap; gap: 15px; align-items: flex-end;">
        <div style="flex: 2; min-width: 200px; display: flex; flex-direction: column; gap: 5px;">
            <label style="font-weight: bold; font-size: 13px; color: #4b5563;">Proveedor / Factura:</label>
            <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Nombre proveedor o Nº recibo..." style="padding: 8px; border: 1px solid #cbd5e0; border-radius: 6px; height: 38px;">
        </div>
        <div style="flex: 1; min-width: 150px; display: flex; flex-direction: column; gap: 5px;">
            <label style="font-weight: bold; font-size: 13px; color: #4b5563;">Estado:</label>
            <select name="estado" style="padding: 8px; border: 1px solid #cbd5e0; border-radius: 6px; height: 38px; background: white;">
                <option value="">-- Todos --</option>
                <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="confirmada" {{ request('estado') == 'confirmada' ? 'selected' : '' }}>Confirmada</option>
            </select>
        </div>
        <div style="display: flex; gap: 10px;">
            <button type="submit" style="background: #2ec4b6; color: white; border: none; padding: 0 15px; border-radius: 6px; font-weight: bold; height: 38px; cursor: pointer;">Filtrar</button>
            @if(request('buscar') || request('estado'))
                <a href="{{ url('/admin/compras_proveedor') }}" style="background: #e5e7eb; color: #374151; padding: 0 15px; border-radius: 6px; text-decoration: none; font-weight: bold; font-size: 14px; display: inline-flex; align-items: center; height: 38px; border: 1px solid #d1d5db;">Limpiar</a>
            @endif
        </div>
    </form>
</div>
    <hr style="margin: 40px 0; border: 0; border-top: 1px solid #e5e7eb;">

    {{-- HISTORIAL DE COMPRAS --}}
    <h2><i class="fa-solid fa-history"></i> Historial de Compras</h2>
    <table>
        <thead>
            <tr>
                <th>Proveedor</th>
                <th>Producto</th>
                <th>Cant.</th>
                <th>Costo Total</th>
                <th>Fecha Entrega</th>
                <th>Estado</th>
                <th>Acciones</th> {{-- Nueva columna añadida --}}
            </tr>
        </thead>
        <tbody>
            @forelse($compras as $compra)
            <tr>
                <td><strong>{{ $compra->proveedor }}</strong></td>
                <td>{{ $compra->producto }}</td>
                <td>{{ $compra->cantidad }}</td>
                <td>${{ number_format($compra->costo_total, 2) }}</td>
                <td>{{ $compra->fecha_entrega ? $compra->fecha_entrega->format('d/m/Y') : 'No asignada' }}</td>
                <td>
                    @if(strtolower($compra->estado) == 'recibido' || strtolower($compra->estado) == 'completado')
                        <span class="badge badge-completado">{{ ucfirst($compra->estado ?? 'Recibido') }}</span>
                    @else
                        <span class="badge badge-pendiente">{{ ucfirst($compra->estado ?? 'Pendiente') }}</span>
                    @endif
                </td>
                <td>
                    {{-- Si el estado NO es recibido ni completado, dejamos confirmar --}}
                    @if(strtolower($compra->estado) != 'recibido' && strtolower($compra->estado) != 'completado')
                        <form action="{{ route('compras-proveedor.confirmar', $compra->id) }}" method="POST" style="margin:0;">
                            @csrf
                            <button type="submit" class="btn-recibido">
                                <i class="fa-solid fa-check"></i> Recibido
                            </button>
                        </form>
                    @else
                        <span style="color: #6b7280; font-size: 13px;"><i class="fa-solid fa-circle-check"></i> Listo</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; color: #6b7280; padding: 20px;">
                    <i class="fa-solid fa-box-open" style="font-size: 24px; display:block; margin-bottom: 10px;"></i>
                    No hay compras registradas a proveedores todavía.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

</body>
</html>
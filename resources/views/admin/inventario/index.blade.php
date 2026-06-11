<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario - Anglow</title>
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
        .badge { padding: 4px 10px; border-radius: 12px; font-size: 12px; font-weight: bold; display: inline-block; }
        
        /* NUEVO: Estilo para el botón de editar */
        .btn-edit {
            background-color: #4f8cff;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
            font-weight: bold;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            text-decoration: none;
            transition: background 0.2s ease;
        }
        .btn-edit:hover {
            background-color: #3b74df;
        }
    </style>
</head>
<body>

<nav>
    <div><a href="{{ url('/admin') }}"><i class="fa-solid fa-arrow-left"></i> Volver al Panel Admin</a></div>
    <div><span><i class="fa-solid fa-user"></i> {{ Auth::user()->name }}</span></div>
</nav>

<div class="container">
    <h1>Control de Inventario</h1>
    <p class="subtitle">Verifica y gestiona las existencias en almacén de tus productos.</p>
<div style="background: white; padding: 15px; border-radius: 6px; border: 1px solid #e5e7eb; margin-bottom: 20px;">
    <form action="{{ url('/admin/inventario') }}" method="GET" style="display: flex; gap: 15px; align-items: flex-end;">
        <div style="flex: 1; display: flex; flex-direction: column; gap: 5px;">
            <label style="font-weight: bold; font-size: 13px; color: #4b5563;">Filtrar Inventario:</label>
            <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar por producto o referencia SKU..." style="padding: 8px; border: 1px solid #cbd5e0; border-radius: 6px; height: 38px;">
        </div>
        <div style="display: flex; gap: 10px;">
            <button type="submit" style="background: #2ec4b6; color: white; border: none; padding: 0 15px; border-radius: 6px; font-weight: bold; height: 38px; cursor: pointer;">Buscar</button>
            @if(request('buscar'))
                <a href="{{ url('/admin/inventario') }}" style="background: #e5e7eb; color: #374151; padding: 0 15px; border-radius: 6px; text-decoration: none; font-weight: bold; font-size: 14px; display: inline-flex; align-items: center; height: 38px; border: 1px solid #d1d5db;">Limpiar</a>
            @endif
        </div>
    </form>
</div>
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Categoría</th>
                <th>Precio Venta</th>
                <th>Stock Actual</th>
                <th>Estado</th>
                <th>Acciones</th> </tr>
        </thead>
        <tbody>
            @forelse($productos as $producto)
            <tr>
                <td><strong>{{ $producto->nombre }}</strong></td>
                <td>{{ $producto->categoria->nombre ?? 'Sin categoría' }}</td>
                <td>${{ number_format($producto->precio, 2) }}</td>
                <td><strong>{{ $producto->stock }}</strong> u.</td>
                <td>
                    @if($producto->stock == 0)
                        <span class="badge" style="background: #fde8e8; color: #9b1c1c;">
                            <i class="fa-solid fa-circle-xmark"></i> Agotado
                        </span>
                    @elseif($producto->stock <= 10)
                        <span class="badge" style="background: #fef3c7; color: #92400e;">
                            <i class="fa-solid fa-triangle-exclamation"></i> Stock Bajo
                        </span>
                    @else
                        <span class="badge" style="background: #def7ec; color: #03543f;">
                            <i class="fa-solid fa-circle-check"></i> Disponible
                        </span>
                    @endif
                </td>
                <td>
                    <a href="{{ url('/productos/edit/' . $producto->id) }}" class="btn-edit">
                        <i class="fa-solid fa-pen-to-square"></i> Editar
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; color: #6b7280; padding: 25px;">
                    <i class="fa-solid fa-boxes-stacked" style="font-size: 24px; display:block; margin-bottom: 10px;"></i>
                    No hay productos creados en la base de datos para evaluar el inventario.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

</body>
</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de {{ ucfirst($tipo) }} - Anglow</title>
    <style>
        body { font-family: 'Poppins', sans-serif; padding: 20px; color: #333; }
        
        /* Contenedor del encabezado con el logo */
        .header-container { 
            display: flex; 
            align-items: center; 
            justify-content: space-between; 
            border-bottom: 2px solid #4f8cff; 
            padding-bottom: 15px;
            margin-bottom: 30px; 
        }
        .logo-box img { 
            max-height: 70px; /* Ajusta el tamaño de tu logo desde aquí */
            width: auto; 
            object-fit: contain;
        }
        .title-box { text-align: right; }
        .title-box h1 { margin: 0; font-size: 26px; color: #1f2937; }
        .title-box p { margin: 5px 0 0 0; color: #6b7280; font-size: 14px; }

        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #f3f4f6; color: #1f2937; padding: 12px; text-align: left; border: 1px solid #ddd; font-size: 14px; }
        td { padding: 10px; border: 1px solid #ddd; font-size: 13px; }
        
        .actions { margin-top: 40px; text-align: center; }
        .btn-print { padding: 10px 20px; background: #4f8cff; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; font-weight: bold; }
        .volver { color: #4f8cff; text-decoration: none; font-size: 14px; }

        @media print { 
            .btn-print, .volver { display: none; } 
            body { padding: 0; }
            /* Asegura que los navegadores impriman las imágenes de fondo y logos */
            * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
        }
    </style>
</head>
<body>

<div class="header-container">
    <div class="logo-box">
        <img src="{{ asset('img/anglow.png') }}" alt="Logo Anglow">
    </div>
    
    <div class="title-box">
        <h1>Reporte de {{ $tipo == 'facturacion' ? 'Facturación' : ucfirst($tipo) }}</h1>
        <p>Fecha de emisión: {{ date('d/m/Y') }} | Anglow Store</p>
    </div>
</div>

<table>
    <thead>
        <tr>
            @if($tipo == 'ventas')
                <th>ID Venta</th><th>Total</th><th>Estado</th><th>Fecha</th>
            @elseif($tipo == 'inventario')
                <th>Producto</th><th>Stock</th><th>Precio</th><th>Categoría</th>
            @elseif($tipo == 'compras')
                <th>Proveedor</th><th>Costo Total</th><th>Fecha</th>
            @elseif($tipo == 'facturacion')
                <th>N° Factura</th><th>Cliente</th><th>Método Pago</th><th>Subtotal</th><th>Impuesto (19%)</th><th>Total</th><th>Fecha</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach($datos as $d)
            <tr>
                @if($tipo == 'ventas')
                    <td>#{{ $d->id }}</td><td>${{ number_format($d->total, 2) }}</td><td>{{ $d->estado }}</td><td>{{ $d->created_at->format('d/m/Y') }}</td>
                @elseif($tipo == 'inventario')
                    <td>{{ $d->nombre }}</td><td>{{ $d->stock }}</td><td>${{ number_format($d->precio, 2) }}</td><td>{{ $d->categoria->nombre ?? 'N/A' }}</td>
                @elseif($tipo == 'compras')
                    <td>{{ $d->proveedor ?? 'General' }}</td><td>${{ number_format($d->costo_total, 2) }}</td><td>{{ $d->created_at->format('d/m/Y') }}</td>
                @elseif($tipo == 'facturacion')
                    <td><strong>{{ $d->numero_factura }}</strong></td>
                    <td>{{ $d->cliente_nombre ?? 'Consumidor Final' }}</td>
                    <td>{{ strtoupper($d->metodo_pago ?? 'N/A') }}</td>
                    <td>${{ number_format($d->subtotal, 2) }}</td>
                    <td>${{ number_format($d->impuesto, 2) }}</td>
                    <td style="font-weight: bold;">${{ number_format($d->total, 2) }}</td>
                    <td>{{ $d->created_at ? $d->created_at->format('d/m/Y') : date('d/m/Y') }}</td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>

<div class="actions">
    <button onclick="window.print()" class="btn-print">🖨️ Imprimir / Guardar PDF</button>
    <br><br>
    <a href="{{ route('reportes.index') }}" class="volver">← Volver al Panel</a>
</div>

</body>
</html>
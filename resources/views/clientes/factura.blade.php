<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Compra #{{ $pedido->id }} - Anglow</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="invoice-body">

<div class="invoice-box">
    <div class="invoice-header">
        <div>
            <h1 style="font-size: 24px; color: #4f8cff; margin: 0;">Anglow Store</h1>
            <p style="color: #6b7280; margin: 5px 0 0 0; font-size: 14px;">¡Gracias por tu compra!</p>
        </div>
        <div>
            <span class="status-badge">{{ $pedido->estado_pago }}</span>
        </div>
    </div>

    <div class="info-grid">
        <div class="info-col">
            <h3>Detalles del Recibo</h3>
            <p><strong>Pedido ID:</strong> #{{ $pedido->id }}</p>
            <p><strong>Fecha:</strong> {{ $pedido->created_at->format('d/m/Y h:i A') }}</p>
            <p><strong>Método de pago:</strong> Pasarela Simulada</p>
        </div>
        <div class="info-col">
            <h3>Datos de Envío</h3>
            <p><strong>Teléfono:</strong> {{ $pedido->telefono }}</p>
            <p><strong>Destino:</strong> {{ $pedido->ciudad_departamento }} - {{ $pedido->barrio_sector }}</p>
            <p><strong>Dirección:</strong> {{ $pedido->direccion }}</p>
            @if($pedido->notas_envio)
                <p><strong>Notas:</strong> <span style="font-style: italic;">"{{ $pedido->notas_envio }}"</span></p>
            @endif
        </div>
    </div>

    <h3 style="font-size: 16px; margin-bottom: 10px; color: #1f2937;">Resumen de Pago</h3>
    <table class="invoice-table">
        <thead>
            <tr>
                <th>Concepto</th>
                <th style="text-align: right;">Monto</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Pago de productos seleccionados en el carrito de Anglow</td>
                <td style="text-align: right;">${{ number_format($pedido->total, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="invoice-total">
        Total Pagado: <span style="color: #4f8cff; font-size: 22px; font-weight: 800;">${{ number_format($pedido->total, 2) }}</span>
    </div>

    <div class="actions-container">
        <button onclick="window.print();" class="btn-action" style="background: #4b5563; color: white;">
            🖨️ Imprimir Factura
        </button>
        
        <a href="/tienda" class="btn-action" style="background: #4f8cff; color: white;">
            Volver a la Tienda
        </a>
    </div>
</div>

</body>
</html>
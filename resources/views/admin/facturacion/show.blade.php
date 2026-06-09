<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura {{ $factura->numero_factura }} - Anglow</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; margin: 0; padding: 0; background: #f3f4f6; color: #333; }
        .no-print-bar { background: #fff; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .no-print-bar a { color: #4f8cff; text-decoration: none; font-weight: bold; }
        .btn-print { background: #2a9d8f; color: white; padding: 8px 16px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; font-size: 14px; }
        .btn-print:hover { background: #21867a; }
        
        /* Contenedor de la Factura (Formato Hoja A4) */
        .invoice-box { max-width: 800px; margin: 30px auto; padding: 40px; background: #fff; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .header-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .header-table td { vertical-align: top; border: none; }
        .logo-title { font-size: 28px; font-weight: bold; color: #4f8cff; margin: 0; letter-spacing: 1px; }
        .company-details { font-size: 13px; color: #6b7280; line-height: 1.5; }
        .invoice-details { text-align: right; font-size: 14px; line-height: 1.5; }
        
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 6px; }
        .info-table td { padding: 15px; width: 50%; vertical-align: top; border: none; font-size: 14px; line-height: 1.6; }
        
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .items-table th { background: #4f8cff; color: white; padding: 10px 12px; font-size: 13px; text-transform: uppercase; font-weight: 600; }
        .items-table td { padding: 12px; border-bottom: 1px solid #e5e7eb; font-size: 14px; }
        
        .totals-table { float: right; width: 300px; border-collapse: collapse; margin-bottom: 30px; }
        .totals-table td { padding: 8px 12px; font-size: 14px; }
        .totals-table tr.grand-total { font-weight: bold; font-size: 16px; color: #4f8cff; background: #f4f8ff; }
        
        .footer-note { clear: both; text-align: center; padding-top: 50px; color: #9ca3af; font-size: 12px; border-top: 1px dashed #e5e7eb; }

        /* REGLAS ESPECIALES PARA CUANDO SE IMPRIME EN PAPEL O PDF */
        @media print {
            .no-print-bar { display: none !important; }
            body { background: #fff; }
            .invoice-box { box-shadow: none; margin: 0; padding: 0; max-width: 100%; }
        }
    </style>
</head>
<body>

{{-- Barra superior de acciones (No se imprime) --}}
<div class="no-print-bar">
    <a href="{{ route('facturacion.index') }}"><i class="fa-solid fa-arrow-left"></i> Regresar al Historial</a>
    <button class="btn-print" onclick="window.print()"><i class="fa-solid fa-print"></i> Imprimir / Guardar PDF</button>
</div>

{{-- Cuerpo de la Factura --}}
<div class="invoice-box">
    <table class="header-table">
        <tr>
            <td>
                <h1 class="logo-title">ANGLOW</h1>
                <div class="company-details">
                    Miscelánea Manualidades y Variedades Danna<br>
                    NIT: 123456789-1<br>
                    Bogótag, Colombia<br>
                    soporte@anglow.com
                </div>
            </td>
            <td class="invoice-details">
                <span style="font-size: 20px; font-weight: bold; color: #333;">FACTURA DE VENTA</span><br>
                <strong>Número:</strong> {{ $factura->numero_factura }}<br>
                <strong>Fecha:</strong> {{ $factura->created_at->format('d/m/Y') }}<br>
                <strong>Hora:</strong> {{ $factura->created_at->format('h:i A') }}<br>
                <strong>Estado:</strong> <span style="color: #0f5132; font-weight: bold;">{{ strtoupper($factura->estado) }}</span>
            </td>
        </tr>
    </table>

    <table class="info-table">
        <tr>
            <td>
                <strong style="color: #4f8cff; display:block; margin-bottom: 5px;">FACTURADO A:</strong>
                <strong>Nombre:</strong> {{ $factura->cliente_nombre }}<br>
                <strong>Identificación:</strong> Cliente Registrado<br>
                <strong>País:</strong> Colombia
            </td>
            <td>
                <strong style="color: #4f8cff; display:block; margin-bottom: 5px;">DETALLES DEL PAGO:</strong>
                <strong>Método de Pago:</strong> {{ $factura->metodo_pago }}<br>
                <strong>Moneda:</strong> COP ($)<br>
                <strong>ID Transacción Relacionada:</strong> #VENTA-{{ $factura->venta_id ?? 'N/A' }}
            </td>
        </tr>
    </table>

    <table class="items-table">
        <thead>
            <tr>
                <th>Descripción del Concepto / Producto</th>
                <th style="text-align: center; width: 100px;">Cant.</th>
                <th style="text-align: right; width: 150px;">Total Neto</th>
            </tr>
        </thead>
        <tbody>
            {{-- En un entorno real iterarías los productos de la venta, aquí ponemos el consolidado --}}
            <tr>
                <td>Adquisición de productos varios según orden de compra #{{ $factura->venta_id }}</td>
                <td style="text-align: center;">1</td>
                <td style="text-align: right;">${{ number_format($factura->subtotal, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <table class="totals-table">
        <tr>
            <td>Subtotal:</td>
            <td style="text-align: right;">${{ number_format($factura->subtotal, 2) }}</td>
        </tr>
        <tr>
            <td>Impuesto (IVA 19%):</td>
            <td style="text-align: right;">${{ number_format($factura->impuesto, 2) }}</td>
        </tr>
        <tr class="grand-total">
            <td>TOTAL APAGAR:</td>
            <td style="text-align: right;">${{ number_format($factura->total, 2) }}</td>
        </tr>
    </table>

    <div class="footer-note">
        <p>Gracias por tu compra en Anglow. Esta es una representación gráfica y simulación contable de factura electrónica.</p>
        <p><strong>Anglow - Tecnología, Papelería y Accesorios a tu alcance.</strong></p>
    </div>
</div>

</body>
</html>
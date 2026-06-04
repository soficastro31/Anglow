<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Compra - Anglow</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        /* Estilos específicos para ordenar el formulario y el resumen lado a lado */
        .checkout-layout {
            display: flex;
            gap: 30px;
            margin-top: 25px;
            flex-wrap: wrap;
        }
        .col-formulario {
            flex: 1.5;
            min-width: 320px;
        }
        .col-resumen {
            flex: 1;
            min-width: 300px;
        }
        .resumen-card {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 20px;
        }
        .item-resumen {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px dashed #e5e7eb;
            font-size: 14px;
        }
        .form-row {
            display: flex;
            gap: 15px;
        }
        .form-row div {
            flex: 1;
        }
    </style>
</head>
<body>

<nav>
    <div>
        <a href="/tienda"><strong>Anglow Store</strong></a>
    </div>
    <div>
        <a href="/carrito">← Volver al Carrito</a>
    </div>
</nav>

<div class="container" style="margin-top: 30px;">

    <h1>Finalizar Compra</h1>
    <p style="color: #6b7280; margin-bottom: 20px;">Completa tus datos para agendar el envío y proceder al pago.</p>

    @if(empty($carrito))
        <div class="form-card" style="text-align: center; padding: 40px;">
            <p style="font-size: 18px; color: #6b7280;">No hay productos en el carrito actualmente.</p>
            <a href="/tienda" class="btn crear" style="display: inline-block; margin-top: 15px; text-decoration: none;">Ir a la Tienda</a>
        </div>
    @else

        <div class="checkout-layout">
            
            <div class="col-formulario">
                <div class="form-card" style="width: 100%; box-shadow: none; border: 1px solid #e5e7eb; padding: 25px; margin: 0;">
                    <h2 style="margin-bottom: 20px; font-size: 20px; color: #1f2937;">📍 Datos de Envío</h2>
                    
                    <form method="POST" action="/checkout/procesar">
                        @csrf

                        <label style="font-size: 14px; font-weight: 500; color: #4b5563;">Teléfono de Celular:</label>
                        <input type="text" name="telefono" placeholder="Ej: 3123456789" required>

                        <div class="form-row">
                            <div>
                                <label style="font-size: 14px; font-weight: 500; color: #4b5563;">Ciudad / Departamento:</label>
                                <input type="text" name="ciudad_departamento" placeholder="Ej: Bogotá D.C." required>
                            </div>
                            <div>
                                <label style="font-size: 14px; font-weight: 500; color: #4b5563;">Barrio / Sector:</label>
                                <input type="text" name="barrio_sector" placeholder="Ej: Chapinero" required>
                            </div>
                        </div>

                        <label style="font-size: 14px; font-weight: 500; color: #4b5563;">Dirección Completa (Calle, Carrera, Apto, Torre):</label>
                        <input type="text" name="direccion" placeholder="Ej: Calle 65 # 9 - 15, Apto 302" required>

                        <label style="font-size: 14px; font-weight: 500; color: #4b5563;">Notas o Indicaciones de entrega (Opcional):</label>
                        <textarea name="notas_envio" placeholder="Ej: Dejar en portería, llamar al llegar..."></textarea>

                        <button type="submit" style="width: 100%; margin-top: 20px; background: #4f8cff; color: white; font-weight: bold; font-size: 16px;">
                            Continuar para Pagar
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-resumen">
                <div class="resumen-card">
                    <h2 style="margin-bottom: 15px; font-size: 18px; color: #1f2937;">🛒 Resumen de tu pedido</h2>
                    
                    <div style="margin-bottom: 20px;">
                        @foreach($carrito as $item)
                            <div class="item-resumen">
                                <div>
                                    <span style="font-weight: bold; color: #4f8cff;">{{ $item['cantidad'] }}x</span> 
                                    <span style="color: #1f2937; margin-left: 5px;">{{ $item['nombre'] }}</span>
                                </div>
                                <span style="font-weight: 500; color: #4b5563;">
                                    ${{ number_format($item['precio'] * $item['cantidad'], 2) }}
                                </span>
                            </div>
                        @endforeach
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 15px; border-top: 2px solid #e5e7eb;">
                        <span style="font-size: 18px; font-weight: bold; color: #1f2937;">Total:</span>
                        <span style="font-size: 22px; font-weight: 800; color: #4f8cff;">
                            ${{ number_format($total, 2) }}
                        </span>
                    </div>
                </div>
            </div>

        </div>

    @endif

</div>

</body>
</html>
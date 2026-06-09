<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pasarela de Pago - Anglow</title>
</head>
<body style="background-color: #f3f4f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0;">

<div class="container" style="text-align: center; padding: 40px 20px;">
    
    <div class="form-card" style="display: inline-block; max-width: 500px; width: 100%; padding: 35px; border-top: 5px solid #4f8cff; background: #ffffff; border-radius: 12px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); text-align: left;">
        
        <div style="text-align: center; margin-bottom: 20px;">
            <div style="font-size: 32px; font-weight: 800; color: #1f2937; letter-spacing: -1px;">Anglow <span style="color: #4f8cff;">Pay</span></div>
            <h2 style="color: #4b5563; margin: 5px 0 0 0; font-size: 18px; font-weight: 600;">Entorno Seguro de Pago</h2>
            <p style="color: #9ca3af; font-size: 13px; margin: 5px 0 0 0;">Orden de Compra: <strong>#{{ $pedido->id }}</strong></p>
        </div>

        <div style="background: #f0f6ff; padding: 15px 20px; border-radius: 10px; margin-bottom: 25px; text-align: center; border: 1px solid #e0e7ff;">
            <span style="font-size: 11px; color: #6b7280; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">
                TOTAL A TRANSMITIR
            </span>
            <h1 style="color: #4f8cff; margin: 5px 0 0 0; font-size: 36px; font-weight: 800;">
                ${{ number_format($pedido->total, 2) }}
            </h1>
        </div>

        <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 10px;">SELECCIONA UN MÉTODO DE PAGO</label>
        <div style="display: flex; gap: 10px; margin-bottom: 25px;">
            <div id="btn-tarjeta" onclick="seleccionarMetodo('tarjeta')" style="flex: 1; text-align: center; padding: 12px; border: 2px solid #4f8cff; background: #f0f6ff; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 14px; color: #4f8cff; transition: all 0.2s;">
                💳 Tarjeta
            </div>
            <div id="btn-efectivo" onclick="seleccionarMetodo('efectivo')" style="flex: 1; text-align: center; padding: 12px; border: 2px solid #e5e7eb; background: #ffffff; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 14px; color: #6b7280; transition: all 0.2s;">
                💵 Efectivo / Transf.
            </div>
        </div>

        <form id="form-pasarela" action="{{ route('checkout.simular-pago', ['id' => $pedido->id, 'resultado' => 'aprobado']) }}" method="POST">
            @csrf
            
            <div id="seccion-tarjeta">
                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-size: 13px; color: #4b5563; margin-bottom: 5px; font-weight: 500;">Nombre del Titular</label>
                    <input type="text" id="input-titular" placeholder="Ej. Sofía Castro" style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; box-sizing: border-box;" required>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-size: 13px; color: #4b5563; margin-bottom: 5px; font-weight: 500;">Número de Tarjeta</label>
                    <input type="text" id="input-tarjeta" placeholder="4556 1234 5678 9012" maxlength="19" style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; box-sizing: border-box;" required>
                </div>

                <div style="display: flex; gap: 15px; margin-bottom: 20px;">
                    <div style="flex: 1;">
                        <label style="display: block; font-size: 13px; color: #4b5563; margin-bottom: 5px; font-weight: 500;">Fecha de Vencimiento</label>
                        <input type="text" id="input-vence" placeholder="MM/AA" maxlength="5" style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; box-sizing: border-box;" required>
                    </div>
                    <div style="flex: 1;">
                        <label style="display: block; font-size: 13px; color: #4b5563; margin-bottom: 5px; font-weight: 500;">Código CVC / CVV</label>
                        <input type="password" id="input-cvv" placeholder="•••" maxlength="3" style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; box-sizing: border-box;" required>
                    </div>
                </div>
            </div>

            <div id="seccion-efectivo" style="display: none; margin-bottom: 25px; background: #f9fafb; padding: 15px; border-radius: 8px; border: 1px dashed #d1d5db;">
                <p style="margin: 0 0 8px 0; font-size: 14px; color: #374151; font-weight: 600;">Instrucciones de pago:</p>
                <p style="margin: 0; font-size: 13px; color: #6b7280; line-height: 1.4;">
                    Puedes simular una transferencia bancaria o pago en efectivo en puntos aliados. Selecciona abajo el estado con el que deseas procesar la simulación.
                </p>
            </div>

            <div style="display: flex; flex-direction: column; gap: 10px; margin-top: 20px;">
                <button type="submit" onclick="cambiarResultado('aprobado')" style="border: none; width: 100%; background: #2ec4b6; color: white; font-weight: bold; padding: 14px; border-radius: 8px; font-size: 16px; cursor: pointer; text-align: center; box-shadow: 0 4px 6px -1px rgba(46,196,182,0.2);">
                    ✓ Confirmar Pago Exitoso
                </button>

                <div style="display: flex; gap: 10px;">
                    <button type="submit" onclick="cambiarResultado('rechazado')" style="flex: 1; border: 1px solid #ef4444; background: #fff5f5; color: #ef4444; font-weight: 600; padding: 10px; border-radius: 8px; font-size: 13px; cursor: pointer; text-align: center;">
                        ✗ Simular Rechazo
                    </button>
                    
                    <button type="submit" onclick="cambiarResultado('pendiente')" style="flex: 1; border: 1px solid #f59e0b; background: #fffbeb; color: #b45309; font-weight: 600; padding: 10px; border-radius: 8px; font-size: 13px; cursor: pointer; text-align: center;">
                        ⏳ Simular Pendiente
                    </button>
                </div>
            </div>
        </form>

        <p style="margin-top: 25px; font-size: 14px; text-align: center; margin-bottom: 0;">
            <a href="/carrito" style="color: #6b7280; text-decoration: none; font-weight: 500;">Cancelar y regresar al carrito</a>
        </p>

    </div>
</div>

<script>
    // Función para alternar dinámicamente la URL del formulario según el botón presionado
    function cambiarResultado(estado) {
        const formulario = document.getElementById('form-pasarela');
        // Cambiamos la acción del formulario inyectando la variable "resultado" al final
        formulario.action = "{{ url('/checkout/simular-pago') }}/{{ $pedido->id }}/" + estado;
        
        // Si se va a simular un rechazo o pendiente, quitamos temporalmente el 'required' para facilitar la prueba rápida
        const inTitular = document.getElementById('input-titular');
        const inTarjeta = document.getElementById('input-tarjeta');
        const inVence = document.getElementById('input-vence');
        const inCvv = document.getElementById('input-cvv');
        
        if (estado !== 'aprobado') {
            inTitular.required = false;
            inTarjeta.required = false;
            inVence.required = false;
            inCvv.required = false;
        }
    }

    function seleccionarMetodo(metodo) {
        const btnTarjeta = document.getElementById('btn-tarjeta');
        const btnEfectivo = document.getElementById('btn-efectivo');
        const secTarjeta = document.getElementById('seccion-tarjeta');
        const secEfectivo = document.getElementById('seccion-efectivo');
        
        const inTitular = document.getElementById('input-titular');
        const inTarjeta = document.getElementById('input-tarjeta');
        const inVence = document.getElementById('input-vence');
        const inCvv = document.getElementById('input-cvv');

        if(metodo === 'tarjeta') {
            btnTarjeta.style.border = "2px solid #4f8cff";
            btnTarjeta.style.background = "#f0f6ff";
            btnTarjeta.style.color = "#4f8cff";
            btnEfectivo.style.border = "2px solid #e5e7eb";
            btnEfectivo.style.background = "#ffffff";
            btnEfectivo.style.color = "#6b7280";
            secTarjeta.style.display = "block";
            secEfectivo.style.display = "none";
            
            inTitular.required = true;
            inTarjeta.required = true;
            inVence.required = true;
            inCvv.required = true;
        } else {
            btnEfectivo.style.border = "2px solid #4f8cff";
            btnEfectivo.style.background = "#f0f6ff";
            btnEfectivo.style.color = "#4f8cff";
            btnTarjeta.style.border = "2px solid #e5e7eb";
            btnTarjeta.style.background = "#ffffff";
            btnTarjeta.style.color = "#6b7280";
            secTarjeta.style.display = "none";
            secEfectivo.style.display = "block";
            
            inTitular.required = false;
            inTarjeta.required = false;
            inVence.required = false;
            inCvv.required = false;
        }
    }

    document.getElementById('input-tarjeta').addEventListener('input', function (e) {
        e.target.value = e.target.value.replace(/[^\d]/g, '').replace(/(.{4})/g, '$1 ').trim();
    });

    document.getElementById('input-vence').addEventListener('input', function (e) {
        let value = e.target.value.replace(/[^\d]/g, '');
        if (value.length > 2) { value = value.substring(0, 2) + '/' + value.substring(2, 4); }
        e.target.value = value;
    });
</script>

</body>
</html>
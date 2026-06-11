<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Compra - Anglow</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
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

<div class="container checkout-container">

    <h1>Finalizar Compra</h1>
    <p class="checkout-subtitulo">Completa tus datos para agendar el envío y proceder al pago.</p>

    @if(empty($carrito))
        <div class="form-card carrito-vacio-card">
            <p class="carrito-vacio-texto">No hay productos en el carrito actualmente.</p>
            <a href="/tienda" class="btn crear btn-ir-tienda">Ir a la Tienda</a>
        </div>
    @else

        <div class="checkout-layout">
            
            <div class="col-formulario">
                <div class="form-card formulario-card-ajuste">
                    <h2 class="formulario-seccion-titulo">📍 Datos de Envío</h2>
                    
                    <form method="POST" action="/checkout/procesar" id="form-checkout">
                        @csrf

                        <label class="form-label">Teléfono de Celular:</label>
                        <input type="tel" name="telefono" placeholder="Ej: 3123456789" required 
                               pattern="3[0-9]{9}" maxlength="10"
                               title="Debe ingresar un número de celular celular válido (10 dígitos y empezar con 3)">

                        <div class="form-row">
                            <div>
                                <label class="form-label">Ciudad / Departamento:</label>
                                <input type="text" id="ciudad_departamento" name="ciudad_departamento" placeholder="Ej: Bogotá" required minlength="4">
                            </div>
                            <div>
                                <label class="form-label">Barrio / Sector:</label>
                                <input type="text" id="barrio_sector" name="barrio_sector" placeholder="Ej: Chapinero" required minlength="3">
                            </div>
                        </div>

                        <label class="form-label">Dirección Completa (Calle, Carrera, Número):</label>
                        <input type="text" id="direccion" name="direccion" placeholder="Ej: Calle 65 # 9-15" required minlength="5">

                        <input type="hidden" name="latitud" id="latitud" value="4.6482">
                        <input type="hidden" name="longitud" id="longitud" value="-74.0939">

                        <button type="button" onclick="buscarDireccionEscrita()" style="width:100%; background:#2ec4b6; color:white; padding:12px; border:none; border-radius:6px; font-weight:bold; font-size:14px; cursor:pointer; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(46,196,182,0.2);">
                            🔍 Ubicar dirección en el mapa
                        </button>

                        <div style="margin-bottom: 20px;">
                            <p style="margin: 0 0 10px 0; font-size: 13px; color: #6b7280; font-weight: 500;">
                                🗺️ **Confirmación del mapa:** Si el pin no queda en el techo exacto de tu casa, arrástralo para corregirlo.
                            </p>
                            <div id="mapa-entrega" style="width: 100%; height: 260px; border-radius: 8px; border: 1px solid #d1d5db; z-index: 1;"></div>
                        </div>

                        <label class="form-label">Notas o Indicaciones de entrega (Apto, Torre, Portería):</label>
                        <textarea name="notas_envio" placeholder="Ej: Apto 302, dejar en portería..."></textarea>

                        <button type="submit" class="btn-pagar-checkout">
                            Continuar para Pagar
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-resumen">
                <div class="resumen-card">
                    <h2 class="resumen-card-titulo">🛒 Resumen de tu pedido</h2>
                    
                    <div class="resumen-items-container">
                        @foreach($carrito as $item)
                            <div class="item-resumen">
                                <div>
                                    <span class="item-cantidad-badge">{{ $item['cantidad'] }}x</span> 
                                    <span class="item-nombre-texto">{{ $item['nombre'] }}</span>
                                </div>
                                <span class="item-precio-texto">
                                    ${{ number_format($item['precio'] * $item['cantidad'], 2) }}
                                </span>
                            </div>
                        @endforeach
                    </div>

                    <div class="total-checkout-container">
                        <span class="total-checkout-label">Total:</span>
                        <span class="total-checkout-monto">
                            ${{ number_format($total, 2) }}
                        </span>
                    </div>
                </div>
            </div>

        </div>

    @endif

</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    // Coordenadas iniciales por defecto (Centrado en Bogotá)
    let latActual = 4.6482;
    let lngActual = -74.0939;
    
    const map = L.map('mapa-entrega').setView([latActual, lngActual], 12);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap'
    }).addTo(map);

    const marker = L.marker([latActual, lngActual], { draggable: true }).addTo(map);

    // FUNCIÓN INTELIGENTE: Actualiza los campos ocultos al mover el pin
    function actualizarCamposCoordenadas(lat, lng) {
        document.getElementById('latitud').value = lat;
        document.getElementById('longitud').value = lng;
    }

    function buscarDireccionEscrita() {
        const ciudad = document.getElementById('ciudad_departamento').value.trim();
        const barrio = document.getElementById('barrio_sector').value.trim();
        let direccion = document.getElementById('direccion').value.trim();

        if (!direccion) {
            alert("Por favor, escribe tu dirección para buscarla.");
            return;
        }

        direccion = direccion.replace(/#/g, "");
        let direccionFiltrada = direccion.split(/(apto|apartamento|torre|int|interior|casa|piso)/i)[0].trim();
        const consultaCompleta = `${direccionFiltrada}, ${barrio}, ${ciudad}, Colombia`;

        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(consultaCompleta)}&countrycodes=co&limit=1`)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    const resultado = data[0];
                    latActual = parseFloat(resultado.lat);
                    lngActual = parseFloat(resultado.lon);

                    map.setView([latActual, lngActual], 16); 
                    marker.setLatLng([latActual, lngActual]);
                    actualizarCamposCoordenadas(latActual, lngActual);
                } else {
                    let direccionCorta = direccionFiltrada.split('-')[0].trim();
                    const consultaAlterna = `${direccionCorta}, ${ciudad}, Colombia`;

                    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(consultaAlterna)}&countrycodes=co&limit=1`)
                        .then(res => res.json())
                        .then(dataAlt => {
                            if (dataAlt.length > 0) {
                                const resAlt = dataAlt[0];
                                map.setView([parseFloat(resAlt.lat), parseFloat(resAlt.lon)], 16);
                                marker.setLatLng([parseFloat(resAlt.lat), parseFloat(resAlt.lon)]);
                                actualizarCamposCoordenadas(resAlt.lat, resAlt.lon);
                            } else {
                                alert("No pudimos ubicar el punto exacto de forma automática. Mueve el marcador manual en el mapa para confirmar.");
                            }
                        });
                }
            })
            .catch(error => console.error("Error en la petición de la API:", error));
    }

    // Escuchas de arrastre libre del pin por el usuario para capturar coordenadas reales
    marker.on('dragend', function (e) {
        const posicion = marker.getLatLng();
        map.panTo(posicion);
        actualizarCamposCoordenadas(posicion.lat, posicion.lng);
    });

    map.on('click', function (e) {
        marker.setLatLng(e.latlng);
        map.panTo(e.latlng);
        actualizarCamposCoordenadas(e.latlng.lat, e.latlng.lng);
    });
</script>

</body>
</html>
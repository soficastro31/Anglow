<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel del Administrador - Anglow</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<nav>
    <div>
        <a href="/tienda">
            <strong>Anglow Admin</strong>
        </a>
    </div>
    <div>
        <span style="margin-right:15px;">
            👤 {{ Auth::user()->name }} (Admin)
        </span>
        <a href="/logout">Cerrar sesión</a>
    </div>
</nav>

<div class="container">
    
    <div style="margin-bottom: 30px; margin-top: 20px;">
        <h1>Panel del Administrador</h1>
        <p style="color: #6b7280;">Hola, {{ Auth::user()->name }}. Gestiona el sistema desde el menú.</p>
    </div>

    <div class="grid-productos">

        <div class="producto-card" style="text-align: center; padding: 20px;">
            <div style="font-size: 35px; color: #4f8cff; margin-bottom: 10px;"><i class="fa-solid fa-user-gear"></i></div>
            <h3>Usuarios</h3>
            <p class="desc" style="font-size:12px; min-height:auto; margin-bottom:15px;">Gestiona usuarios del sistema</p>
            <button class="primary" style="background:#ccc; cursor:not-allowed;" disabled>Ver usuarios</button>
        </div>

        <div class="producto-card" style="text-align: center; padding: 20px;">
            <div style="font-size: 35px; color: #4f8cff; margin-bottom: 10px;"><i class="fa-solid fa-users"></i></div>
            <h3>Clientes</h3>
            <p class="desc" style="font-size:12px; min-height:auto; margin-bottom:15px;">Gestiona los clientes</p>
            <button class="primary" style="background:#ccc; cursor:not-allowed;" disabled>Ver clientes</button>
        </div>

        <div class="producto-card" style="text-align: center; padding: 20px;">
            <div style="font-size: 35px; color: #4f8cff; margin-bottom: 10px;"><i class="fa-solid fa-cart-shopping"></i></div>
            <h3>Compras</h3>
            <p class="desc" style="font-size:12px; min-height:auto; margin-bottom:15px;">Gestiona compras a proveedores</p>
            <button class="primary" style="background:#ccc; cursor:not-allowed;" disabled>Ver compras</button>
        </div>

        <div class="producto-card" style="text-align: center; padding: 20px; border: 2px solid #4f8cff;">
            <div style="font-size: 35px; color: #4f8cff; margin-bottom: 10px;"><i class="fa-solid fa-box-open"></i></div>
            <h3>Productos</h3>
            <p class="desc" style="font-size:12px; min-height:auto; margin-bottom:15px;">Modifica y gestiona productos</p>
            <a href="/productos/gestion"><button class="primary">Ver productos</button></a>
        </div>

        <div class="producto-card" style="text-align: center; padding: 20px;">
            <div style="font-size: 35px; color: #4f8cff; margin-bottom: 10px;"><i class="fa-solid fa-warehouse"></i></div>
            <h3>Inventario</h3>
            <p class="desc" style="font-size:12px; min-height:auto; margin-bottom:15px;">Revisa el inventario</p>
            <button class="primary" style="background:#ccc; cursor:not-allowed;" disabled>Ir a inventario</button>
        </div>

        <div class="producto-card" style="text-align: center; padding: 20px;">
            <div style="font-size: 35px; color: #4f8cff; margin-bottom: 10px;"><i class="fa-solid fa-cash-register"></i></div>
            <h3>Ventas</h3>
            <p class="desc" style="font-size:12px; min-height:auto; margin-bottom:15px;">Revisa las ventas</p>
            <button class="primary" style="background:#ccc; cursor:not-allowed;" disabled>Ver ventas</button>
        </div>

    </div>

</div>

</body>
</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control - Anglow</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<nav>
    <div>
      <a href="/tienda"><strong>Anglow {{ Auth::user()->rol === 'admin' ? 'Admin' : 'Empleado' }}</strong></a>
    </div>
    <div>
        <span style="margin-right:15px;">
            👤 {{ Auth::user()->name }} ({{ ucfirst(Auth::user()->rol) }})
        </span>
        <a href="/logout">Cerrar sesión</a>
    </div>
</nav>

<div class="container">
    <div style="margin-bottom: 30px; margin-top: 20px;">
        <h1>Panel del {{ Auth::user()->rol === 'admin' ? 'Administrador' : 'Empleado' }}</h1>
        <p style="color: #6b7280;">Hola, {{ Auth::user()->name }}. Gestiona el sistema desde el menú.</p>
    </div>

    <div class="grid-productos">

        {{-- USUARIOS --}}
        @if(Auth::user()->rol === 'admin')
            <div class="producto-card" style="text-align: center; padding: 20px; border: 2px solid #4f8cff;">
                <div style="font-size: 35px; color: #4f8cff; margin-bottom: 10px;"><i class="fa-solid fa-user-gear"></i></div>
                <h3>Usuarios</h3>
                <p class="desc" style="font-size:12px; min-height:auto; margin-bottom:15px;">Gestiona usuarios del sistema</p>
                <a href="/admin/usuarios"><button class="primary">Ver usuarios</button></a>
            </div>
        @endif

        {{-- CLIENTES --}}
        <div class="producto-card" style="text-align: center; padding: 20px; border: 2px solid #4f8cff;">
            <div style="font-size: 35px; color: #4f8cff; margin-bottom: 10px;"><i class="fa-solid fa-users"></i></div>
            <h3>Clientes</h3>
            <p class="desc" style="font-size:12px; min-height:auto; margin-bottom:15px;">Gestiona los clientes</p>
            <a href="/admin/clientes"><button class="primary">Ver clientes</button></a>
        </div>

        {{-- COMPRAS --}}
        <div class="producto-card" style="text-align: center; padding: 20px; border: 2px solid #4f8cff;">
            <div style="font-size: 35px; color: #4f8cff; margin-bottom: 10px;"><i class="fa-solid fa-cart-shopping"></i></div>
            <h3>Compras</h3>
            <p class="desc" style="font-size:12px; min-height:auto; margin-bottom:15px;">Gestiona compras a proveedores</p>
            <a href="/admin/compras"><button class="primary">Ver compras</button></a>
        </div>

        {{-- PRODUCTOS --}}
        <div class="producto-card" style="text-align: center; padding: 20px; border: 2px solid #4f8cff;">
            <div style="font-size: 35px; color: #4f8cff; margin-bottom: 10px;"><i class="fa-solid fa-box-open"></i></div>
            <h3>Productos</h3>
            <p class="desc" style="font-size:12px; min-height:auto; margin-bottom:15px;">Modifica y gestiona productos</p>
            <a href="/productos/gestion"><button class="primary">Ver productos</button></a>
        </div>

        {{-- INVENTARIO --}}
        <div class="producto-card" style="text-align: center; padding: 20px; border: 2px solid #4f8cff;">
            <div style="font-size: 35px; color: #4f8cff; margin-bottom: 10px;"><i class="fa-solid fa-warehouse"></i></div>
            <h3>Inventario</h3>
            <p class="desc" style="font-size:12px; min-height:auto; margin-bottom:15px;">Revisa el inventario</p>
            <a href="/admin/inventario"><button class="primary">Ir a inventario</button></a>
        </div>

        {{-- VENTAS --}}
        <div class="producto-card" style="text-align: center; padding: 20px; border: 2px solid #4f8cff;">
            <div style="font-size: 35px; color: #4f8cff; margin-bottom: 10px;"><i class="fa-solid fa-cash-register"></i></div>
            <h3>Ventas</h3>
            <p class="desc" style="font-size:12px; min-height:auto; margin-bottom:15px;">Revisa las ventas</p>
            <a href="/admin/ventas"><button class="primary">Ver ventas</button></a>
        </div>

        {{-- REPORTES --}}
        <div class="producto-card" style="text-align: center; padding: 20px; border: 2px solid #4f8cff;">
            <div style="font-size: 35px; color: #4f8cff; margin-bottom: 10px;"><i class="fa-solid fa-chart-line"></i></div>
            <h3>Reportes</h3>
            <p class="desc" style="font-size:12px; min-height:auto; margin-bottom:15px;">Revisa los reportes</p>
            <a href="/admin/reportes"><button class="primary">Ver reportes</button></a>
        </div>

        {{-- CATEGORÍAS --}}
        <div class="producto-card" style="text-align: center; padding: 20px; border: 2px solid #4f8cff;">
            <div style="font-size: 35px; color: #4f8cff; margin-bottom: 10px;"><i class="fa-solid fa-list"></i></div>
            <h3>Categorías</h3>
            <p class="desc" style="font-size:12px; min-height:auto; margin-bottom:15px;">Incluye las categorías de los productos</p>
            <a href="/admin/categorias"><button class="primary">Ver categorías</button></a>
        </div>

        {{-- FACTURACIÓN --}}
        <div class="producto-card" style="text-align: center; padding: 20px; border: 2px solid #4f8cff;">
            <div style="font-size: 35px; color: #4f8cff; margin-bottom: 10px;"><i class="fa-solid fa-file-invoice-dollar"></i></div>
            <h3>Facturación</h3>
            <p class="desc" style="font-size:12px; min-height:auto; margin-bottom:15px;">Mira y administra las facturas</p>
            <a href="/admin/facturas"><button class="primary">Ver facturas</button></a>
        </div>

        {{-- PEDIDOS --}}
        <div class="producto-card" style="text-align: center; padding: 20px; border: 2px solid #4f8cff;">
            <div style="font-size: 35px; color: #4f8cff; margin-bottom: 10px;"><i class="fa-solid fa-boxes-packing"></i></div>
            <h3>Pedidos</h3>
            <p class="desc" style="font-size:12px; min-height:auto; margin-bottom:15px;">Audita los flujos de entrega y estados de pago</p>
            <a href="/admin/pedidos"><button class="primary">Ver pedidos</button></a>
        </div>
        
    </div>
</div>

</body>
</html>
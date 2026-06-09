<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorías - Anglow</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: sans-serif; padding: 0; margin: 0; background: #f4f4f9; }
        nav { background: #fff; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        nav a { color: #4f8cff; text-decoration: none; font-weight: bold; }
        .container { max-width: 900px; margin: 40px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
        .header-actions { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .btn-add { background: #10b981; color: white; padding: 10px 15px; text-decoration: none; border-radius: 6px; font-weight: bold; }
        ul { list-style: none; padding: 0; }
        li { padding: 15px; border: 1px solid #e5e7eb; margin-bottom: 10px; border-radius: 6px; display: flex; justify-content: space-between; align-items: center; background: #fff; }
        .info-cat { display: flex; align-items: center; font-weight: 500; }
        .info-cat i { margin-right: 12px; color: #4f8cff; font-size: 18px; }
        .actions { display: flex; gap: 10px; align-items: center; }
        .btn-edit { color: #4f8cff; text-decoration: none; font-size: 14px; }
        .btn-delete { color: #ef4444; border: none; background: none; cursor: pointer; font-size: 14px; }
        .contador-productos { background: #e0e7ff; color: #4338ca; padding: 4px 10px; border-radius: 12px; font-size: 12px; font-weight: bold; margin-right: 15px; }
    </style>
</head>
<body>

<nav>
    <div><a href="{{ url('/admin') }}"><i class="fa-solid fa-arrow-left"></i> Volver al Panel</a></div>
    <div><span><i class="fa-solid fa-user"></i> {{ Auth::user()?->name ?? 'Admin' }}</span></div>
</nav>

<div class="container">
    <div class="header-actions">
        <h1>Categorías</h1>
        <a href="{{ route('admin.categorias.create') }}" class="btn-add">+ Nueva Categoría</a>
    </div>

    @if(session('success'))
        <div style="background: #d1fae5; color: #065f46; padding: 10px; border-radius: 5px; margin-bottom: 15px;">{{ session('success') }}</div>
    @endif

    <ul>
        @forelse($categorias as $categoria)
            <li>
                <div class="info-cat">
                    <i class="fa-solid {{ Str::contains(strtolower($categoria->nombre), 'papel') ? 'fa-pen-ruler' : (Str::contains(strtolower($categoria->nombre), 'tecn') ? 'fa-laptop' : 'fa-tags') }}"></i>
                    <span>{{ $categoria->nombre }}</span>
                </div>
                
                <div class="actions">
                    <span class="contador-productos">{{ $categoria->productos_count ?? 0 }} arts.</span>
                    <a href="{{ route('admin.categorias.edit', $categoria->id) }}" class="btn-edit"><i class="fa-solid fa-pen"></i></a>
                    <form action="{{ route('admin.categorias.destroy', $categoria->id) }}" method="POST" onsubmit="return confirm('¿Borrar categoría?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-delete"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </div>
            </li>
        @empty
            <li style="justify-content: center; color: #6b7280; padding: 20px;">No hay categorías registradas.</li>
        @endforelse
    </ul>
</div>

</body>
</html>
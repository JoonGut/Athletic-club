<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda - Athletic Club</title>
    @vite(['resources/css/estilos.css', 'resources/css/tienda.css'])
    <link rel="icon" href="{{ asset('images/escudoAthletic.png') }}">
</head>
<body>
    <header>
        <div class="logo">
            <img src="{{ asset('images/escudoAthletic.png') }}" alt="Logo Athletic Club" width="60">
            <h1>Tienda Athletic</h1>
        </div>
        <nav>
            <ul>
                <li><a href="{{ url('/inicio') }}">Inicio</a></li>
                <li><a href="{{ url('/tienda') }}">Tienda</a></li>
                <li><a href="{{ url('/jugadores') }}">Jugadores</a></li>
                <li><a href="{{ url('/miEquipo') }}">Mi equipo</a></li>
                <li><a href="{{ url('/carrito') }}">Carrito</a></li>
            </ul>
        </nav>
    </header>

    <main class="tienda-main">
        <section class="tienda-section">
            <h1 class="tienda-titulo">Tienda Oficial</h1>
            <p class="tienda-subtitulo">Productos oficiales del Athletic Club</p>

            @if(session('success'))
                <div class="tienda-estado tienda-exito">
                    ✓ {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="tienda-estado tienda-error">
                    ✕ {{ session('error') }}
                </div>
            @endif
        </section>

        <section class="tienda-section">
            <div class="tienda-grid">
                @forelse($productos as $p)
                    <article class="producto-card {{ $p->cantidad_stock <= 0 ? 'producto-sin-stock' : '' }}">
                        <img class="producto-imagen" src="{{ $p->imagen_url }}" alt="{{ $p->nombre }}" onerror="this.src='https://via.placeholder.com/260x240?text=Sin+imagen'">

                        <div class="producto-contenido">
                            <h3 class="producto-nombre">{{ $p->nombre }}</h3>
                            <p class="producto-descripcion">{{ $p->descripcion }}</p>
                            
                            <div class="producto-precio">{{ $p->precio }} €</div>
                            
                            @if($p->cantidad_stock > 0)
                                <p class="producto-stock">Stock: {{ $p->cantidad_stock }} unidades</p>
                                <form method="POST" action="{{ route('cart.add') }}" class="producto-form">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $p->id_producto }}">
                                    <div class="producto-cantidad">
                                        <input type="number" name="qty" value="1" min="1" max="{{ $p->cantidad_stock }}" required>
                                    </div>
                                    <button type="submit" class="btn btn-primario">Añadir</button>
                                </form>
                            @else
                                <p class="producto-stock" style="color: #c8102e; font-weight: 700;">Agotado</p>
                            @endif
                        </div>
                    </article>
                @empty
                    <p style="grid-column: 1/-1; text-align: center; padding: 40px; color: #666;">No hay productos disponibles</p>
                @endforelse
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2026 Athletic Club. Todos los derechos reservados.</p>
    </footer>
</body>
</html>

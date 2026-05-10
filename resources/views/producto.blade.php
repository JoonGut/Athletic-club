<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $producto->nombre }} - Tienda Athletic Club</title>
    @vite(['resources/css/estilos.css', 'resources/css/tienda.css'])
    <link rel="icon" href="{{ asset('images/escudoAthletic.png') }}">
</head>
<body>
    <header>
        <div class="logo">
            <img src="{{ asset('images/escudoAthletic.png') }}" alt="Logo Athletic Club" width="60">
            <h1>Athletic Club</h1>
        </div>
        <nav>
            <ul>
                <li><a href="{{ url('/inicio') }}">Inicio</a></li>
                <li><a href="{{ url('/tienda') }}">Tienda</a></li>
                <li><a href="{{ url('/carrito') }}">Carrito</a></li>
            </ul>
        </nav>
    </header>

    <main class="tienda-main">
        <section class="tienda-section" style="max-width: 900px;">
            <div style="margin-bottom: 24px;">
                <a href="{{ route('tienda.index') }}" style="color: #c8102e; text-decoration: none; font-weight: 600;">← Volver a la tienda</a>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 32px; align-items: start;">
                <div>
                    <div style="background: #f3f3f3; border-radius: 16px; overflow: hidden; aspect-ratio: 1; display: flex; align-items: center; justify-content: center;">
                        <img src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                </div>

                <div>
                    <p style="color: #c8102e; font-size: 14px; font-weight: 700; text-transform: uppercase; margin-bottom: 8px;">
                        {{ $producto->familia->tipo_familia ?? 'Producto' }}
                    </p>
                    
                    <h1 class="tienda-titulo" style="margin-bottom: 16px; line-height: 1.2;">{{ $producto->nombre }}</h1>
                    
                    <p style="color: #666; font-size: 16px; line-height: 1.6; margin-bottom: 24px;">
                        {{ $producto->descripcion }}
                    </p>

                    <div style="background: linear-gradient(135deg, #f9f9f9 0%, #f3f3f3 100%); border-radius: 12px; padding: 20px; margin-bottom: 24px;">
                        <div style="font-size: 14px; color: #777; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px;">Precio</div>
                        <div style="font-size: 36px; font-weight: 700; color: #c8102e;">{{ number_format($producto->precio, 2, ',', '.') }} €</div>
                    </div>

                    <div style="background: #e8f5e9; border-left: 4px solid #10b981; padding: 12px 14px; border-radius: 8px; margin-bottom: 24px; color: #2e7d32; font-size: 14px;">
                        ✓ Stock disponible: <strong>{{ $producto->cantidad_stock }} unidades</strong>
                    </div>

                    @if($producto->cantidad_stock > 0)
                        <form method="POST" action="{{ route('cart.add') }}">
                            @csrf
                            <input type="hidden" name="id" value="{{ $producto->id_producto }}">
                            
                            <div class="form-grupo">
                                <label for="qty">¿Cuántas unidades deseas?</label>
                                <div class="producto-cantidad" style="width: 100%;">
                                    <input type="number" id="qty" name="qty" value="1" min="1" max="{{ $producto->cantidad_stock }}" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primario" style="width: 100%; padding: 14px;">Añadir al carrito</button>
                        </form>
                    @else
                        <div style="background: #fee2e2; border: 1px solid #fecaca; border-radius: 8px; padding: 16px; text-align: center; color: #991b1b; font-weight: 600;">
                            Este producto está actualmente agotado
                        </div>
                    @endif

                    <div style="margin-top: 24px; padding-top: 24px; border-top: 1px solid #e8e8e8;">
                        <a href="{{ route('tienda.index') }}" class="btn btn-secundario" style="width: 100%; text-align: center; text-decoration: none;">Explorar más productos</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2026 Athletic Club. Todos los derechos reservados.</p>
    </footer>
</body>
</html>

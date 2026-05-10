<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito - Athletic Club</title>
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
                <li><a href="{{ url('/jugadores') }}">Jugadores</a></li>
                <li><a href="{{ url('/miEquipo') }}">Mi equipo</a></li>
                <li><a href="{{ url('/carrito') }}">Carrito</a></li>
            </ul>
        </nav>
    </header>

    <main class="tienda-main">
        <section class="tienda-section">
            <h1 class="tienda-titulo">Mi Carrito</h1>
            <p class="tienda-subtitulo">Revisa los productos antes de finalizar</p>

            @if(session('error'))
                <div class="tienda-estado tienda-error">
                    ✕ {{ session('error') }}
                </div>
            @endif
        </section>

        <section class="tienda-section">
            @if(empty($cart))
                <div class="carrito-seccion">
                    <div class="carrito-vacio">
                        <div class="carrito-vacio-icono">🛒</div>
                        <p style="font-size: 18px; margin-bottom: 16px;">Tu carrito está vacío</p>
                        <a href="{{ route('tienda.index') }}" class="btn btn-primario" style="display: inline-block; text-decoration: none;">Continuar comprando</a>
                    </div>
                </div>
            @else
                <div class="carrito-seccion">
                    <table class="carrito-tabla">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio Unitario</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0; @endphp
                            @foreach($cart as $item)
                                @php $subtotal = $item['precio'] * $item['qty']; $total += $subtotal; @endphp
                                <tr>
                                    <td><strong>{{ $item['nombre'] }}</strong></td>
                                    <td style="text-align: center;">{{ $item['qty'] }}</td>
                                    <td style="text-align: right;">{{ number_format($item['precio'], 2, ',', '.') }} €</td>
                                    <td style="text-align: right; font-weight: 700;">{{ number_format($subtotal, 2, ',', '.') }} €</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="carrito-resumen">
                        <div class="carrito-total">
                            <span>Total a pagar:</span>
                            <strong>{{ number_format($total, 2, ',', '.') }} €</strong>
                        </div>
                    </div>

                    <div class="checkout-form">
                        <h3 style="margin-bottom: 18px; color: #111;">Información de compra</h3>
                        <form method="POST" action="{{ route('cart.checkout') }}">
                            @csrf
                            <div class="form-grupo">
                                <label for="email">Email (opcional)</label>
                                <input type="email" id="email" name="email" placeholder="tu@email.com">
                            </div>

                            <div style="display: flex; gap: 12px;">
                                <a href="{{ route('tienda.index') }}" class="btn btn-secundario" style="flex: 1; text-align: center; text-decoration: none;">Seguir comprando</a>
                                <button type="submit" class="btn btn-primario" style="flex: 1;">Finalizar compra</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </section>
    </main>

    <footer>
        <p>&copy; 2026 Athletic Club. Todos los derechos reservados.</p>
    </footer>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Registro | Athletic Club</title>
	{{-- Reciclamos para utilizar el  mismo header y footer que en el inicio --}}
	@vite('resources/css/estilos.css') 
	@vite('resources/css/login.css')
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
				<li><a href="{{ url('/') }}">Inicio</a></li>
				<li><a href="{{ url('/plantilla') }}">Plantilla</a></li>
				<li><a href="{{ url('/login') }}">Socios</a></li>
				<li><a href="{{ url('/tienda') }}">Tienda</a></li>
			</ul>
		</nav>
	</header>

	<main class="registro-wrapper">
		<section class="registro-card">
			<h2>Registro de usuario</h2>

			<form class="registro-form" method="POST" action="{{ route('register.socios') }}">
				@csrf

				<div>
					<label for="nombre">Nombre completo</label>
					<input type="text" id="nombre" name="nombre" placeholder="Tu nombre" required>
				</div>
				<div>
					<label for="usuario">Nombre de usuario</label>
					<input type="text" id="usuario" name="usuario" placeholder="Tu nombre de usuario" required>
				</div>


				<div>
					<label for="email">Correo electrónico</label>
					<input type="email" id="email" name="email" placeholder="tuemail@correo.com" required>
				</div>

				<div>
					<label for="password">Contraseña</label>
					<input type="password" id="password" name="password" placeholder="Mínimo 8 caracteres" required>
				</div>

				<div>
					<label for="password_confirmacion">Confirmar contraseña</label>
					<input type="password" id="password_confirmacion" name="password_confirmacion" placeholder="Repite tu contraseña" required>
				</div>

				<button type="submit">Crear cuenta</button>
			</form>

			<div class="registro-extra">
				<span>¿Ya tienes una cuenta? <a href="{{ url('/login') }}">Inicia sesión</a></span>
			</div>
		</section>
	</main>

	<footer>
		<p>© 2026 Athletic Club | Página oficial</p>
	</footer>
</body>
</html>

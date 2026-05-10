<?php

use Illuminate\Support\Facades\Route;
use App\Mail\BienvenidaMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\ApiFutbol;
use App\Http\Controllers\Jugadores;
use App\Http\Controllers\TiendaController;

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', function () {
    return view('inicio');
});
Route::get('/registro', function () {
    return view('registro');
});
Route::post('/register', [RegistroController::class, 'socios'])->name('register.socios');
Route::get('/login', function () {
    return view('login');
});
Route::post('/login', [RegistroController::class, 'login'])->name('login.socios');
Route::get('/jugadores', [Jugadores::class, 'index'])->name('jugadores.index');
Route::get('/tienda', [TiendaController::class, 'index'])->name('tienda.index');
Route::get('/producto/{id}', [TiendaController::class, 'show'])->name('producto.show');
Route::post('/carrito/add', [TiendaController::class, 'addToCart'])->name('cart.add');
Route::get('/carrito', [TiendaController::class, 'cart'])->name('carrito');
Route::post('/carrito/checkout', [TiendaController::class, 'checkout'])->name('cart.checkout');
Route::get('/miEquipo', [ApiFutbol::class, 'miEquipo'])->name('mi.equipo');
Route::get('/equiposLiga', [ApiFutbol::class, 'equiposLiga'])->name('equipos.liga');
Route::get('/test-mail', function () {
    Mail::to('dam3.jon.gutierrez@gmail.com')->send(new BienvenidaMail());
    return 'Correo enviado';
});
Route::get('/probar-vista', function () {
    return view('emails.bienvenida');
});

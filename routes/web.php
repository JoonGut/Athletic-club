<?php

use Illuminate\Support\Facades\Route;
use App\Mail\BienvenidaMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\RegistroController;

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
Route::get('/test-mail', function () {
    Mail::to('dam3.jon.gutierrez@gmail.com')->send(new BienvenidaMail());
    return 'Correo enviado';
});
Route::get('/probar-vista', function () {
    return view('emails.bienvenida');
});

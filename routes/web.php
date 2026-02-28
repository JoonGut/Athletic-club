<?php

use Illuminate\Support\Facades\Route;
use App\Mail\BienvenidaMail;
use Illuminate\Support\Facades\Mail;

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', function () {
    return view('inicio');
});
Route::get('/test-mail', function () {
    Mail::to('dam3.jon.gutierrez@gmail.com')->send(new BienvenidaMail());
    return 'Correo enviado';
});
Route::get('/probar-vista', function () {
    return view('emails.bienvenida');
});

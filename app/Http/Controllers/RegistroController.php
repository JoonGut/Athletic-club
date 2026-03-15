<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RegistroController extends Controller
{
    public function socios (Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'usuario' => 'required|string|max:255|unique:users,usuario',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|same:password_confirmacion',
        ]);

        User::create([
            'nombre' => $validated['nombre'],
            'usuario' => $validated['usuario'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        return redirect('/login')->with('success', 'Usuario registrado correctamente');
    }
}

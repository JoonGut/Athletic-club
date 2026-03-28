<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class RegistroController extends Controller
{
    public function socios (Request $request)
    {
        $hasNombreColumn = Schema::hasColumn('usuarios', 'nombre');
        $hasUsuarioColumn = Schema::hasColumn('usuarios', 'usuario');

        $rules = [
            'nombre' => 'required|string|max:250',
            'email' => 'required|string|email|max:250|unique:usuarios,email',
            'password' => 'required|string|min:8|same:password_confirmacion',
            'usuario' => $hasUsuarioColumn
                ? 'required|string|max:250'
                : 'nullable|string|max:250',
        ];

        $validated = $request->validate($rules);

        $data = [
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ];

        if ($hasNombreColumn) {
            $data['nombre'] = $validated['nombre'];
        } else {
            $data['name'] = $validated['nombre'];
        }

        if ($hasUsuarioColumn && !empty($validated['usuario'])) {
            $data['usuario'] = $validated['usuario'];
        }

        DB::table('usuarios')->insert($data);

        return redirect('/login')->with('success', 'Usuario registrado correctamente');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|string|email|max:250',
            'password' => 'required|string',
        ]);

        $usuario = DB::table('usuarios')
            ->where('email', $validated['email'])
            ->first();

        if (!$usuario || !Hash::check($validated['password'], $usuario->password)) {
            return back()
                ->withErrors(['email' => 'Correo o contraseña incorrectos'])
                ->withInput();
        }

        $request->session()->regenerate();

        $request->session()->put('usuario_id', $usuario->id_usuario ?? null);
        $request->session()->put('usuario_email', $usuario->email);

        return redirect('/')->with('success', 'Sesión iniciada correctamente');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\LineaVenta;
use App\Models\Pago;
use Illuminate\Support\Facades\DB;

class TiendaController extends Controller
{
    public function index()
    {
        $productos = Producto::with('familia')->orderBy('nombre')->get();

        return view('tienda', compact('productos'));
    }

    public function show($id)
    {
        $producto = Producto::with('familia')->findOrFail($id);
        return view('producto', compact('producto'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([ 'id' => 'required|integer', 'qty' => 'required|integer|min:1' ]);

        $producto = Producto::findOrFail($request->id);

        $cart = session()->get('cart', []);

        $exists = $cart[$producto->id_producto] ?? null;
        $cart[$producto->id_producto] = [
            'producto_id' => $producto->id_producto,
            'nombre' => $producto->nombre,
            'precio' => $producto->precio,
            'qty' => ($exists['qty'] ?? 0) + $request->qty,
        ];

        session()->put('cart', $cart);

        return redirect()->route('tienda.index')->with('success', 'Producto añadido al carrito');
    }

    public function cart()
    {
        $cart = session()->get('cart', []);
        return view('carrito', compact('cart'));
    }

    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('tienda.index')->with('error', 'El carrito está vacío');
        }

        DB::beginTransaction();

        try {
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['precio'] * $item['qty'];
            }

            // Crear venta con id_usuario = 1 (usuario de sistema para compras anónimas)
            $venta = Venta::create([
                'fecha_compra' => date('Y-m-d'),
                'id_usuario' => 1,
            ]);

            foreach ($cart as $item) {
                $producto = DB::table('producto')->where('id_producto', $item['producto_id'])->first();

                if (!$producto) {
                    throw new \Exception('Producto no encontrado: ' . $item['producto_id']);
                }

                if ($producto->cantidad_stock < $item['qty']) {
                    throw new \Exception('Stock insuficiente para: ' . $producto->nombre);
                }

                // crear linea_ventas usando query builder (tabla no tiene id_linea)
                DB::table('linea_ventas')->insert([
                    'id_ventas' => $venta->id_venta,
                    'id_producto' => $producto->id_producto,
                    'cantidad' => $item['qty'],
                ]);

                // reducir stock
                DB::table('producto')->where('id_producto', $producto->id_producto)->decrement('cantidad_stock', $item['qty']);
            }

            // crear pago con total_pagado
            Pago::create([
                'metodo' => 'tarjeta',
                'total_pagado' => $total,
                'estado_pago' => 'completado',
                'fecha_pago' => date('Y-m-d'),
                'id_stripe' => 'offline_' . $venta->id_venta,
                'id_venta' => $venta->id_venta,
            ]);

            DB::commit();

            session()->forget('cart');

            return redirect()->route('tienda.index')->with('success', 'Compra realizada correctamente');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->route('carrito')->with('error', 'Error al procesar la compra: ' . $e->getMessage());
        }
    }
}

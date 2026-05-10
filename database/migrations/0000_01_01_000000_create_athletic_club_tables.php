<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Crear tabla usuarios
        Schema::create('usuarios', function (Blueprint $table) {
            $table->integer('id_usuario')->autoIncrement()->primary();
            $table->string('email', 250)->unique('un_email');
            $table->string('password', 250);
            $table->string('nombre', 250);
            $table->string('usuario', 250)->unique('un_usuario');
        });

        // Crear tabla familia
        Schema::create('familia', function (Blueprint $table) {
            $table->integer('id_familia')->autoIncrement()->primary();
            $table->string('tipo_familia', 250);
        });

        // Crear tabla producto
        Schema::create('producto', function (Blueprint $table) {
            $table->integer('id_producto')->autoIncrement()->primary();
            $table->integer('cantidad_stock');
            $table->string('nombre', 250);
            $table->integer('precio');
            $table->string('imagen_url', 250);
            $table->string('descripcion', 250);
            $table->integer('id_familia');
            $table->foreign('id_familia')->references('id_familia')->on('familia');
        });

        // Crear tabla ventas
        Schema::create('ventas', function (Blueprint $table) {
            $table->integer('id_venta')->autoIncrement()->primary();
            $table->timestamp('fecha_compra')->useCurrent();
            $table->integer('id_usuario');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios');
            $table->string('email', 250)->nullable();
        });

        // Crear tabla pagos
        Schema::create('pagos', function (Blueprint $table) {
            $table->integer('id_pagos')->autoIncrement()->primary();
            $table->string('metodo', 250)->default('tarjeta');
            $table->integer('total_pagado');
            $table->string('estado_pago', 250)->nullable();
            $table->timestamp('fecha_pago')->useCurrent();
            $table->string('id_stripe', 250);
            $table->integer('id_venta');
            
            $table->foreign('id_venta')->references('id_venta')->on('ventas');
            $table->unique('id_stripe', 'un_idStripe');
        });

        // Crear tabla linea_ventas
        Schema::create('linea_ventas', function (Blueprint $table) {
            $table->integer('id_producto');
            $table->integer('id_ventas');
            $table->integer('cantidad');
            
            $table->primary(['id_producto', 'id_ventas']);
            $table->foreign('id_producto')->references('id_producto')->on('producto');
            $table->foreign('id_ventas')->references('id_venta')->on('ventas');
        });

        // Crear tabla sessions para Laravel
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->integer('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('linea_ventas');
        Schema::dropIfExists('pagos');
        Schema::dropIfExists('ventas');
        Schema::dropIfExists('producto');
        Schema::dropIfExists('familia');
        Schema::dropIfExists('usuarios');
        Schema::dropIfExists('sessions');
    }
};

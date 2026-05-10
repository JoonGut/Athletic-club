<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'ventas';
    protected $primaryKey = 'id_venta';
    protected $fillable = ['fecha_compra', 'id_usuario'];
    public $timestamps = false;

    public function lineas()
    {
        return $this->hasMany(LineaVenta::class, 'id_ventas', 'id_venta');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'pagos';
    protected $primaryKey = 'id_pagos';
    protected $fillable = ['metodo', 'total_pagado', 'estado_pago', 'fecha_pago', 'id_stripe', 'id_venta'];
    public $timestamps = false;

    public function venta()
    {
        return $this->belongsTo(Venta::class, 'id_venta', 'id_venta');
    }
}

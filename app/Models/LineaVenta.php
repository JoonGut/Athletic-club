<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LineaVenta extends Model
{
    protected $table = 'linea_ventas';
    protected $primaryKey = null;
    public $incrementing = false;
    protected $fillable = ['id_ventas', 'id_producto', 'cantidad'];
    public $timestamps = false;

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'id_producto');
    }
}

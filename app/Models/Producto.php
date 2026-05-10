<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'producto';
    protected $primaryKey = 'id_producto';
    protected $fillable = [
        'cantidad_stock', 'nombre', 'precio', 'imagen_url', 'descripcion', 'id_familia'
    ];

    public function familia()
    {
        return $this->belongsTo(Familia::class, 'id_familia', 'id_familia');
    }
}

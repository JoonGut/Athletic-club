<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Familia extends Model
{
    protected $table = 'familia';
    protected $primaryKey = 'id_familia';
    protected $fillable = ['tipo_familia'];
}

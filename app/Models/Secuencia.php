<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Secuencia extends Model
{
    protected $fillable = [
        'titulo',
        'descripcion',
        'activo',
    ];
}

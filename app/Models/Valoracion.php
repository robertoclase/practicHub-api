<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Valoracion extends Model
{
    protected $table = 'valoraciones';

    protected $fillable = [
        'seguimiento_practica_id',
        'profesor_id',
        'puntuacion',
        'comentarios',
        'aspecto_valorado'
    ];

    public function seguimientoPractica()
    {
        return $this->belongsTo(SeguimientoPractica::class);
    }

    public function profesor()
    {
        return $this->belongsTo(Profesor::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{

    protected $fillable = [
        'user_id',
        'dni',
        'departamento',
        'especialidad',
        'telefono',
        'activo'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function seguimientosPracticas()
    {
        return $this->hasMany(SeguimientoPractica::class);
    }

    public function valoraciones()
    {
        return $this->hasMany(Valoracion::class);
    }
}
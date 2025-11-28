<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CursoAcademico extends Model
{

    protected $fillable = ['nombre', 'fecha_inicio', 'fecha_fin', 'activo'];

    public function seguimientosPracticas()
    {
        return $this->hasMany(SeguimientoPractica::class);
    }
}

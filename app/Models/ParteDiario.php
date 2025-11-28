<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParteDiario extends Model
{

    protected $fillable = [
        'seguimiento_practica_id',
        'fecha',
        'horas_realizadas',
        'actividades_realizadas',
        'observaciones',
        'dificultades',
        'soluciones_propuestas',
        'validado_tutor',
        'validado_profesor'
    ];

    public function seguimientoPractica()
    {
        return $this->belongsTo(SeguimientoPractica::class);
    }
}
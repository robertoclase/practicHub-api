<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeguimientoPractica extends Model
{

    protected $fillable = [
        'empresa_id',
        'profesor_id',
        'curso_academico_id',
        'user_id',
        'titulo',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'horas_totales',
        'estado',
        'objetivos',
        'actividades'
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function profesor()
    {
        return $this->belongsTo(Profesor::class);
    }

    public function cursoAcademico()
    {
        return $this->belongsTo(CursoAcademico::class);
    }

    public function alumno()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function partesDiarios()
    {
        return $this->hasMany(ParteDiario::class);
    }

    public function valoraciones()
    {
        return $this->hasMany(Valoracion::class);
    }
}

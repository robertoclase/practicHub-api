<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{

    protected $fillable = [
        'nombre', 'cif', 'direccion', 'telefono', 'email', 
        'sector', 'tutor_empresa', 'email_tutor', 'activo'
    ];

    public function seguimientosPracticas()
    {
        return $this->hasMany(SeguimientoPractica::class);
    }
}

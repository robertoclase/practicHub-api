<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Empresa extends Authenticatable
{
    use HasApiTokens;

    protected $fillable = [
        'nombre', 'cif', 'direccion', 'telefono', 'email',
        'sector', 'tutor_empresa', 'email_tutor', 'activo', 'password', 'foto_perfil'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'activo' => 'boolean',
        ];
    }

    public function seguimientosPracticas()
    {
        return $this->hasMany(SeguimientoPractica::class);
    }
}

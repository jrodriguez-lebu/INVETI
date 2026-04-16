<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Departamento extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function funcionarios(): HasMany
    {
        return $this->hasMany(Funcionario::class);
    }

    public function equipos(): HasMany
    {
        return $this->hasMany(Equipo::class);
    }
}

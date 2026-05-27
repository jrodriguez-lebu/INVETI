<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Direccion extends Model
{
    protected $table = 'direcciones';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function departamentos(): HasMany
    {
        return $this->hasMany(Departamento::class);
    }
}

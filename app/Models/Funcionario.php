<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Funcionario extends Model
{
    protected $fillable = [
        'nombre',
        'apellido',
        'rut',
        'cargo',
        'departamento_id',
        'email',
        'telefono',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function departamento(): BelongsTo
    {
        return $this->belongsTo(Departamento::class);
    }

    public function equipos(): HasMany
    {
        return $this->hasMany(Equipo::class);
    }

    public function actasEntrega(): HasMany
    {
        return $this->hasMany(ActaEntrega::class);
    }

    public function getNombreCompletoAttribute(): string
    {
        return $this->nombre . ' ' . $this->apellido;
    }
}

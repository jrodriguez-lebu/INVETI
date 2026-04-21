<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EquipoHistorial extends Model
{
    protected $table = 'equipo_historial';

    protected $fillable = [
        'equipo_id',
        'campo',
        'valor_anterior',
        'valor_nuevo',
        'user_id',
        'user_nombre',
    ];

    public function equipo(): BelongsTo
    {
        return $this->belongsTo(Equipo::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Etiqueta legible del campo que cambió.
     */
    public function getCampoLabelAttribute(): string
    {
        return match ($this->campo) {
            'funcionario'  => 'Responsable',
            'estado'       => 'Estado',
            'departamento' => 'Departamento',
            default        => ucfirst($this->campo),
        };
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoEquipo extends Model
{
    protected $table = 'tipos_equipo';

    protected $fillable = [
        'nombre',
        'icono',
        'descripcion',
    ];

    public function equipos(): HasMany
    {
        return $this->hasMany(Equipo::class, 'tipo_equipo_id');
    }

    public function getIconoHtmlAttribute(): string
    {
        $iconos = [
            'AIO' => '🖥️',
            'Notebook' => '💻',
            'Impresora' => '🖨️',
            'Multifuncional' => '🖨️',
            'Smartphone' => '📱',
            'Monitor' => '🖥️',
            'UPS' => '🔋',
            'Switch' => '🔌',
            'Router' => '📡',
            'Proyector' => '📽️',
            'Servidor' => '🖥️',
            'Tablet' => '📱',
            'Otro' => '💾',
        ];

        return $iconos[$this->nombre] ?? '💾';
    }
}

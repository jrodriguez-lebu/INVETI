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
        // Si el campo icono ya contiene un emoji (carácter Unicode > 255), usarlo directamente
        if ($this->icono && mb_strlen($this->icono) >= 1 && ord($this->icono[0]) > 127) {
            return $this->icono;
        }

        // Fallback: mapa por nombre para tipos existentes
        $iconos = [
            'AIO'          => '🖥️',
            'Notebook'     => '💻',
            'Impresora'    => '🖨️',
            'Multifuncional' => '🖨️',
            'Smartphone'   => '📱',
            'Monitor'      => '📺',
            'UPS'          => '🔋',
            'Switch'       => '🔌',
            'Router'       => '📡',
            'Proyector'    => '📽️',
            'Servidor'     => '🗄️',
            'Tablet'       => '📱',
            'Otro'         => '💾',
        ];

        return $iconos[$this->nombre] ?? '💾';
    }
}

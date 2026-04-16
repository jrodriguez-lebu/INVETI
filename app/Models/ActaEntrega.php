<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class ActaEntrega extends Model
{
    protected $table = 'actas_entrega';

    protected $fillable = [
        'numero_acta',
        'equipo_id',
        'funcionario_id',
        'fecha_entrega',
        'observaciones',
        'firmada',
    ];

    protected $casts = [
        'fecha_entrega' => 'date',
        'firmada' => 'boolean',
    ];

    public static function generarNumeroActa(): string
    {
        $year = date('Y');
        $last = static::whereYear('created_at', $year)->orderByDesc('id')->first();
        $sequence = $last ? ((int) substr($last->numero_acta, -4)) + 1 : 1;
        return 'ACT-' . $year . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    public function equipo(): BelongsTo
    {
        return $this->belongsTo(Equipo::class);
    }

    public function funcionario(): BelongsTo
    {
        return $this->belongsTo(Funcionario::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Equipo extends Model
{
    protected $fillable = [
        'tipo_equipo_id',
        'marca',
        'modelo',
        'numero_serie',
        'numero_inventario',
        'estado',
        'funcionario_id',
        'departamento_id',
        'fecha_adquisicion',
        'valor_adquisicion',
        'descripcion',
        'observaciones',
        'cpu',
        'ram',
        'almacenamiento',
        'ubicacion',
        'codigo_anydesk',
        'office_version',
        'clave_windows',
        'factura_documento',
        'numero_opi',
        'numero_factura',
        'rut_proveedor',
        'nombre_proveedor',
        'datos_incompletos',
        'campos_faltantes',
    ];

    protected $casts = [
        'fecha_adquisicion'  => 'date',
        'valor_adquisicion'  => 'decimal:2',
        'datos_incompletos'  => 'boolean',
        'campos_faltantes'   => 'array',
    ];

    // Campos que se auditan para trazabilidad
    protected const CAMPOS_AUDITADOS = ['funcionario_id', 'estado', 'departamento_id'];

    protected static function boot(): void
    {
        parent::boot();

        // Recalcular incompletos antes de guardar
        static::saving(function (Equipo $equipo) {
            $missing = $equipo->incompleteFields();
            $equipo->datos_incompletos = count($missing) > 0;
            $equipo->campos_faltantes  = $missing;
        });

        // Registrar historial de cambios después de actualizar
        static::updated(function (Equipo $equipo) {
            $changes  = $equipo->getChanges();
            $original = $equipo->getOriginal();
            $user     = Auth::user();

            foreach (self::CAMPOS_AUDITADOS as $campo) {
                if (!array_key_exists($campo, $changes)) continue;

                $anterior = $original[$campo] ?? null;
                $nuevo    = $changes[$campo] ?? null;

                if ($anterior === $nuevo) continue;

                EquipoHistorial::create([
                    'equipo_id'      => $equipo->id,
                    'campo'          => match($campo) {
                        'funcionario_id'  => 'funcionario',
                        'estado'          => 'estado',
                        'departamento_id' => 'departamento',
                    },
                    'valor_anterior' => $equipo->resolverValor($campo, $anterior),
                    'valor_nuevo'    => $equipo->resolverValor($campo, $nuevo),
                    'user_id'        => $user?->id,
                    'user_nombre'    => $user?->name,
                ]);
            }
        });
    }

    /**
     * Convierte un ID o valor crudo en texto legible para el historial.
     */
    public function resolverValor(string $campo, mixed $valor): ?string
    {
        if ($valor === null) return null;

        return match($campo) {
            'funcionario_id'  => Funcionario::find($valor)?->nombre_completo ?? "ID: $valor",
            'departamento_id' => Departamento::find($valor)?->nombre ?? "ID: $valor",
            'estado'          => match($valor) {
                'activo'   => 'Activo',
                'inactivo' => 'Inactivo',
                'baja'     => 'Dado de Baja',
                default    => $valor,
            },
            default => (string) $valor,
        };
    }

    public function tipoEquipo(): BelongsTo
    {
        return $this->belongsTo(TipoEquipo::class, 'tipo_equipo_id');
    }

    public function funcionario(): BelongsTo
    {
        return $this->belongsTo(Funcionario::class);
    }

    public function departamento(): BelongsTo
    {
        return $this->belongsTo(Departamento::class);
    }

    public function actasEntrega(): HasMany
    {
        return $this->hasMany(ActaEntrega::class);
    }

    public function historial(): HasMany
    {
        return $this->hasMany(EquipoHistorial::class)->orderByDesc('created_at');
    }

    public function getEstadoBadgeAttribute(): string
    {
        return match($this->estado) {
            'activo'   => 'bg-green-100 text-green-800',
            'inactivo' => 'bg-gray-100 text-gray-800',
            'baja'     => 'bg-red-100 text-red-800',
            default    => 'bg-gray-100 text-gray-800',
        };
    }

    public function getEstadoLabelAttribute(): string
    {
        return match($this->estado) {
            'activo'   => 'Activo',
            'inactivo' => 'Inactivo',
            'baja'     => 'Dado de Baja',
            default    => ucfirst($this->estado),
        };
    }

    public function getNombreCompletoAttribute(): string
    {
        return $this->marca . ' ' . $this->modelo;
    }

    /**
     * Returns a list of key field labels that are missing for this equipment record.
     */
    public function incompleteFields(): array
    {
        $missing = [];

        if (empty($this->funcionario_id)) {
            $missing[] = 'Encargado';
        }
        if (empty($this->tipo_equipo_id)) {
            $missing[] = 'Tipo Equipo';
        }
        if (empty($this->marca) || $this->marca === 'Sin marca') {
            $missing[] = 'Marca';
        }
        if (empty($this->departamento_id)) {
            $missing[] = 'Dirección';
        }

        return $missing;
    }

    /**
     * Scope to filter equipment records flagged as incomplete.
     */
    public function scopeIncompletos($query)
    {
        return $query->where('datos_incompletos', true);
    }
}

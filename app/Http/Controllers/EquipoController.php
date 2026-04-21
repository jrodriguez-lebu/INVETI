<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\Equipo;
use App\Models\Funcionario;
use App\Models\TipoEquipo;
use Illuminate\Http\Request;

class EquipoController extends Controller
{
    // ─── Helpers ────────────────────────────────────────────────────────────────

    /**
     * Retorna el próximo N° de inventario disponible en formato INV-XXXX.
     * Acepta ?count=N para devolver N números consecutivos.
     */
    public function nextInventario(Request $request)
    {
        $count = max(1, min(20, (int) $request->get('count', 1)));

        // Buscar el mayor número existente en formato INV-NNNN
        $last = Equipo::where('numero_inventario', 'like', 'INV-%')
            ->get()
            ->filter(fn($e) => preg_match('/^INV-(\d+)$/', $e->numero_inventario))
            ->map(fn($e) => (int) substr($e->numero_inventario, 4))
            ->max() ?? 0;

        $numbers = [];
        $next = $last + 1;

        for ($i = 0; $i < $count; $i++) {
            // Saltar si ya existe (por si acaso hay huecos con otros formatos)
            while (Equipo::where('numero_inventario', 'INV-' . str_pad($next, 4, '0', STR_PAD_LEFT))->exists()) {
                $next++;
            }
            $numbers[] = 'INV-' . str_pad($next, 4, '0', STR_PAD_LEFT);
            $next++;
        }

        return response()->json(['numbers' => $numbers]);
    }

    // ─── CRUD ───────────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $query = Equipo::with(['tipoEquipo', 'funcionario', 'departamento']);

        if ($request->boolean('incompletos')) {
            $query->incompletos();
        }

        if ($request->filled('tipo_equipo_id')) {
            $query->where('tipo_equipo_id', $request->tipo_equipo_id);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('departamento_id')) {
            $query->where('departamento_id', $request->departamento_id);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('equipos.marca', 'like', "%$s%")
                  ->orWhere('equipos.modelo', 'like', "%$s%")
                  ->orWhere('equipos.numero_serie', 'like', "%$s%")
                  ->orWhere('equipos.numero_inventario', 'like', "%$s%");
            });
        }

        // ── Ordenamiento por columna ─────────────────────────────────────────
        $sort = $request->get('sort', 'created_at');
        $dir  = $request->get('direction', 'desc') === 'asc' ? 'asc' : 'desc';

        match ($sort) {
            'tipo' => $query
                ->leftJoin('tipos_equipo', 'equipos.tipo_equipo_id', '=', 'tipos_equipo.id')
                ->orderBy('tipos_equipo.nombre', $dir)
                ->select('equipos.*'),

            'responsable' => $query
                ->leftJoin('funcionarios', 'equipos.funcionario_id', '=', 'funcionarios.id')
                ->orderBy('funcionarios.apellido', $dir)
                ->orderBy('funcionarios.nombre', $dir)
                ->select('equipos.*'),

            'departamento' => $query
                ->leftJoin('departamentos', 'equipos.departamento_id', '=', 'departamentos.id')
                ->orderBy('departamentos.nombre', $dir)
                ->select('equipos.*'),

            'numero_inventario', 'marca', 'modelo', 'numero_serie', 'estado', 'fecha_adquisicion'
                => $query->orderBy('equipos.' . $sort, $dir),

            default => $query->orderBy('equipos.created_at', 'desc'),
        };

        $perPage = in_array((int) $request->get('per_page'), [10, 25, 50, 100]) ? (int) $request->get('per_page') : 15;
        $equipos          = $query->paginate($perPage)->withQueryString();
        $tipos            = TipoEquipo::orderBy('nombre')->get();
        $departamentos    = Departamento::orderBy('nombre')->get();
        $totalIncompletos = Equipo::incompletos()->count();

        return view('equipos.index', compact('equipos', 'tipos', 'departamentos', 'totalIncompletos'));
    }

    public function create()
    {
        $tipos        = TipoEquipo::orderBy('nombre')->get();
        $funcionarios = Funcionario::where('activo', true)->orderBy('nombre')->orderBy('apellido')->get();
        $departamentos = Departamento::orderBy('nombre')->get();
        return view('equipos.create', compact('tipos', 'funcionarios', 'departamentos'));
    }

    public function store(Request $request)
    {
        // Validar campos compartidos
        $request->validate([
            'tipo_equipo_id'    => 'required|exists:tipos_equipo,id',
            'marca'             => 'required|string|max:100',
            'modelo'            => 'required|string|max:150',
            'estado'            => 'required|in:activo,inactivo,baja',
            'funcionario_id'    => 'nullable|exists:funcionarios,id',
            'departamento_id'   => 'nullable|exists:departamentos,id',
            'fecha_adquisicion' => 'nullable|date',
            'valor_adquisicion' => 'nullable|numeric|min:0',
            'descripcion'       => 'nullable|string',
            'observaciones'     => 'nullable|string',
            'numero_opi'        => 'nullable|string|max:100',
            'numero_factura'    => 'nullable|string|max:100',
            'rut_proveedor'     => 'nullable|string|max:20',
            'nombre_proveedor'  => 'nullable|string|max:150',
            // Filas individuales
            'items'                         => 'required|array|min:1|max:20',
            'items.*.numero_inventario'     => 'required|string|max:100',
            'items.*.numero_serie'          => 'nullable|string|max:100',
        ]);

        // Verificar unicidad de N° inventario (en la BD y entre las filas del mismo envío)
        $inventariosEnviados = collect($request->items)->pluck('numero_inventario');

        if ($inventariosEnviados->unique()->count() !== $inventariosEnviados->count()) {
            return back()->withInput()
                ->withErrors(['items' => 'Hay números de inventario duplicados en el formulario.']);
        }

        foreach ($request->items as $idx => $item) {
            if (Equipo::where('numero_inventario', $item['numero_inventario'])->exists()) {
                return back()->withInput()
                    ->withErrors(["items.{$idx}.numero_inventario" => "El N° {$item['numero_inventario']} ya existe en la base de datos."]);
            }
        }

        $shared = $request->only([
            'tipo_equipo_id', 'marca', 'modelo', 'estado',
            'funcionario_id', 'departamento_id',
            'fecha_adquisicion', 'valor_adquisicion',
            'descripcion', 'observaciones',
            'numero_opi', 'numero_factura', 'rut_proveedor', 'nombre_proveedor',
        ]);

        $creados = [];
        foreach ($request->items as $item) {
            $creados[] = Equipo::create(array_merge($shared, [
                'numero_inventario' => $item['numero_inventario'],
                'numero_serie'      => $item['numero_serie'] ?? null,
            ]));
        }

        $cantidad = count($creados);

        // Si es 1 equipo y se marcó generar acta, redirigir al formulario de acta
        if ($request->boolean('generar_acta') && $cantidad === 1 && !empty($shared['funcionario_id'])) {
            return redirect()->route('actas.create', ['equipo_id' => $creados[0]->id])
                ->with('success', 'Equipo creado. Complete el acta de entrega.');
        }

        $mensaje = $cantidad === 1
            ? 'Equipo registrado correctamente.'
            : "{$cantidad} equipos registrados correctamente.";

        return redirect()->route('equipos.index')->with('success', $mensaje);
    }

    public function show(Equipo $equipo)
    {
        $equipo->load(['tipoEquipo', 'funcionario.departamento', 'departamento', 'actasEntrega.funcionario']);
        return view('equipos.show', compact('equipo'));
    }

    public function edit(Equipo $equipo)
    {
        $tipos        = TipoEquipo::orderBy('nombre')->get();
        $funcionarios = Funcionario::where('activo', true)->orderBy('nombre')->orderBy('apellido')->get();
        $departamentos = Departamento::orderBy('nombre')->get();
        return view('equipos.edit', compact('equipo', 'tipos', 'funcionarios', 'departamentos'));
    }

    public function update(Request $request, Equipo $equipo)
    {
        $validated = $request->validate([
            'tipo_equipo_id'    => 'required|exists:tipos_equipo,id',
            'marca'             => 'required|string|max:100',
            'modelo'            => 'required|string|max:150',
            'numero_serie'      => 'nullable|string|max:100',
            'numero_inventario' => 'required|string|max:100|unique:equipos,numero_inventario,' . $equipo->id,
            'estado'            => 'required|in:activo,inactivo,baja',
            'funcionario_id'    => 'nullable|exists:funcionarios,id',
            'departamento_id'   => 'nullable|exists:departamentos,id',
            'fecha_adquisicion' => 'nullable|date',
            'valor_adquisicion' => 'nullable|numeric|min:0',
            'descripcion'       => 'nullable|string',
            'observaciones'     => 'nullable|string',
            'numero_opi'        => 'nullable|string|max:100',
            'numero_factura'    => 'nullable|string|max:100',
            'rut_proveedor'     => 'nullable|string|max:20',
            'nombre_proveedor'  => 'nullable|string|max:150',
        ]);

        $equipo->update($validated);

        return redirect()->route('equipos.show', $equipo)
            ->with('success', 'Equipo actualizado correctamente.');
    }

    public function destroy(Equipo $equipo)
    {
        if ($equipo->actasEntrega()->count() > 0) {
            return back()->with('error', 'No se puede eliminar este equipo porque tiene actas de entrega asociadas.');
        }

        $equipo->delete();

        return redirect()->route('equipos.index')
            ->with('success', 'Equipo eliminado correctamente.');
    }
}

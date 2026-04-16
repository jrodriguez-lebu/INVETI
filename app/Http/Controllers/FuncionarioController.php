<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\Funcionario;
use Illuminate\Http\Request;

class FuncionarioController extends Controller
{
    public function index(Request $request)
    {
        $query = Funcionario::with(['departamento'])
            ->withCount('equipos');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%$search%")
                  ->orWhere('apellido', 'like', "%$search%")
                  ->orWhere('rut', 'like', "%$search%")
                  ->orWhere('cargo', 'like', "%$search%");
            });
        }

        if ($request->filled('departamento_id')) {
            $query->where('departamento_id', $request->departamento_id);
        }

        if ($request->filled('activo')) {
            $query->where('activo', $request->activo);
        }

        $funcionarios = $query->orderBy('apellido')->orderBy('nombre')->paginate(15)->withQueryString();
        $departamentos = Departamento::orderBy('nombre')->get();

        return view('funcionarios.index', compact('funcionarios', 'departamentos'));
    }

    public function create()
    {
        $departamentos = Departamento::orderBy('nombre')->get();
        return view('funcionarios.create', compact('departamentos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'          => 'required|string|max:100',
            'apellido'        => 'required|string|max:100',
            'rut'             => 'required|string|max:20|unique:funcionarios,rut',
            'cargo'           => 'required|string|max:150',
            'departamento_id' => 'required|exists:departamentos,id',
            'email'           => 'nullable|email|max:150',
            'telefono'        => 'nullable|string|max:20',
            'activo'          => 'boolean',
        ]);

        $validated['activo'] = $request->has('activo');

        Funcionario::create($validated);

        return redirect()->route('funcionarios.index')
            ->with('success', 'Funcionario creado correctamente.');
    }

    public function show(Funcionario $funcionario)
    {
        $funcionario->load(['departamento', 'equipos.tipoEquipo', 'actasEntrega.equipo.tipoEquipo']);
        return view('funcionarios.show', compact('funcionario'));
    }

    public function edit(Funcionario $funcionario)
    {
        $departamentos = Departamento::orderBy('nombre')->get();
        return view('funcionarios.edit', compact('funcionario', 'departamentos'));
    }

    public function update(Request $request, Funcionario $funcionario)
    {
        $validated = $request->validate([
            'nombre'          => 'required|string|max:100',
            'apellido'        => 'required|string|max:100',
            'rut'             => 'required|string|max:20|unique:funcionarios,rut,' . $funcionario->id,
            'cargo'           => 'required|string|max:150',
            'departamento_id' => 'required|exists:departamentos,id',
            'email'           => 'nullable|email|max:150',
            'telefono'        => 'nullable|string|max:20',
            'activo'          => 'boolean',
        ]);

        $validated['activo'] = $request->has('activo');

        $funcionario->update($validated);

        return redirect()->route('funcionarios.show', $funcionario)
            ->with('success', 'Funcionario actualizado correctamente.');
    }

    public function destroy(Funcionario $funcionario)
    {
        if ($funcionario->equipos()->count() > 0) {
            return back()->with('error', 'No se puede eliminar este funcionario porque tiene equipos asignados.');
        }

        $funcionario->delete();

        return redirect()->route('funcionarios.index')
            ->with('success', 'Funcionario eliminado correctamente.');
    }

    /**
     * Creación rápida de funcionario vía AJAX desde el formulario de equipos.
     * Retorna JSON con el funcionario creado.
     */
    public function quickStore(Request $request)
    {
        $validated = $request->validate([
            'nombre'          => 'required|string|max:100',
            'apellido'        => 'required|string|max:100',
            'rut'             => 'required|string|max:20|unique:funcionarios,rut',
            'cargo'           => 'required|string|max:150',
            'departamento_id' => 'nullable|exists:departamentos,id',
            'email'           => 'nullable|email|max:150',
            'telefono'        => 'nullable|string|max:20',
        ]);

        $funcionario = Funcionario::create(array_merge($validated, ['activo' => true]));
        $funcionario->load('departamento');

        return response()->json([
            'id'              => $funcionario->id,
            'nombre_completo' => $funcionario->nombre_completo,
            'cargo'           => $funcionario->cargo,
            'departamento'    => $funcionario->departamento?->nombre ?? '—',
            'label'           => $funcionario->nombre_completo . ' — ' . $funcionario->cargo,
        ]);
    }
}

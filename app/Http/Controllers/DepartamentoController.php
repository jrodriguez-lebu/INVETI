<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\Direccion;
use Illuminate\Http\Request;

class DepartamentoController extends Controller
{
    public function index()
    {
        $departamentos = Departamento::withCount(['funcionarios', 'equipos'])
            ->with('direccion')
            ->orderBy('nombre')
            ->get();
        return view('departamentos.index', compact('departamentos'));
    }

    public function create()
    {
        $direcciones = Direccion::orderBy('nombre')->get();
        return view('departamentos.create', compact('direcciones'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'direccion_id' => 'nullable|exists:direcciones,id',
            'nombre'       => 'required|string|max:150|unique:departamentos,nombre',
            'descripcion'  => 'nullable|string',
        ]);

        Departamento::create($validated);

        return redirect()->route('departamentos.index')
            ->with('success', 'Departamento creado correctamente.');
    }

    public function edit(Departamento $departamento)
    {
        $direcciones = Direccion::orderBy('nombre')->get();
        return view('departamentos.edit', compact('departamento', 'direcciones'));
    }

    public function update(Request $request, Departamento $departamento)
    {
        $validated = $request->validate([
            'direccion_id' => 'nullable|exists:direcciones,id',
            'nombre'       => 'required|string|max:150|unique:departamentos,nombre,' . $departamento->id,
            'descripcion'  => 'nullable|string',
        ]);

        $departamento->update($validated);

        return redirect()->route('departamentos.index')
            ->with('success', 'Departamento actualizado correctamente.');
    }

    /**
     * Creación rápida de departamento desde modal (AJAX).
     */
    public function quickStore(Request $request)
    {
        $validated = $request->validate([
            'nombre'       => 'required|string|max:150|unique:departamentos,nombre',
            'direccion_id' => 'nullable|exists:direcciones,id',
        ], [
            'nombre.required' => 'El nombre del departamento es obligatorio.',
            'nombre.unique'   => 'Ya existe un departamento con ese nombre.',
        ]);

        $dep = Departamento::create($validated);
        $dep->load('direccion');

        return response()->json([
            'id'          => $dep->id,
            'nombre'      => $dep->nombre,
            'direccion_id'=> $dep->direccion_id,
            'direccion'   => $dep->direccion?->nombre,
            'label'       => $dep->nombre . ($dep->direccion ? ' — ' . $dep->direccion->nombre : ''),
        ]);
    }

    public function destroy(Departamento $departamento)
    {
        if ($departamento->funcionarios()->count() > 0 || $departamento->equipos()->count() > 0) {
            return back()->with('error', 'No se puede eliminar este departamento porque tiene funcionarios o equipos asociados.');
        }

        $departamento->delete();

        return redirect()->route('departamentos.index')
            ->with('success', 'Departamento eliminado correctamente.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use Illuminate\Http\Request;

class DepartamentoController extends Controller
{
    public function index()
    {
        $departamentos = Departamento::withCount(['funcionarios', 'equipos'])
            ->orderBy('nombre')
            ->get();
        return view('departamentos.index', compact('departamentos'));
    }

    public function create()
    {
        return view('departamentos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'      => 'required|string|max:150|unique:departamentos,nombre',
            'descripcion' => 'nullable|string',
        ]);

        Departamento::create($validated);

        return redirect()->route('departamentos.index')
            ->with('success', 'Departamento creado correctamente.');
    }

    public function edit(Departamento $departamento)
    {
        return view('departamentos.edit', compact('departamento'));
    }

    public function update(Request $request, Departamento $departamento)
    {
        $validated = $request->validate([
            'nombre'      => 'required|string|max:150|unique:departamentos,nombre,' . $departamento->id,
            'descripcion' => 'nullable|string',
        ]);

        $departamento->update($validated);

        return redirect()->route('departamentos.index')
            ->with('success', 'Departamento actualizado correctamente.');
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

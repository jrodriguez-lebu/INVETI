<?php

namespace App\Http\Controllers;

use App\Models\Direccion;
use Illuminate\Http\Request;

class DireccionController extends Controller
{
    public function index()
    {
        $direcciones = Direccion::withCount('departamentos')
            ->with(['departamentos' => fn($q) => $q->orderBy('nombre')])
            ->orderBy('nombre')
            ->get();

        return view('direcciones.index', compact('direcciones'));
    }

    public function create()
    {
        return view('direcciones.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'      => 'required|string|max:150|unique:direcciones,nombre',
            'descripcion' => 'nullable|string',
        ], [
            'nombre.required' => 'El nombre de la dirección es obligatorio.',
            'nombre.unique'   => 'Ya existe una dirección con ese nombre.',
        ]);

        Direccion::create($validated);

        return redirect()->route('direcciones.index')
            ->with('success', 'Dirección creada correctamente.');
    }

    public function edit(Direccion $direccion)
    {
        $direccion->load(['departamentos' => fn($q) => $q->orderBy('nombre')]);
        return view('direcciones.edit', compact('direccion'));
    }

    public function update(Request $request, Direccion $direccion)
    {
        $validated = $request->validate([
            'nombre'      => 'required|string|max:150|unique:direcciones,nombre,' . $direccion->id,
            'descripcion' => 'nullable|string',
        ], [
            'nombre.required' => 'El nombre de la dirección es obligatorio.',
            'nombre.unique'   => 'Ya existe una dirección con ese nombre.',
        ]);

        $direccion->update($validated);

        return redirect()->route('direcciones.index')
            ->with('success', 'Dirección actualizada correctamente.');
    }

    public function destroy(Direccion $direccion)
    {
        if ($direccion->departamentos()->count() > 0) {
            return back()->with('error', 'No se puede eliminar esta dirección porque tiene departamentos asociados. Reasigna o elimina los departamentos primero.');
        }

        $direccion->delete();

        return redirect()->route('direcciones.index')
            ->with('success', 'Dirección eliminada correctamente.');
    }
}

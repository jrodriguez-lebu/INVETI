<?php

namespace App\Http\Controllers;

use App\Models\TipoEquipo;
use Illuminate\Http\Request;

class TipoEquipoController extends Controller
{
    public function index()
    {
        $tipos = TipoEquipo::withCount('equipos')->orderBy('nombre')->get();
        return view('tipos_equipo.index', compact('tipos'));
    }

    public function create()
    {
        return view('tipos_equipo.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'      => 'required|string|max:100|unique:tipos_equipo,nombre',
            'icono'       => 'nullable|string|max:50',
            'descripcion' => 'nullable|string',
        ]);

        TipoEquipo::create($validated);

        return redirect()->route('tipos-equipo.index')
            ->with('success', 'Tipo de equipo creado correctamente.');
    }

    public function edit(TipoEquipo $tiposEquipo)
    {
        return view('tipos_equipo.edit', ['tipo' => $tiposEquipo]);
    }

    public function update(Request $request, TipoEquipo $tiposEquipo)
    {
        $validated = $request->validate([
            'nombre'      => 'required|string|max:100|unique:tipos_equipo,nombre,' . $tiposEquipo->id,
            'icono'       => 'nullable|string|max:50',
            'descripcion' => 'nullable|string',
        ]);

        $tiposEquipo->update($validated);

        return redirect()->route('tipos-equipo.index')
            ->with('success', 'Tipo de equipo actualizado correctamente.');
    }

    public function destroy(TipoEquipo $tiposEquipo)
    {
        if ($tiposEquipo->equipos()->count() > 0) {
            return back()->with('error', 'No se puede eliminar este tipo porque tiene equipos asociados.');
        }

        $tiposEquipo->delete();

        return redirect()->route('tipos-equipo.index')
            ->with('success', 'Tipo de equipo eliminado correctamente.');
    }
}

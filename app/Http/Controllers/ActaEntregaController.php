<?php

namespace App\Http\Controllers;

use App\Models\ActaEntrega;
use App\Models\Equipo;
use App\Models\Funcionario;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ActaEntregaController extends Controller
{
    public function index(Request $request)
    {
        $query = ActaEntrega::with(['equipo.tipoEquipo', 'funcionario.departamento']);

        if ($request->filled('funcionario_id')) {
            $query->where('funcionario_id', $request->funcionario_id);
        }

        if ($request->filled('firmada')) {
            $query->where('firmada', $request->firmada);
        }

        if ($request->filled('fecha_desde')) {
            $query->where('fecha_entrega', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->where('fecha_entrega', '<=', $request->fecha_hasta);
        }

        $actas = $query->orderByDesc('created_at')->paginate(15)->withQueryString();
        $funcionarios = Funcionario::orderBy('apellido')->get();

        return view('actas.index', compact('actas', 'funcionarios'));
    }

    public function create(Request $request)
    {
        $equipos = Equipo::with('tipoEquipo')->orderBy('numero_inventario')->get();
        $funcionarios = Funcionario::where('activo', true)->orderBy('apellido')->orderBy('nombre')->get();

        $equipoSeleccionado = null;
        if ($request->filled('equipo_id')) {
            $equipoSeleccionado = Equipo::with(['tipoEquipo', 'funcionario'])->find($request->equipo_id);
        }

        return view('actas.create', compact('equipos', 'funcionarios', 'equipoSeleccionado'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'equipo_id'      => 'required|exists:equipos,id',
            'funcionario_id' => 'required|exists:funcionarios,id',
            'fecha_entrega'  => 'required|date',
            'observaciones'  => 'nullable|string',
            'firmada'        => 'boolean',
        ]);

        $validated['numero_acta'] = ActaEntrega::generarNumeroActa();
        $validated['firmada'] = $request->has('firmada');

        $acta = ActaEntrega::create($validated);

        // Update the equipo with the new responsible
        $equipo = Equipo::find($validated['equipo_id']);
        $equipo->update([
            'funcionario_id'  => $validated['funcionario_id'],
            'departamento_id' => Funcionario::find($validated['funcionario_id'])->departamento_id,
        ]);

        return redirect()->route('actas.show', $acta)
            ->with('success', 'Acta de entrega generada correctamente. N° ' . $validated['numero_acta']);
    }

    public function show(ActaEntrega $acta)
    {
        $acta->load(['equipo.tipoEquipo', 'funcionario.departamento']);
        return view('actas.show', compact('acta'));
    }

    public function edit(ActaEntrega $acta)
    {
        $equipos = Equipo::with('tipoEquipo')->orderBy('numero_inventario')->get();
        $funcionarios = Funcionario::where('activo', true)->orderBy('apellido')->orderBy('nombre')->get();
        return view('actas.edit', compact('acta', 'equipos', 'funcionarios'));
    }

    public function update(Request $request, ActaEntrega $acta)
    {
        $validated = $request->validate([
            'fecha_entrega'  => 'required|date',
            'observaciones'  => 'nullable|string',
            'firmada'        => 'boolean',
        ]);

        $validated['firmada'] = $request->has('firmada');

        $acta->update($validated);

        return redirect()->route('actas.show', $acta)
            ->with('success', 'Acta actualizada correctamente.');
    }

    public function destroy(ActaEntrega $acta)
    {
        $acta->delete();

        return redirect()->route('actas.index')
            ->with('success', 'Acta eliminada correctamente.');
    }

    public function pdf(ActaEntrega $acta)
    {
        $acta->load(['equipo.tipoEquipo', 'funcionario.departamento']);

        $pdf = Pdf::loadView('actas.pdf', compact('acta'))
            ->setPaper('letter', 'portrait');

        return $pdf->stream('acta-' . $acta->numero_acta . '.pdf');
    }
}

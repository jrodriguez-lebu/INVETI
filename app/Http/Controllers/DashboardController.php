<?php

namespace App\Http\Controllers;

use App\Models\ActaEntrega;
use App\Models\Equipo;
use App\Models\Funcionario;
use App\Models\TipoEquipo;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEquipos = Equipo::count();
        $activos      = Equipo::where('estado', 'activo')->count();
        $dadosDeBaja  = Equipo::where('estado', 'baja')->count();
        $inactivos    = Equipo::where('estado', 'inactivo')->count();

        $equiposPorTipo = TipoEquipo::withCount('equipos')
            ->orderByDesc('equipos_count')
            ->get()
            ->filter(fn($t) => $t->equipos_count > 0)
            ->values();

        $recentActas = ActaEntrega::with(['equipo.tipoEquipo', 'funcionario'])
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        $totalFuncionarios = Funcionario::where('activo', true)->count();

        $incompletos = Equipo::incompletos()->count();

        $equiposIncompletos = Equipo::incompletos()
            ->with(['tipoEquipo', 'funcionario', 'departamento'])
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        $porTipo = TipoEquipo::withCount('equipos')
            ->orderByDesc('equipos_count')
            ->get()
            ->filter(fn($t) => $t->equipos_count > 0)
            ->values();

        return view('dashboard.index', compact(
            'totalEquipos',
            'activos',
            'dadosDeBaja',
            'inactivos',
            'equiposPorTipo',
            'recentActas',
            'totalFuncionarios',
            'incompletos',
            'equiposIncompletos',
            'porTipo'
        ));
    }
}

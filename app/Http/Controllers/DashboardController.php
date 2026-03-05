<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\ParteDiario;
use App\Models\Profesor;
use App\Models\SeguimientoPractica;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function stats(Request $request)
    {
        // Contadores principales
        $totalEmpresas   = Empresa::where('activo', true)->count();
        $totalAlumnos    = User::where('role', 'alumno')->count();
        $totalProfesores = Profesor::count();
        $totalPartes     = ParteDiario::count();
        $totalSeguimientos = SeguimientoPractica::count();
        $partesPendientes  = ParteDiario::where('validado_tutor', false)
                                ->orWhere('validado_profesor', false)
                                ->count();

        // Seguimientos activos (en curso)
        $seguimientosActivos = SeguimientoPractica::where('estado', 'en_curso')
            ->orWhereNull('estado')
            ->count();

        // Últimas 5 prácticas creadas
        $ultimasPracticas = SeguimientoPractica::with(['alumno', 'empresa'])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get()
            ->map(fn ($s) => [
                'tipo'        => 'seguimiento',
                'descripcion' => 'Nueva práctica registrada: ' . ($s->titulo ?? 'Sin título'),
                'detalle'     => $s->alumno?->name ?? 'Alumno desconocido',
                'empresa'     => $s->empresa?->nombre ?? '',
                'fecha'       => $s->created_at,
            ]);

        // Últimos 5 partes diarios
        $ultimosPartes = ParteDiario::with(['seguimientoPractica.alumno'])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get()
            ->map(fn ($p) => [
                'tipo'        => 'parte',
                'descripcion' => 'Parte diario completado',
                'detalle'     => $p->seguimientoPractica?->alumno?->name ?? 'Alumno desconocido',
                'empresa'     => '',
                'fecha'       => $p->created_at,
            ]);

        // Mezclar y ordenar por fecha descendente, tomar 6
        $actividad = $ultimasPracticas->concat($ultimosPartes)
            ->sortByDesc('fecha')
            ->take(6)
            ->values();

        return response()->json([
            'totales' => [
                'empresas'            => $totalEmpresas,
                'alumnos'             => $totalAlumnos,
                'profesores'          => $totalProfesores,
                'partes'              => $totalPartes,
                'seguimientos'        => $totalSeguimientos,
                'seguimientos_activos'=> $seguimientosActivos,
                'partes_pendientes'   => $partesPendientes,
            ],
            'actividad_reciente' => $actividad,
        ]);
    }
}

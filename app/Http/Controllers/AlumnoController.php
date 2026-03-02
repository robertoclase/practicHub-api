<?php

namespace App\Http\Controllers;

use App\Models\ParteDiario;
use App\Models\SeguimientoPractica;
use App\Models\Valoracion;
use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    /**
     * Obtiene las prácticas del alumno autenticado
     */
    public function misPracticas(Request $request)
    {
        $seguimientos = SeguimientoPractica::with([
            'empresa',
            'profesor.user',
            'cursoAcademico',
            'partesDiarios',
            'valoraciones'
        ])
        ->where('user_id', $request->user()->id)
        ->orderBy('fecha_inicio', 'desc')
        ->get();

        return response()->json($seguimientos);
    }

    /**
     * Obtiene un seguimiento específico del alumno
     */
    public function detallePractica(Request $request, $id)
    {
        $seguimiento = SeguimientoPractica::with([
            'empresa',
            'profesor.user',
            'cursoAcademico',
            'partesDiarios',
            'valoraciones.profesor.user'
        ])
        ->where('user_id', $request->user()->id)
        ->findOrFail($id);

        return response()->json($seguimiento);
    }

    /**
     * Obtiene los partes diarios del alumno
     */
    public function misPartesDiarios(Request $request)
    {
        $partes = ParteDiario::with('seguimientoPractica.empresa')
            ->whereHas('seguimientoPractica', function ($query) use ($request) {
                $query->where('user_id', $request->user()->id);
            })
            ->orderBy('fecha', 'desc')
            ->get();

        return response()->json($partes);
    }

    /**
     * Obtiene partes diarios de una práctica específica
     */
    public function partesPorPractica(Request $request, $seguimientoId)
    {
        // Verificar que el seguimiento pertenece al alumno
        $seguimiento = SeguimientoPractica::where('user_id', $request->user()->id)
            ->findOrFail($seguimientoId);

        $partes = ParteDiario::where('seguimiento_practica_id', $seguimientoId)
            ->orderBy('fecha', 'desc')
            ->get();

        return response()->json($partes);
    }

    /**
     * Obtiene valoraciones del alumno
     */
    public function misValoraciones(Request $request)
    {
        $valoraciones = Valoracion::with([
            'seguimientoPractica.empresa',
            'profesor.user'
        ])
        ->whereHas('seguimientoPractica', function ($query) use ($request) {
            $query->where('user_id', $request->user()->id);
        })
        ->orderBy('created_at', 'desc')
        ->get();

        return response()->json($valoraciones);
    }
}

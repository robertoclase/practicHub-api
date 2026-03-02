<?php

namespace App\Http\Controllers;

use App\Models\ParteDiario;
use App\Models\SeguimientoPractica;
use App\Models\Valoracion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfesorAuthController extends Controller
{
    /**
     * Obtiene los seguimientos asignados al profesor autenticado
     */
    public function misSeguimientos(Request $request)
    {
        $profesor = $request->user()->profesor;
        
        if (!$profesor) {
            return response()->json([
                'message' => 'Usuario no tiene perfil de profesor'
            ], 404);
        }

        $seguimientos = SeguimientoPractica::with([
            'empresa',
            'alumno:id,name,email',
            'cursoAcademico',
            'partesDiarios',
            'valoraciones'
        ])
        ->where('profesor_id', $profesor->id)
        ->orderBy('fecha_inicio', 'desc')
        ->get();

        return response()->json($seguimientos);
    }

    /**
     * Obtiene partes pendientes de validar por el profesor
     */
    public function partesPendientes(Request $request)
    {
        $profesor = $request->user()->profesor;
        
        if (!$profesor) {
            return response()->json([
                'message' => 'Usuario no tiene perfil de profesor'
            ], 404);
        }

        $partes = ParteDiario::with([
            'seguimientoPractica.empresa',
            'seguimientoPractica.alumno:id,name,email'
        ])
        ->whereHas('seguimientoPractica', function ($query) use ($profesor) {
            $query->where('profesor_id', $profesor->id);
        })
        ->where('validado_profesor', false)
        ->orderBy('fecha', 'desc')
        ->get();

        return response()->json($partes);
    }

    /**
     * Valida un parte diario (profesor)
     */
    public function validarParte(Request $request, $parteId)
    {
        $profesor = $request->user()->profesor;
        
        if (!$profesor) {
            return response()->json([
                'message' => 'Usuario no tiene perfil de profesor'
            ], 404);
        }

        $parte = ParteDiario::with('seguimientoPractica')
            ->findOrFail($parteId);

        // Verificar que el parte corresponde a un seguimiento del profesor
        if ($parte->seguimientoPractica->profesor_id !== $profesor->id) {
            return response()->json([
                'message' => 'No tienes autorización para validar este parte'
            ], 403);
        }

        $parte->validado_profesor = true;
        $parte->save();

        return response()->json([
            'message' => 'Parte validado correctamente',
            'parte' => $parte
        ]);
    }

    /**
     * Crea una valoración para un seguimiento
     */
    public function crearValoracion(Request $request)
    {
        $profesor = $request->user()->profesor;
        
        if (!$profesor) {
            return response()->json([
                'message' => 'Usuario no tiene perfil de profesor'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'seguimiento_practica_id' => 'required|exists:seguimiento_practicas,id',
            'puntuacion' => 'required|integer|min:1|max:10',
            'aspecto_valorado' => 'required|string|max:255',
            'comentarios' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Verificar que el seguimiento pertenece al profesor
        $seguimiento = SeguimientoPractica::findOrFail($request->seguimiento_practica_id);
        if ($seguimiento->profesor_id !== $profesor->id) {
            return response()->json([
                'message' => 'No tienes autorización para valorar este seguimiento'
            ], 403);
        }

        $valoracion = Valoracion::create([
            'seguimiento_practica_id' => $request->seguimiento_practica_id,
            'profesor_id' => $profesor->id,
            'puntuacion' => $request->puntuacion,
            'aspecto_valorado' => $request->aspecto_valorado,
            'comentarios' => $request->comentarios,
        ]);

        return response()->json([
            'message' => 'Valoración creada correctamente',
            'valoracion' => $valoracion->load('seguimientoPractica')
        ], 201);
    }

    /**
     * Obtiene alumnos asignados al profesor
     */
    public function misAlumnos(Request $request)
    {
        $profesor = $request->user()->profesor;
        
        if (!$profesor) {
            return response()->json([
                'message' => 'Usuario no tiene perfil de profesor'
            ], 404);
        }

        $seguimientos = SeguimientoPractica::with([
            'alumno:id,name,email',
            'empresa:id,nombre',
            'cursoAcademico'
        ])
        ->where('profesor_id', $profesor->id)
        ->where('estado', 'activa')
        ->get();

        // Agrupar por alumno
        $alumnos = $seguimientos->groupBy('user_id')->map(function ($practicas, $userId) {
            $alumno = $practicas->first()->alumno;
            return [
                'id' => $alumno->id,
                'name' => $alumno->name,
                'email' => $alumno->email,
                'practicas_activas' => $practicas->count(),
                'empresas' => $practicas->pluck('empresa.nombre')->unique()->values(),
            ];
        })->values();

        return response()->json($alumnos);
    }
}

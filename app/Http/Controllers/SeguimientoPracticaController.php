<?php

namespace App\Http\Controllers;

use App\Models\SeguimientoPractica;
use Illuminate\Http\Request;

class SeguimientoPracticaController extends Controller
{
    public function index(Request $request)
    {
        $seguimientos = SeguimientoPractica::query()
            ->with(['empresa', 'profesor', 'cursoAcademico', 'alumno'])
            ->when($request->filled('estado'), fn ($q) => $q->where('estado', $request->estado))
            ->orderByDesc('id')
            ->paginate($request->integer('per_page', 15));

        return response()->json($seguimientos);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'empresa_id' => ['required', 'exists:empresas,id'],
            'profesor_id' => ['required', 'exists:profesors,id'],
            'curso_academico_id' => ['required', 'exists:curso_academicos,id'],
            'user_id' => ['required', 'exists:users,id'],
            'titulo' => ['required', 'string', 'max:200'],
            'descripcion' => ['nullable', 'string'],
            'fecha_inicio' => ['required', 'date'],
            'fecha_fin' => ['required', 'date', 'after_or_equal:fecha_inicio'],
            'horas_totales' => ['required', 'integer', 'min:1'],
            'estado' => ['nullable', 'string', 'max:50'],
            'objetivos' => ['nullable', 'string'],
            'actividades' => ['nullable', 'string'],
        ]);

        $seguimiento = SeguimientoPractica::create($validated);

        return response()->json($seguimiento, 201);
    }

    public function show(SeguimientoPractica $seguimientoPractica)
    {
        return response()->json($seguimientoPractica->load(['empresa', 'profesor.user', 'cursoAcademico', 'alumno', 'partesDiarios', 'valoraciones']));
    }

    public function update(Request $request, SeguimientoPractica $seguimientoPractica)
    {
        $validated = $request->validate([
            'empresa_id' => ['sometimes', 'exists:empresas,id'],
            'profesor_id' => ['sometimes', 'exists:profesors,id'],
            'curso_academico_id' => ['sometimes', 'exists:curso_academicos,id'],
            'user_id' => ['sometimes', 'exists:users,id'],
            'titulo' => ['sometimes', 'string', 'max:200'],
            'descripcion' => ['nullable', 'string'],
            'fecha_inicio' => ['sometimes', 'date'],
            'fecha_fin' => ['sometimes', 'date', 'after_or_equal:fecha_inicio'],
            'horas_totales' => ['sometimes', 'integer', 'min:1'],
            'estado' => ['sometimes', 'string', 'max:50'],
            'objetivos' => ['nullable', 'string'],
            'actividades' => ['nullable', 'string'],
        ]);

        $seguimientoPractica->update($validated);

        return response()->json($seguimientoPractica);
    }

    public function destroy(SeguimientoPractica $seguimientoPractica)
    {
        $seguimientoPractica->delete();

        return response()->noContent();
    }
}

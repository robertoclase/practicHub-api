<?php

namespace App\Http\Controllers;

use App\Models\CursoAcademico;
use Illuminate\Http\Request;

class CursoAcademicoController extends Controller
{
    public function index(Request $request)
    {
        $cursos = CursoAcademico::query()
            ->when($request->boolean('only_active'), fn ($q) => $q->where('activo', true))
            ->orderByDesc('fecha_inicio')
            ->paginate($request->integer('per_page', 15));

        return response()->json($cursos);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'fecha_inicio' => ['required', 'date'],
            'fecha_fin' => ['required', 'date', 'after_or_equal:fecha_inicio'],
            'activo' => ['boolean'],
        ]);

        $curso = CursoAcademico::create($validated);

        return response()->json($curso, 201);
    }

    public function show(CursoAcademico $cursoAcademico)
    {
        return response()->json($cursoAcademico);
    }

    public function update(Request $request, CursoAcademico $cursoAcademico)
    {
        $validated = $request->validate([
            'nombre' => ['sometimes', 'string', 'max:100'],
            'fecha_inicio' => ['sometimes', 'date'],
            'fecha_fin' => ['sometimes', 'date', 'after_or_equal:fecha_inicio'],
            'activo' => ['sometimes', 'boolean'],
        ]);

        $cursoAcademico->update($validated);

        return response()->json($cursoAcademico);
    }

    public function destroy(CursoAcademico $cursoAcademico)
    {
        $cursoAcademico->delete();

        return response()->noContent();
    }
}

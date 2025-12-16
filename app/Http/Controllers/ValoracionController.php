<?php

namespace App\Http\Controllers;

use App\Models\Valoracion;
use Illuminate\Http\Request;

class ValoracionController extends Controller
{
    public function index(Request $request)
    {
        $valoraciones = Valoracion::query()
            ->with(['seguimientoPractica', 'profesor'])
            ->when($request->filled('seguimiento_practica_id'), fn ($q) => $q->where('seguimiento_practica_id', $request->seguimiento_practica_id))
            ->orderByDesc('id')
            ->paginate($request->integer('per_page', 15));

        return response()->json($valoraciones);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'seguimiento_practica_id' => ['required', 'exists:seguimiento_practicas,id'],
            'profesor_id' => ['required', 'exists:profesors,id'],
            'puntuacion' => ['required', 'integer', 'between:1,10'],
            'comentarios' => ['required', 'string'],
            'aspecto_valorado' => ['required', 'string', 'max:100'],
        ]);

        $valoracion = Valoracion::create($validated);

        return response()->json($valoracion, 201);
    }

    public function show(Valoracion $valoracion)
    {
        return response()->json($valoracion->load(['seguimientoPractica', 'profesor']));
    }

    public function update(Request $request, Valoracion $valoracion)
    {
        $validated = $request->validate([
            'seguimiento_practica_id' => ['sometimes', 'exists:seguimiento_practicas,id'],
            'profesor_id' => ['sometimes', 'exists:profesors,id'],
            'puntuacion' => ['sometimes', 'integer', 'between:1,10'],
            'comentarios' => ['sometimes', 'string'],
            'aspecto_valorado' => ['sometimes', 'string', 'max:100'],
        ]);

        $valoracion->update($validated);

        return response()->json($valoracion);
    }

    public function destroy(Valoracion $valoracion)
    {
        $valoracion->delete();

        return response()->noContent();
    }
}

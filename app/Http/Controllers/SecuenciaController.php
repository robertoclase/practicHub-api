<?php

namespace App\Http\Controllers;

use App\Models\Secuencia;
use Illuminate\Http\Request;

class SecuenciaController extends Controller
{
    public function index(Request $request)
    {
        $secuencias = Secuencia::query()
            ->when($request->boolean('only_active'), fn ($q) => $q->where('activo', true))
            ->orderByDesc('id')
            ->paginate($request->integer('per_page', 15));

        return response()->json($secuencias);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => ['required', 'string', 'max:200'],
            'descripcion' => ['nullable', 'string'],
            'activo' => ['boolean'],
        ]);

        $secuencia = Secuencia::create($validated);

        return response()->json($secuencia, 201);
    }

    public function show(Secuencia $secuencia)
    {
        return response()->json($secuencia);
    }

    public function update(Request $request, Secuencia $secuencia)
    {
        $validated = $request->validate([
            'titulo' => ['sometimes', 'string', 'max:200'],
            'descripcion' => ['nullable', 'string'],
            'activo' => ['sometimes', 'boolean'],
        ]);

        $secuencia->update($validated);

        return response()->json($secuencia);
    }

    public function destroy(Secuencia $secuencia)
    {
        $secuencia->delete();

        return response()->noContent();
    }
}

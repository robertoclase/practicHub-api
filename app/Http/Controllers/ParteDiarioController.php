<?php

namespace App\Http\Controllers;

use App\Models\ParteDiario;
use Illuminate\Http\Request;

class ParteDiarioController extends Controller
{
    public function index(Request $request)
    {
        $partes = ParteDiario::query()
            ->with('seguimientoPractica')
            ->when($request->filled('seguimiento_practica_id'), fn ($q) => $q->where('seguimiento_practica_id', $request->seguimiento_practica_id))
            ->orderByDesc('fecha')
            ->paginate($request->integer('per_page', 15));

        return response()->json($partes);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'seguimiento_practica_id' => ['required', 'exists:seguimiento_practicas,id'],
            'fecha' => ['required', 'date'],
            'horas_realizadas' => ['required', 'integer', 'min:1'],
            'actividades_realizadas' => ['required', 'string'],
            'observaciones' => ['nullable', 'string'],
            'dificultades' => ['nullable', 'string'],
            'soluciones_propuestas' => ['nullable', 'string'],
            'validado_tutor' => ['boolean'],
            'validado_profesor' => ['boolean'],
        ]);

        $parte = ParteDiario::create($validated);

        return response()->json($parte, 201);
    }

    public function show(ParteDiario $parteDiario)
    {
        return response()->json($parteDiario->load('seguimientoPractica'));
    }

    public function update(Request $request, ParteDiario $parteDiario)
    {
        $validated = $request->validate([
            'seguimiento_practica_id' => ['sometimes', 'exists:seguimiento_practicas,id'],
            'fecha' => ['sometimes', 'date'],
            'horas_realizadas' => ['sometimes', 'integer', 'min:1'],
            'actividades_realizadas' => ['sometimes', 'string'],
            'observaciones' => ['nullable', 'string'],
            'dificultades' => ['nullable', 'string'],
            'soluciones_propuestas' => ['nullable', 'string'],
            'validado_tutor' => ['sometimes', 'boolean'],
            'validado_profesor' => ['sometimes', 'boolean'],
        ]);

        $parteDiario->update($validated);

        return response()->json($parteDiario);
    }

    public function destroy(ParteDiario $parteDiario)
    {
        $parteDiario->delete();

        return response()->noContent();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Profesor;
use Illuminate\Http\Request;

class ProfesorController extends Controller
{
    public function index(Request $request)
    {
        $profesores = Profesor::query()
            ->with('user')
            ->when($request->boolean('only_active'), fn ($q) => $q->where('activo', true))
            ->orderByDesc('id')
            ->paginate($request->integer('per_page', 15));

        return response()->json($profesores);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'dni' => ['required', 'string', 'max:20', 'unique:profesors,dni'],
            'departamento' => ['required', 'string', 'max:100'],
            'especialidad' => ['required', 'string', 'max:100'],
            'telefono' => ['required', 'string', 'max:20'],
            'activo' => ['boolean'],
        ]);

        $profesor = Profesor::create($validated);

        return response()->json($profesor, 201);
    }

    public function show(Profesor $profesor)
    {
        return response()->json($profesor->load('user'));
    }

    public function update(Request $request, Profesor $profesor)
    {
        $validated = $request->validate([
            'user_id' => ['sometimes', 'exists:users,id'],
            'dni' => ['sometimes', 'string', 'max:20', 'unique:profesors,dni,' . $profesor->id],
            'departamento' => ['sometimes', 'string', 'max:100'],
            'especialidad' => ['sometimes', 'string', 'max:100'],
            'telefono' => ['sometimes', 'string', 'max:20'],
            'activo' => ['sometimes', 'boolean'],
        ]);

        $profesor->update($validated);

        return response()->json($profesor);
    }

    public function destroy(Profesor $profesor)
    {
        $profesor->delete();

        return response()->noContent();
    }
}

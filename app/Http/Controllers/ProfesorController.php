<?php

namespace App\Http\Controllers;

use App\Models\Profesor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

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
            'name'        => ['required', 'string', 'max:255'],
            'email'       => ['required', 'email', 'max:255', 'unique:users,email'],
            'password'    => ['required', 'string', 'min:6'],
            'dni'         => ['required', 'string', 'max:20', 'unique:profesors,dni'],
            'departamento'=> ['required', 'string', 'max:100'],
            'especialidad'=> ['required', 'string', 'max:100'],
            'telefono'    => ['required', 'string', 'max:20'],
            'activo'      => ['boolean'],
        ]);

        $profesor = DB::transaction(function () use ($validated) {
            $user = User::create([
                'name'     => $validated['name'],
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role'     => 'profesor',
            ]);

            return Profesor::create([
                'user_id'      => $user->id,
                'dni'          => $validated['dni'],
                'departamento' => $validated['departamento'],
                'especialidad' => $validated['especialidad'],
                'telefono'     => $validated['telefono'],
                'activo'       => $validated['activo'] ?? true,
            ]);
        });

        return response()->json($profesor->load('user'), 201);
    }

    public function show(Profesor $profesor)
    {
        return response()->json($profesor->load('user'));
    }

    public function update(Request $request, Profesor $profesor)
    {
        $validated = $request->validate([
            'name'        => ['sometimes', 'string', 'max:255'],
            'email'       => ['sometimes', 'email', 'max:255', 'unique:users,email,' . $profesor->user_id],
            'password'    => ['sometimes', 'string', 'min:6'],
            'dni'         => ['sometimes', 'string', 'max:20', 'unique:profesors,dni,' . $profesor->id],
            'departamento'=> ['sometimes', 'string', 'max:100'],
            'especialidad'=> ['sometimes', 'string', 'max:100'],
            'telefono'    => ['sometimes', 'string', 'max:20'],
            'activo'      => ['sometimes', 'boolean'],
        ]);

        DB::transaction(function () use ($validated, $profesor) {
            // Update linked user fields if provided
            $userFields = array_filter([
                'name'     => $validated['name'] ?? null,
                'email'    => $validated['email'] ?? null,
                'password' => isset($validated['password']) ? Hash::make($validated['password']) : null,
            ]);

            if (!empty($userFields) && $profesor->user) {
                $profesor->user->update($userFields);
            }

            // Update profesor-specific fields
            $profesorFields = array_intersect_key($validated, array_flip(['dni', 'departamento', 'especialidad', 'telefono', 'activo']));
            if (!empty($profesorFields)) {
                $profesor->update($profesorFields);
            }
        });

        return response()->json($profesor->fresh()->load('user'));
    }

    public function destroy(Profesor $profesor)
    {
        DB::transaction(function () use ($profesor) {
            $userId = $profesor->user_id;
            $profesor->delete();
            User::destroy($userId);
        });

        return response()->noContent();
    }
}


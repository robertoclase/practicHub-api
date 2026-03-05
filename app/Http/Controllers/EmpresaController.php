<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmpresaController extends Controller
{
    public function index(Request $request)
    {
        $empresas = Empresa::query()
            ->when($request->boolean('only_active'), fn ($q) => $q->where('activo', true))
            ->when($request->filled('search'), function ($q) use ($request) {
                $term = '%' . $request->input('search') . '%';
                $q->where(function ($q) use ($term) {
                    $q->where('nombre', 'like', $term)
                      ->orWhere('cif', 'like', $term)
                      ->orWhere('sector', 'like', $term)
                      ->orWhere('tutor_empresa', 'like', $term)
                      ->orWhere('email', 'like', $term);
                });
            })
            ->orderByDesc('id')
            ->paginate($request->integer('per_page', 15));

        return response()->json($empresas);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:200'],
            'cif' => ['required', 'string', 'max:20', 'unique:empresas,cif'],
            'direccion' => ['required', 'string', 'max:255'],
            'telefono' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:100'],
            'sector' => ['required', 'string', 'max:100'],
            'tutor_empresa' => ['required', 'string', 'max:200'],
            'email_tutor' => ['required', 'email', 'max:100'],
            'activo' => ['boolean'],
            'foto_perfil' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        if ($request->hasFile('foto_perfil')) {
            $path = $request->file('foto_perfil')->store('empresas', 'public');
            $validated['foto_perfil'] = Storage::url($path);
        }

        $empresa = Empresa::create($validated);

        return response()->json($empresa, 201);
    }

    public function show(Empresa $empresa)
    {
        return response()->json($empresa);
    }

    public function update(Request $request, Empresa $empresa)
    {
        $validated = $request->validate([
            'nombre' => ['sometimes', 'string', 'max:200'],
            'cif' => ['sometimes', 'string', 'max:20', 'unique:empresas,cif,' . $empresa->id],
            'direccion' => ['sometimes', 'string', 'max:255'],
            'telefono' => ['sometimes', 'string', 'max:20'],
            'email' => ['sometimes', 'email', 'max:100'],
            'sector' => ['sometimes', 'string', 'max:100'],
            'tutor_empresa' => ['sometimes', 'string', 'max:200'],
            'email_tutor' => ['sometimes', 'email', 'max:100'],
            'activo' => ['sometimes', 'boolean'],
            'foto_perfil' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        if ($request->hasFile('foto_perfil')) {
            // Delete old file if exists
            if ($empresa->foto_perfil) {
                $oldPath = str_replace('/storage/', '', $empresa->foto_perfil);
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('foto_perfil')->store('empresas', 'public');
            $validated['foto_perfil'] = Storage::url($path);
        }

        $empresa->update($validated);

        return response()->json($empresa);
    }

    public function destroy(Empresa $empresa)
    {
        // Delete associated file
        if ($empresa->foto_perfil) {
            $oldPath = str_replace('/storage/', '', $empresa->foto_perfil);
            Storage::disk('public')->delete($oldPath);
        }
        $empresa->delete();

        return response()->noContent();
    }
}

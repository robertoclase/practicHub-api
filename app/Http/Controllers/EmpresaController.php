<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    public function index(Request $request)
    {
        $empresas = Empresa::query()
            ->when($request->boolean('only_active'), fn ($q) => $q->where('activo', true))
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
        ]);

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
        ]);

        $empresa->update($validated);

        return response()->json($empresa);
    }

    public function destroy(Empresa $empresa)
    {
        $empresa->delete();

        return response()->noContent();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\ParteDiario;
use App\Models\SeguimientoPractica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class EmpresaAuthController extends Controller
{
    /**
     * Login de empresa (endpoint separado)
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $empresa = Empresa::where('email', $request->email)->first();

        if (!$empresa || !Hash::check($request->password, $empresa->password)) {
            return response()->json([
                'message' => 'Credenciales no válidas'
            ], 422);
        }

        if (!$empresa->activo) {
            return response()->json([
                'message' => 'Empresa inactiva. Contacte con el administrador.'
            ], 403);
        }

        $token = $empresa->createToken('api')->plainTextToken;

        return response()->json([
            'token' => $token,
            'empresa' => $empresa,
            'role' => 'empresa',
        ]);
    }

    /**
     * Obtiene alumnos en práctica en la empresa
     */
    public function misAlumnos(Request $request)
    {
        $empresa = $request->user(); // La empresa autenticada

        $seguimientos = SeguimientoPractica::with([
            'alumno:id,name,email',
            'profesor.user:id,name,email',
            'cursoAcademico',
            'partesDiarios'
        ])
        ->where('empresa_id', $empresa->id)
        ->orderBy('fecha_inicio', 'desc')
        ->get();

        return response()->json($seguimientos);
    }

    /**
     * Obtiene partes pendientes de validar por la empresa
     */
    public function partesPendientes(Request $request)
    {
        $empresa = $request->user();

        $partes = ParteDiario::with([
            'seguimientoPractica.alumno:id,name,email',
            'seguimientoPractica.profesor.user:id,name'
        ])
        ->whereHas('seguimientoPractica', function ($query) use ($empresa) {
            $query->where('empresa_id', $empresa->id);
        })
        ->where('validado_tutor', false)
        ->orderBy('fecha', 'desc')
        ->get();

        return response()->json($partes);
    }

    /**
     * Valida un parte diario (tutor empresa)
     */
    public function validarParte(Request $request, $parteId)
    {
        $empresa = $request->user();

        $parte = ParteDiario::with('seguimientoPractica')
            ->findOrFail($parteId);

        // Verificar que el parte corresponde a un seguimiento de la empresa
        if ($parte->seguimientoPractica->empresa_id !== $empresa->id) {
            return response()->json([
                'message' => 'No tienes autorización para validar este parte'
            ], 403);
        }

        $parte->validado_tutor = true;
        $parte->save();

        return response()->json([
            'message' => 'Parte validado correctamente',
            'parte' => $parte
        ]);
    }

    /**
     * Obtiene detalles de un seguimiento de la empresa
     */
    public function detalleSeguimiento(Request $request, $id)
    {
        $empresa = $request->user();

        $seguimiento = SeguimientoPractica::with([
            'alumno:id,name,email',
            'profesor.user:id,name,email',
            'cursoAcademico',
            'partesDiarios',
            'valoraciones.profesor.user'
        ])
        ->where('empresa_id', $empresa->id)
        ->findOrFail($id);

        return response()->json($seguimiento);
    }
}

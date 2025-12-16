<?php
require __DIR__ . '/auth.php';

use App\Http\Controllers\SecuenciaController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\CursoAcademicoController;
use App\Http\Controllers\SeguimientoPracticaController;
use App\Http\Controllers\ParteDiarioController;
use App\Http\Controllers\ValoracionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('secuencias', SecuenciaController::class);
    Route::apiResource('empresas', EmpresaController::class);
    Route::apiResource('profesores', ProfesorController::class);
    Route::apiResource('cursos-academicos', CursoAcademicoController::class);
    Route::apiResource('seguimientos', SeguimientoPracticaController::class);
    Route::apiResource('partes-diarios', ParteDiarioController::class);
    Route::apiResource('valoraciones', ValoracionController::class);
});

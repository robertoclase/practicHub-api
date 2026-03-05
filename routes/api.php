<?php
require __DIR__ . '/auth.php';

use App\Http\Controllers\SecuenciaController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\CursoAcademicoController;
use App\Http\Controllers\SeguimientoPracticaController;
use App\Http\Controllers\ParteDiarioController;
use App\Http\Controllers\ValoracionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\ProfesorAuthController;
use App\Http\Controllers\EmpresaAuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Endpoint público para login de empresas
Route::post('/empresa/login', [EmpresaAuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    $user = $request->user();
    $userData = $user->toArray();
    
    // Si es profesor, incluir datos de profesor
    if ($user instanceof \App\Models\User && $user->isProfesor() && $user->profesor) {
        $userData['profesor_id'] = $user->profesor->id;
    }
    
    return $userData;
});

// Rutas públicas para buscar empresas (alumnos interesados)
Route::get('/empresas/listado', [EmpresaController::class, 'index']);

// Rutas protegidas generales (admin)
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('dashboard/stats', [DashboardController::class, 'stats']);
    Route::apiResource('profesores', ProfesorController::class);
    Route::apiResource('secuencias', SecuenciaController::class);
    Route::apiResource('empresas', EmpresaController::class);
    Route::apiResource('cursos-academicos', CursoAcademicoController::class);
    Route::apiResource('seguimientos', SeguimientoPracticaController::class);
    Route::apiResource('partes-diarios', ParteDiarioController::class);
    Route::apiResource('valoraciones', ValoracionController::class);
    Route::apiResource('users', UserController::class);
});

// Rutas específicas para ALUMNOS
Route::middleware(['auth:sanctum'])->prefix('alumno')->group(function () {
    Route::get('/mis-practicas', [AlumnoController::class, 'misPracticas']);
    Route::get('/mis-practicas/{id}', [AlumnoController::class, 'detallePractica']);
    Route::get('/mis-partes', [AlumnoController::class, 'misPartesDiarios']);
    Route::post('/mis-partes', [AlumnoController::class, 'crearParte']);
    Route::get('/practicas/{id}/partes', [AlumnoController::class, 'partesPorPractica']);
    Route::get('/mis-valoraciones', [AlumnoController::class, 'misValoraciones']);
});

// Rutas específicas para PROFESORES
Route::middleware(['auth:sanctum'])->prefix('profesor')->group(function () {
    Route::get('/mis-seguimientos', [ProfesorAuthController::class, 'misSeguimientos']);
    Route::get('/mis-alumnos', [ProfesorAuthController::class, 'misAlumnos']);
    Route::get('/partes-pendientes', [ProfesorAuthController::class, 'partesPendientes']);
    Route::put('/partes/{id}/validar', [ProfesorAuthController::class, 'validarParte']);
    Route::post('/valoraciones', [ProfesorAuthController::class, 'crearValoracion']);
});

// Rutas específicas para EMPRESAS
Route::middleware(['auth:sanctum'])->prefix('empresa')->group(function () {
    Route::get('/mis-alumnos', [EmpresaAuthController::class, 'misAlumnos']);
    Route::get('/seguimientos/{id}', [EmpresaAuthController::class, 'detalleSeguimiento']);
    Route::get('/partes-pendientes', [EmpresaAuthController::class, 'partesPendientes']);
    Route::put('/partes/{id}/validar', [EmpresaAuthController::class, 'validarParte']);
});


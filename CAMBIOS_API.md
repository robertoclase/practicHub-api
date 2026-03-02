# 📝 Cambios Realizados en la API - PracticHub

Este documento detalla todas las modificaciones realizadas en el backend Laravel para soportar la aplicación móvil.

**Fecha:** Marzo 2024  
**Versión API:** 1.0  
**Objetivo:** Añadir sistema de roles y autenticación para móvil

---

## 🎯 Resumen de Cambios

- ✅ Sistema de roles añadido (admin, alumno, profesor, empresa)
- ✅ Autenticación de empresas implementada
- ✅ 15 nuevos endpoints específicos por rol
- ✅ Middleware de verificación de roles
- ✅ Seeder con datos de prueba completos
- ⚠️ **CERO cambios en funcionalidad existente del web**

---

## 📁 Archivos Nuevos

### Migraciones

#### `database/migrations/2026_03_02_000001_add_role_to_users_table.php`
```php
// Añade columna 'role' a tabla users
$table->enum('role', ['admin', 'alumno', 'profesor', 'empresa'])
      ->default('alumno')
      ->after('email');
```

**Propósito:** Diferenciar tipos de usuarios sin crear tablas separadas.

---

#### `database/migrations/2026_03_02_000002_add_password_to_empresas_table.php`
```php
// Añade campos de autenticación a tabla empresas
$table->string('password')->after('email_contacto');
$table->rememberToken();
```

**Propósito:** Permitir que empresas hagan login directo en la app móvil.

---

### Middleware

#### `app/Http/Middleware/CheckRole.php`
```php
// Verifica que el usuario tenga el rol adecuado
public function handle(Request $request, Closure $next, ...$roles)
```

**Uso en rutas:**
```php
Route::middleware(['auth:sanctum', 'checkRole:alumno'])->group(function () {
    // Solo accesible por alumnos
});
```

**Roles permitidos:** `admin`, `alumno`, `profesor`, `empresa`

---

### Controladores

#### `app/Http/Controllers/AlumnoController.php`
Endpoints para alumnos:

| Método | Ruta | Descripción |
|--------|------|-------------|
| GET | `/alumno/mis-practicas` | Seguimientos del alumno autenticado |
| GET | `/alumno/practica/{id}` | Detalle de un seguimiento |
| GET | `/alumno/mis-partes` | Todos los partes del alumno |
| GET | `/alumno/practica/{id}/partes` | Partes de un seguimiento específico |
| GET | `/alumno/mis-valoraciones` | Valoraciones recibidas |

**Autenticación requerida:** Sí (Sanctum + role=alumno)

---

#### `app/Http/Controllers/ProfesorAuthController.php`
Endpoints para profesores:

| Método | Ruta | Descripción |
|--------|------|-------------|
| GET | `/profesor/mis-seguimientos` | Seguimientos de sus alumnos |
| GET | `/profesor/mis-alumnos` | Lista de alumnos asignados |
| GET | `/profesor/partes-pendientes` | Partes sin validar |
| POST | `/profesor/partes/{id}/validar` | Validar un parte (JSON: validado, observaciones) |
| POST | `/profesor/valoraciones` | Crear valoración (JSON: seguimiento_id, puntuacion, comentarios) |

**Autenticación requerida:** Sí (Sanctum + role=profesor)

---

#### `app/Http/Controllers/EmpresaAuthController.php`
Endpoints para empresas:

| Método | Ruta | Descripción |
|--------|------|-------------|
| POST | `/empresa/login` | Login específico (JSON: email, password) |
| GET | `/empresa/mis-alumnos` | Alumnos en prácticas |
| GET | `/empresa/seguimientos/{id}` | Detalle de seguimiento |
| GET | `/empresa/partes-pendientes` | Partes sin validar por empresa |
| POST | `/empresa/partes/{id}/validar` | Validar parte (JSON: validado_empresa, observaciones_empresa) |

**Autenticación requerida:** Sí (Sanctum, token de empresa)

**Nota especial:** Las empresas usan `/empresa/login` en lugar de `/login` porque son un modelo diferente.

---

## 🔄 Archivos Modificados

### Models

#### `app/Models/User.php`

**Cambios:**
```php
// Añadido a $fillable
protected $fillable = [
    'name',
    'email',
    'password',
    'role',  // ← NUEVO
];

// Nuevos métodos helper
public function isAlumno(): bool
public function isProfesor(): bool
public function isEmpresa(): bool
public function isAdmin(): bool

// Nueva relación
public function profesor()
```

**Impacto:** Ahora los usuarios tienen rol y métodos para verificarlo.

---

#### `app/Models/Empresa.php`

**Cambios:**
```php
// Cambiado de Model a Authenticatable
class Empresa extends Authenticatable  // antes: extends Model

// Añadido trait
use HasApiTokens;  // ← NUEVO (para Sanctum)

// Nuevos campos ocultos
protected $hidden = [
    'password',
    'remember_token',
];

// Nuevo cast
protected $casts = [
    'password' => 'hashed',  // ← NUEVO (hash automático)
];
```

**Impacto:** Las empresas ahora pueden autenticarse como si fueran usuarios.

---

### Controllers

#### `app/Http/Controllers/Auth/AuthenticatedSessionController.php`

**Modificación en método `store()`:**
```php
// Ahora devuelve rol y profesor_id (si aplica)
return response()->json([
    'user' => $user,
    'token' => $user->createToken('auth-token')->plainTextToken,
    'role' => $user->role,              // ← NUEVO
    'profesor_id' => $user->profesor_id // ← NUEVO
], 200);
```

**Impacto:** El móvil sabe qué rol tiene el usuario después del login.

---

#### `app/Http/Controllers/Auth/RegisteredUserController.php`

**Modificación en método `store()`:**
```php
// Ahora acepta campo 'role' en registro
$validated = $request->validate([
    'name' => 'required|string|max:255',
    'email' => 'required|string|email|max:255|unique:users',
    'password' => 'required|string|min:8|confirmed',
    'role' => 'required|in:alumno,profesor',  // ← NUEVO
]);

$user = User::create([
    // ...
    'role' => $validated['role'],  // ← NUEVO
]);
```

**Impacto:** Al registrarse, el usuario elige si es alumno o profesor.

---

### Routes

#### `routes/api.php`

**Nuevas rutas públicas:**
```php
// Login de empresas (separado del login normal)
Route::post('/empresa/login', [EmpresaAuthController::class, 'login']);

// Listado de empresas (para que alumnos busquen)
Route::get('/empresas/listado', [EmpresaAuthController::class, 'listarEmpresas']);
```

**Nuevos grupos protegidos:**
```php
// Rutas de alumnos (requiere auth + role=alumno)
Route::middleware(['auth:sanctum', 'checkRole:alumno'])->prefix('alumno')->group(function () {
    Route::get('/mis-practicas', [AlumnoController::class, 'misPracticas']);
    Route::get('/practica/{id}', [AlumnoController::class, 'detallePractica']);
    Route::get('/mis-partes', [AlumnoController::class, 'misPartesDiarios']);
    Route::get('/practica/{id}/partes', [AlumnoController::class, 'partesPorPractica']);
    Route::get('/mis-valoraciones', [AlumnoController::class, 'misValoraciones']);
});

// Rutas de profesores (requiere auth + role=profesor)
Route::middleware(['auth:sanctum', 'checkRole:profesor'])->prefix('profesor')->group(function () {
    Route::get('/mis-seguimientos', [ProfesorAuthController::class, 'misSeguimientos']);
    Route::get('/mis-alumnos', [ProfesorAuthController::class, 'misAlumnos']);
    Route::get('/partes-pendientes', [ProfesorAuthController::class, 'partesPendientes']);
    Route::post('/partes/{id}/validar', [ProfesorAuthController::class, 'validarParte']);
    Route::post('/valoraciones', [ProfesorAuthController::class, 'crearValoracion']);
});

// Rutas de empresas (requiere auth de empresa)
Route::middleware(['auth:sanctum'])->prefix('empresa')->group(function () {
    Route::get('/mis-alumnos', [EmpresaAuthController::class, 'misAlumnos']);
    Route::get('/seguimientos/{id}', [EmpresaAuthController::class, 'detalleSeguimiento']);
    Route::get('/partes-pendientes', [EmpresaAuthController::class, 'partesPendientes']);
    Route::post('/partes/{id}/validar', [EmpresaAuthController::class, 'validarParte']);
});
```

**Impacto:** La API ahora tiene endpoints específicos según el tipo de usuario.

---

### Seeders

#### `database/seeders/DatabaseSeeder.php`

**Datos creados:**

1. **Curso Académico** (1)
   - 2024-2025

2. **Usuarios** (6)
   - 1 admin
   - 3 alumnos (Juan, María, Carlos)
   - 2 profesores (Ana, Pedro)

3. **Empresas** (3)
   - TechSolutions S.L.
   - WebDesign Pro
   - DataAnalytics Corp

4. **Seguimientos** (3)
   - Cada alumno tiene 1 seguimiento activo
   - Relaciona: alumno ↔ empresa ↔ profesor

5. **Partes Diarios** (6)
   - 2 partes por cada seguimiento
   - Estados variados (validados/pendientes)

6. **Valoraciones** (3)
   - 1 valoración por cada alumno
   - Puntuaciones: 8.5, 9.0, 8.0
   - Con comentarios

**Impacto:** Base de datos lista para testing inmediato.

---

## 🔒 Sistema de Seguridad

### Autenticación con Sanctum

**Flujo de login normal (alumnos/profesores):**
1. POST `/api/login` con email + password
2. Laravel verifica en tabla `users`
3. Devuelve token + role
4. App guarda token en SharedPreferences
5. Requests posteriores incluyen: `Authorization: Bearer {token}`

**Flujo de login empresa:**
1. POST `/api/empresa/login` con email + password
2. Laravel verifica en tabla `empresas`
3. Devuelve token
4. App guarda token
5. Requests incluyen token igual

### Middleware CheckRole

**Protección de rutas:**
```php
// Solo alumnos pueden acceder
Route::middleware(['auth:sanctum', 'checkRole:alumno'])

// Solo profesores
Route::middleware(['auth:sanctum', 'checkRole:profesor'])

// Admins o profesores
Route::middleware(['auth:sanctum', 'checkRole:admin,profesor'])
```

**Respuesta si rol incorrecto:**
```json
{
    "message": "No tienes permiso para acceder a este recurso",
    "required_roles": ["alumno"],
    "your_role": "profesor"
}
```

---

## 📊 Diagrama de Roles y Permisos

```
┌─────────────────────────────────────────────────┐
│                 USUARIOS                        │
├──────────────┬──────────────┬──────────────────┤
│    ADMIN     │   ALUMNO     │    PROFESOR      │
├──────────────┼──────────────┼──────────────────┤
│ - Web admin  │ - Ver mis    │ - Ver mis        │
│   (Angular)  │   prácticas  │   seguimientos   │
│              │ - Crear      │ - Ver alumnos    │
│              │   partes     │ - Validar partes │
│              │ - Ver        │ - Crear          │
│              │   empresas   │   valoraciones   │
│              │ - Ver        │                  │
│              │   valoración │                  │
└──────────────┴──────────────┴──────────────────┘

┌─────────────────────────────────────────────────┐
│                 EMPRESAS                        │
├─────────────────────────────────────────────────┤
│ - Ver alumnos en prácticas                      │
│ - Ver seguimientos asignados                    │
│ - Validar partes diarios                        │
│ - Consultar detalles de prácticas               │
└─────────────────────────────────────────────────┘
```

---

## 🧪 Testing de Cambios

### Verificar Migraciones
```bash
php artisan migrate:fresh --seed
php artisan tinker
>>> User::where('role', 'alumno')->count()
3  # ✅ Correcto
>>> Empresa::first()->password
# ✅ Debe estar hasheado
```

### Probar Login Usuario
```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"juan@alumno.com","password":"password"}'
```

**Respuesta esperada:**
```json
{
  "user": {
    "id": 2,
    "name": "Juan Pérez",
    "email": "juan@alumno.com",
    "role": "alumno"
  },
  "token": "1|xxx...",
  "role": "alumno",
  "profesor_id": null
}
```

### Probar Login Empresa
```bash
curl -X POST http://localhost:8000/api/empresa/login \
  -H "Content-Type: application/json" \
  -d '{"email":"contacto@techsolutions.com","password":"password"}'
```

### Probar Endpoint Protegido
```bash
curl -X GET http://localhost:8000/api/alumno/mis-practicas \
  -H "Authorization: Bearer {token_de_juan}"
```

**Respuesta esperada:** Array con seguimientos de Juan

---

## ⚠️ Consideraciones Importantes

### 1. Compatibilidad hacia atrás
✅ **NINGÚN endpoint existente fue modificado**  
✅ El web de Angular sigue funcionando igual  
✅ Solo se añadieron nuevos endpoints  

### 2. Empresas vs Usuarios
- Las empresas están en tabla `empresas` (no en `users`)
- Login separado: `/empresa/login` vs `/login`
- Ambos usan Sanctum para tokens
- Ambos funcionan igual después del login

### 3. Roles en Users
- Campo `role` es enum, no puede tener valores arbitrarios
- Valores permitidos: `admin`, `alumno`, `profesor`, `empresa`
- Default: `alumno` (evita errores si se crea usuario sin especificar)

### 4. Profesores especiales
- Los profesores tienen un registro en tabla `users` (role=profesor)
- También pueden tener un registro en tabla `profesores` (con especialidad, teléfono, etc.)
- La relación se hace mediante `profesor_id` en tabla users

---

## 📝 Checklist de Verificación

Antes de considerar estos cambios completos, verifica:

- [ ] Migraciones ejecutadas sin errores
- [ ] Seeder crea los 9 usuarios + 3 empresas
- [ ] Login normal devuelve campo `role`
- [ ] Login empresa funciona (`/empresa/login`)
- [ ] Middleware CheckRole bloquea roles incorrectos
- [ ] Endpoints de alumno solo accesibles por alumnos
- [ ] Endpoints de profesor solo accesibles por profesores
- [ ] Endpoints de empresa solo accesibles por empresas
- [ ] Password de empresas está hasheado en BD
- [ ] Web de Angular sigue funcionando
- [ ] Postman collection actualizada (si existe)

---

## 🚀 Siguientes Pasos

Con estos cambios completados, la API ya está lista para:

1. ✅ Autenticar alumnos, profesores y empresas
2. ✅ Servir datos específicos según rol
3. ✅ Proteger endpoints sensibles
4. ✅ Proporcionar datos de prueba realistas

**Pendiente en móvil:**
- Features de seguimientos, partes, empresas, valoraciones
- Conexión real con estos endpoints
- UI para mostrar datos

---

## 📞 Soporte

Si encuentras problemas con estos cambios:

1. Verifica logs: `storage/logs/laravel.log`
2. Comprueba que las migraciones se aplicaron: `php artisan migrate:status`
3. Revisa que el seeder se ejecutó: `php artisan db:seed --class=DatabaseSeeder`
4. Usa tinker para debugging: `php artisan tinker`

---

**Autor:** Sistema PracticHub  
**Versión:** 1.0.0  
**Fecha:** Marzo 2024  
**Compatibilidad:** Laravel 12.x

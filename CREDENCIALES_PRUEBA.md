# 🔐 Credenciales de Prueba - PracticHub API

Este archivo contiene todas las credenciales de los usuarios creados por el seeder.

## 🎯 Uso

Después de ejecutar `php artisan migrate:fresh --seed`, podrás usar estas credenciales para hacer login en la aplicación móvil.

---

## 👨‍💼 Administrador

| Campo | Valor |
|-------|-------|
| Email | admin@practichub.com |
| Password | password |
| Rol | admin |
| Nombre | Admin PracticHub |

**Acceso:** Solo desde interfaz web (Angular)

---

## 👨‍🎓 Alumnos

### Alumno 1 - Juan Pérez
| Campo | Valor |
|-------|-------|
| Email | juan@alumno.com |
| Password | password |
| Rol | alumno |
| Nombre | Juan Pérez |

**Datos asociados:**
- Práctica en: TechSolutions S.L.
- Profesor tutor: Ana García
- Seguimiento ID: 1
- Partes diarios: 2 (1 validado por empresa, 1 pendiente)
- Valoración: 8.5/10

---

### Alumno 2 - María López
| Campo | Valor |
|-------|-------|
| Email | maria@alumno.com |
| Password | password |
| Rol | alumno |
| Nombre | María López |

**Datos asociados:**
- Práctica en: WebDesign Pro
- Profesor tutor: Ana García
- Seguimiento ID: 2
- Partes diarios: 2 (1 validado por empresa, 1 pendiente)
- Valoración: 9.0/10

---

### Alumno 3 - Carlos Ruiz
| Campo | Valor |
|-------|-------|
| Email | carlos@alumno.com |
| Password | password |
| Rol | alumno |
| Nombre | Carlos Ruiz |

**Datos asociados:**
- Práctica en: DataAnalytics Corp
- Profesor tutor: Pedro Martínez
- Seguimiento ID: 3
- Partes diarios: 2 (1 validado por empresa, 1 pendiente)
- Valoración: 8.0/10

---

## 👨‍🏫 Profesores

### Profesor 1 - Ana García
| Campo | Valor |
|-------|-------|
| Email | ana@profesor.com |
| Password | password |
| Rol | profesor |
| Nombre | Ana García |
| Profesor ID | 1 |

**Alumnos asignados:**
- Juan Pérez (TechSolutions)
- María López (WebDesign Pro)

**Responsabilidades:**
- 2 seguimientos activos
- 4 partes diarios pendientes de validar
- 2 valoraciones creadas

---

### Profesor 2 - Pedro Martínez
| Campo | Valor |
|-------|-------|
| Email | pedro@profesor.com |
| Password | password |
| Rol | profesor |
| Nombre | Pedro Martínez |
| Profesor ID | 2 |

**Alumnos asignados:**
- Carlos Ruiz (DataAnalytics)

**Responsabilidades:**
- 1 seguimiento activo
- 2 partes diarios pendientes de validar
- 1 valoración creada

---

## 🏢 Empresas

### Empresa 1 - TechSolutions S.L.
| Campo | Valor |
|-------|-------|
| Email | contacto@techsolutions.com |
| Password | password |
| Nombre | TechSolutions S.L. |
| Empresa ID | 1 |
| CIF | B12345678 |
| Teléfono | 912345678 |
| Dirección | Calle Mayor 1, Madrid |

**Alumnos en prácticas:**
- Juan Pérez (desde 2024-09-15 hasta 2025-06-15)

**Responsable:** Laura Sánchez (laura@techsolutions.com, 912345679)

---

### Empresa 2 - WebDesign Pro
| Campo | Valor |
|-------|-------|
| Email | info@webdesign.com |
| Password | password |
| Nombre | WebDesign Pro |
| Empresa ID | 2 |
| CIF | B87654321 |
| Teléfono | 913456789 |
| Dirección | Avenida de la Constitución 25, Barcelona |

**Alumnos en prácticas:**
- María López (desde 2024-09-15 hasta 2025-06-15)

**Responsable:** Miguel Torres (miguel@webdesign.com, 913456790)

---

### Empresa 3 - DataAnalytics Corp
| Campo | Valor |
|-------|-------|
| Email | contacto@dataanalytics.com |
| Password | password |
| Nombre | DataAnalytics Corp |
| Empresa ID | 3 |
| CIF | B11223344 |
| Teléfono | 914567890 |
| Dirección | Plaza España 10, Valencia |

**Alumnos en prácticas:**
- Carlos Ruiz (desde 2024-09-15 hasta 2025-06-15)

**Responsable:** Carmen Díaz (carmen@dataanalytics.com, 914567891)

---

## 📊 Datos Relacionados Creados

### Curso Académico
- **Nombre:** 2024-2025
- **Inicio:** 2024-09-01
- **Fin:** 2025-06-30

### Seguimientos de Prácticas (3)
1. Juan Pérez → TechSolutions → Profesor Ana García
2. María López → WebDesign Pro → Profesor Ana García
3. Carlos Ruiz → DataAnalytics → Profesor Pedro Martínez

### Partes Diarios (6 total)
- 2 partes por cada alumno
- Estado: 1 validado por empresa, 1 pendiente por alumno
- Fechas: desde fecha inicio de prácticas

### Valoraciones (3 total)
- Juan: 8.5 puntos
- María: 9.0 puntos
- Carlos: 8.0 puntos
- Todas con comentarios del profesor

---

## 🔄 Resetear Datos

Para volver a generar todos los datos:

```bash
php artisan migrate:fresh --seed
```

⚠️ **Advertencia:** Esto eliminará TODOS los datos de la base de datos y los volverá a crear.

---

## 🧪 Tests Recomendados

### Test 1: Login Alumno
1. Usar: `juan@alumno.com` / `password`
2. Verificar que se muestra Dashboard de alumno
3. Verificar que aparece rol "alumno"

### Test 2: Login Profesor
1. Usar: `ana@profesor.com` / `password`
2. Verificar Dashboard de profesor
3. Verificar acceso a "Mis Alumnos"

### Test 3: Login Empresa
1. **Importante:** Seleccionar "Empresa" en login
2. Usar: `contacto@techsolutions.com` / `password`
3. Verificar Dashboard de empresa
4. Verificar que muestra nombre de empresa

### Test 4: Datos Relacionados
1. Login como Juan (`juan@alumno.com`)
2. Verificar que aparece:
   - Práctica en TechSolutions
   - 2 partes diarios
   - 1 valoración de Ana García

### Test 5: Registro Nuevo Usuario
1. Crear cuenta con email único
2. Seleccionar rol (alumno o profesor)
3. Verificar que se puede hacer login después

---

## 📝 Notas

- Todos los passwords son **`password`** para facilitar las pruebas
- Los IDs son secuenciales (1, 2, 3...)
- Las fechas de prácticas son del curso actual 2024-2025
- Los CIF de empresas son ficticios
- Las valoraciones tienen comentarios de ejemplo

---

## 🆘 Soporte

Si alguna credencial no funciona:

1. Verifica que ejecutaste el seeder: `php artisan migrate:fresh --seed`
2. Comprueba la tabla users: `php artisan tinker` → `User::all()`
3. Comprueba empresas: `Empresa::all()`
4. Revisa logs de Laravel en `storage/logs/laravel.log`

---

**Última actualización:** Marzo 2024  
**Versión:** 1.0  
**Propósito:** Testing y desarrollo

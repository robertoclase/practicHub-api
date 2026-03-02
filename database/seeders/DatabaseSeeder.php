<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Empresa;
use App\Models\Profesor;
use App\Models\CursoAcademico;
use App\Models\SeguimientoPractica;
use App\Models\ParteDiario;
use App\Models\Valoracion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        $admin = User::create([
            'name' => 'Admin PracticHub',
            'email' => 'admin@practichub.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Alumnos
        $alumno1 = User::create([
            'name' => 'Juan García López',
            'email' => 'juan@alumno.com',
            'password' => Hash::make('password'),
            'role' => 'alumno',
        ]);

        $alumno2 = User::create([
            'name' => 'María Pérez González',
            'email' => 'maria@alumno.com',
            'password' => Hash::make('password'),
            'role' => 'alumno',
        ]);

        $alumno3 = User::create([
            'name' => 'Carlos Rodríguez Martín',
            'email' => 'carlos@alumno.com',
            'password' => Hash::make('password'),
            'role' => 'alumno',
        ]);

        // Usuarios para profesores
        $userProfe1 = User::create([
            'name' => 'Ana Martínez Sánchez',
            'email' => 'ana@profesor.com',
            'password' => Hash::make('password'),
            'role' => 'profesor',
        ]);

        $userProfe2 = User::create([
            'name' => 'Pedro López Fernández',
            'email' => 'pedro@profesor.com',
            'password' => Hash::make('password'),
            'role' => 'profesor',
        ]);

        // Profesores
        $profesor1 = Profesor::create([
            'user_id' => $userProfe1->id,
            'dni' => '12345678A',
            'departamento' => 'Informática',
            'especialidad' => 'Desarrollo de Aplicaciones Multiplataforma',
            'telefono' => '600111222',
            'activo' => true,
        ]);

        $profesor2 = Profesor::create([
            'user_id' => $userProfe2->id,
            'dni' => '87654321B',
            'departamento' => 'Informática',
            'especialidad' => 'Desarrollo de Aplicaciones Web',
            'telefono' => '600333444',
            'activo' => true,
        ]);

        // Empresas (con password para autenticación)
        $empresa1 = Empresa::create([
            'nombre' => 'TechSolutions S.L.',
            'cif' => 'B12345678',
            'direccion' => 'Calle Mayor 123, Madrid',
            'telefono' => '911234567',
            'email' => 'contacto@techsolutions.com',
            'password' => Hash::make('password'),
            'sector' => 'Desarrollo de Software',
            'tutor_empresa' => 'Roberto Gómez',
            'email_tutor' => 'roberto@techsolutions.com',
            'activo' => true,
        ]);

        $empresa2 = Empresa::create([
            'nombre' => 'WebDesign Studio',
            'cif' => 'B87654321',
            'direccion' => 'Avenida Libertad 45, Barcelona',
            'telefono' => '932345678',
            'email' => 'info@webdesign.com',
            'password' => Hash::make('password'),
            'sector' => 'Diseño Web y Marketing Digital',
            'tutor_empresa' => 'Laura Martín',
            'email_tutor' => 'laura@webdesign.com',
            'activo' => true,
        ]);

        $empresa3 = Empresa::create([
            'nombre' => 'DataAnalytics Corp',
            'cif' => 'B11223344',
            'direccion' => 'Plaza España 8, Valencia',
            'telefono' => '963456789',
            'email' => 'contacto@dataanalytics.com',
            'password' => Hash::make('password'),
            'sector' => 'Análisis de Datos',
            'tutor_empresa' => 'Miguel Ángel Torres',
            'email_tutor' => 'miguel@dataanalytics.com',
            'activo' => true,
        ]);

        // Curso Académico
        $curso = CursoAcademico::create([
            'nombre' => '2025/2026',
            'fecha_inicio' => '2025-09-01',
            'fecha_fin' => '2026-06-30',
            'activo' => true,
        ]);

        // Seguimientos de Prácticas
        $seg1 = SeguimientoPractica::create([
            'empresa_id' => $empresa1->id,
            'profesor_id' => $profesor1->id,
            'curso_academico_id' => $curso->id,
            'user_id' => $alumno1->id,
            'titulo' => 'Desarrollo de Aplicación Web',
            'descripcion' => 'Desarrollo de una aplicación web completa con React y Laravel',
            'fecha_inicio' => '2026-01-15',
            'fecha_fin' => '2026-05-30',
            'horas_totales' => 400,
            'estado' => 'activa',
            'objetivos' => 'Aprender desarrollo full-stack, trabajar en equipo, aplicar metodologías ágiles',
            'actividades' => 'Desarrollo frontend, backend, testing, despliegue',
        ]);

        $seg2 = SeguimientoPractica::create([
            'empresa_id' => $empresa2->id,
            'profesor_id' => $profesor1->id,
            'curso_academico_id' => $curso->id,
            'user_id' => $alumno2->id,
            'titulo' => 'Diseño UI/UX y Desarrollo Frontend',
            'descripcion' => 'Diseño y desarrollo de interfaces de usuario modernas',
            'fecha_inicio' => '2026-01-20',
            'fecha_fin' => '2026-05-25',
            'horas_totales' => 380,
            'estado' => 'activa',
            'objetivos' => 'Dominar herramientas de diseño, aprender frameworks modernos',
            'actividades' => 'Diseño en Figma, desarrollo con Angular, responsive design',
        ]);

        $seg3 = SeguimientoPractica::create([
            'empresa_id' => $empresa3->id,
            'profesor_id' => $profesor2->id,
            'curso_academico_id' => $curso->id,
            'user_id' => $alumno3->id,
            'titulo' => 'Análisis de Datos con Python',
            'descripcion' => 'Análisis y visualización de datos empresariales',
            'fecha_inicio' => '2026-02-01',
            'fecha_fin' => '2026-06-15',
            'horas_totales' => 420,
            'estado' => 'activa',
            'objetivos' => 'Aprender Python, pandas, machine learning básico',
            'actividades' => 'Análisis estadístico, visualización de datos, predicciones',
        ]);

        // Partes Diarios
        // Para Juan en TechSolutions
        ParteDiario::create([
            'seguimiento_practica_id' => $seg1->id,
            'fecha' => '2026-02-10',
            'horas_realizadas' => 8,
            'actividades_realizadas' => 'Configuración del entorno de desarrollo. Instalación de Laravel y React. Creación del proyecto base.',
            'observaciones' => 'Primera toma de contacto con el equipo',
            'dificultades' => 'Problemas con la configuración de CORS',
            'soluciones_propuestas' => 'Consultar documentación oficial de Laravel',
            'validado_tutor' => true,
            'validado_profesor' => true,
        ]);

        ParteDiario::create([
            'seguimiento_practica_id' => $seg1->id,
            'fecha' => '2026-02-11',
            'horas_realizadas' => 8,
            'actividades_realizadas' => 'Desarrollo de la API REST. Creación de modelos y controladores para usuarios.',
            'observaciones' => 'Buen avance en el backend',
            'dificultades' => 'Validación de datos complejos',
            'soluciones_propuestas' => 'Uso de Form Requests en Laravel',
            'validado_tutor' => true,
            'validado_profesor' => false,
        ]);

        ParteDiario::create([
            'seguimiento_practica_id' => $seg1->id,
            'fecha' => '2026-02-12',
            'horas_realizadas' => 8,
            'actividades_realizadas' => 'Implementación de autenticación con Sanctum. Creación de middleware.',
            'observaciones' => 'Sistema de auth funcionando correctamente',
            'dificultades' => 'Ninguna',
            'soluciones_propuestas' => '',
            'validado_tutor' => false,
            'validado_profesor' => false,
        ]);

        // Para María en WebDesign
        ParteDiario::create([
            'seguimiento_practica_id' => $seg2->id,
            'fecha' => '2026-02-10',
            'horas_realizadas' => 7,
            'actividades_realizadas' => 'Diseño de wireframes en Figma para la landing page de cliente.',
            'observaciones' => 'Cliente satisfecho con propuestas',
            'dificultades' => 'Dudas sobre paleta de colores',
            'soluciones_propuestas' => 'Reunión con diseñador senior',
            'validado_tutor' => true,
            'validado_profesor' => true,
        ]);

        ParteDiario::create([
            'seguimiento_practica_id' => $seg2->id,
            'fecha' => '2026-02-11',
            'horas_realizadas' => 8,
            'actividades_realizadas' => 'Desarrollo del componente de navegación en Angular. Implementación de rutas.',
            'observaciones' => 'Aprendiendo mucho de Angular',
            'dificultades' => 'Manejo de observables',
            'soluciones_propuestas' => 'Estudio de RxJS',
            'validado_tutor' => false,
            'validado_profesor' => false,
        ]);

        // Para Carlos en DataAnalytics
        ParteDiario::create([
            'seguimiento_practica_id' => $seg3->id,
            'fecha' => '2026-02-15',
            'horas_realizadas' => 8,
            'actividades_realizadas' => 'Análisis exploratorio de datos de ventas. Limpieza de datos con pandas.',
            'observaciones' => 'Dataset muy interesante',
            'dificultades' => 'Datos faltantes en muchas columnas',
            'soluciones_propuestas' => 'Imputación con valores promedio',
            'validado_tutor' => true,
            'validado_profesor' => false,
        ]);

        // Valoraciones
        Valoracion::create([
            'seguimiento_practica_id' => $seg1->id,
            'profesor_id' => $profesor1->id,
            'puntuacion' => 9,
            'aspecto_valorado' => 'Capacidad técnica',
            'comentarios' => 'Excelente dominio de Laravel. Muestra gran capacidad de aprendizaje y resolución de problemas.',
        ]);

        Valoracion::create([
            'seguimiento_practica_id' => $seg1->id,
            'profesor_id' => $profesor1->id,
            'puntuacion' => 8,
            'aspecto_valorado' => 'Actitud y trabajo en equipo',
            'comentarios' => 'Muy buena integración con el equipo. Siempre dispuesto a ayudar.',
        ]);

        Valoracion::create([
            'seguimiento_practica_id' => $seg2->id,
            'profesor_id' => $profesor1->id,
            'puntuacion' => 9,
            'aspecto_valorado' => 'Creatividad y diseño',
            'comentarios' => 'Diseños muy creativos y modernos. Gran ojo para la estética.',
        ]);

        echo "✅ Datos de prueba creados exitosamente\n";
        echo "------------------------------------------------\n";
        echo "Admin: admin@practichub.com / password\n";
        echo "Alumnos:\n";
        echo "  - juan@alumno.com / password\n";
        echo "  - maria@alumno.com / password\n";
        echo "  - carlos@alumno.com / password\n";
        echo "Profesores:\n";
        echo "  - ana@profesor.com / password\n";
        echo "  - pedro@profesor.com / password\n";
        echo "Empresas:\n";
        echo "  - contacto@techsolutions.com / password\n";
        echo "  - info@webdesign.com / password\n";
        echo "  - contacto@dataanalytics.com / password\n";
        echo "------------------------------------------------\n";
    }
}


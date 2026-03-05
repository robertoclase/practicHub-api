<?php

namespace Database\Seeders;

use App\Models\CursoAcademico;
use App\Models\Empresa;
use App\Models\ParteDiario;
use App\Models\Profesor;
use App\Models\SeguimientoPractica;
use App\Models\User;
use App\Models\Valoracion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // ─────────────────────────────────────────
        // ADMIN
        // ─────────────────────────────────────────
        User::create([
            'name'     => 'Admin PracticHub',
            'email'    => 'admin@practichub.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        // ─────────────────────────────────────────
        // CURSOS ACADÉMICOS
        // ─────────────────────────────────────────
        $cursoAnterior = CursoAcademico::create([
            'nombre'       => '2024/2025',
            'fecha_inicio' => '2024-09-01',
            'fecha_fin'    => '2025-06-30',
            'activo'       => false,
        ]);

        $curso = CursoAcademico::create([
            'nombre'       => '2025/2026',
            'fecha_inicio' => '2025-09-01',
            'fecha_fin'    => '2026-06-30',
            'activo'       => true,
        ]);

        // ─────────────────────────────────────────
        // PROFESORES (usuario + perfil)
        // ─────────────────────────────────────────
        $uProfe1 = User::create(['name' => 'Ana Martínez Sánchez',   'email' => 'ana.martinez@iestech.es',   'password' => Hash::make('password'), 'role' => 'profesor']);
        $uProfe2 = User::create(['name' => 'Pedro López Fernández',  'email' => 'pedro.lopez@iestech.es',   'password' => Hash::make('password'), 'role' => 'profesor']);
        $uProfe3 = User::create(['name' => 'Sofía Ruiz Delgado',     'email' => 'sofia.ruiz@iestech.es',    'password' => Hash::make('password'), 'role' => 'profesor']);
        $uProfe4 = User::create(['name' => 'Javier Moreno Castro',   'email' => 'javier.moreno@iestech.es', 'password' => Hash::make('password'), 'role' => 'profesor']);

        $p1 = Profesor::create(['user_id' => $uProfe1->id, 'dni' => '12345678A', 'departamento' => 'Informática', 'especialidad' => 'Desarrollo de Aplicaciones Multiplataforma', 'telefono' => '600111222', 'activo' => true]);
        $p2 = Profesor::create(['user_id' => $uProfe2->id, 'dni' => '87654321B', 'departamento' => 'Informática', 'especialidad' => 'Desarrollo de Aplicaciones Web',             'telefono' => '600333444', 'activo' => true]);
        $p3 = Profesor::create(['user_id' => $uProfe3->id, 'dni' => '11223344C', 'departamento' => 'Informática', 'especialidad' => 'Sistemas Microinformáticos y Redes',          'telefono' => '600555666', 'activo' => true]);
        $p4 = Profesor::create(['user_id' => $uProfe4->id, 'dni' => '44332211D', 'departamento' => 'Informática', 'especialidad' => 'Ciberseguridad',                              'telefono' => '600777888', 'activo' => true]);

        // ─────────────────────────────────────────
        // EMPRESAS
        // ─────────────────────────────────────────
        $e1  = Empresa::create(['nombre' => 'TechSolutions S.L.',   'cif' => 'B12345678', 'direccion' => 'Calle Gran Vía 55, Madrid',          'telefono' => '911234567', 'email' => 'contacto@techsolutions.com', 'password' => Hash::make('password'), 'sector' => 'Desarrollo de Software',             'tutor_empresa' => 'Roberto Gómez',       'email_tutor' => 'roberto@techsolutions.com', 'activo' => true]);
        $e2  = Empresa::create(['nombre' => 'WebDesign Studio',     'cif' => 'B87654321', 'direccion' => 'Paseo de Gracia 24, Barcelona',     'telefono' => '932345678', 'email' => 'info@webdesignstudio.com',  'password' => Hash::make('password'), 'sector' => 'Diseño Web y Marketing Digital',     'tutor_empresa' => 'Laura Martín',        'email_tutor' => 'laura@webdesignstudio.com', 'activo' => true]);
        $e3  = Empresa::create(['nombre' => 'DataAnalytics Corp',   'cif' => 'B11223344', 'direccion' => 'Avenida del Puerto 8, Valencia',    'telefono' => '963456789', 'email' => 'info@dataanalytics.es',     'password' => Hash::make('password'), 'sector' => 'Análisis de Datos e IA',             'tutor_empresa' => 'Miguel Ángel Torres', 'email_tutor' => 'miguel@dataanalytics.es',   'activo' => true]);
        $e4  = Empresa::create(['nombre' => 'CloudSystems Iberia',  'cif' => 'B22334455', 'direccion' => 'Calle Sierpes 12, Sevilla',         'telefono' => '954567890', 'email' => 'hola@cloudsystems.es',      'password' => Hash::make('password'), 'sector' => 'Infraestructura Cloud',              'tutor_empresa' => 'Carmen Vega',         'email_tutor' => 'carmen@cloudsystems.es',    'activo' => true]);
        $e5  = Empresa::create(['nombre' => 'CyberShield S.A.',     'cif' => 'A33445566', 'direccion' => 'Calle San Fermín 3, Pamplona',      'telefono' => '948678901', 'email' => 'security@cybershield.es',   'password' => Hash::make('password'), 'sector' => 'Ciberseguridad',                     'tutor_empresa' => 'Alejandro Ibáñez',    'email_tutor' => 'alejandro@cybershield.es',  'activo' => true]);
        $e6  = Empresa::create(['nombre' => 'MobileFirst Apps',     'cif' => 'B44556677', 'direccion' => 'Avenida Diagonal 180, Barcelona',  'telefono' => '933456789', 'email' => 'dev@mobilefirst.io',         'password' => Hash::make('password'), 'sector' => 'Desarrollo de Aplicaciones Móviles', 'tutor_empresa' => 'Isabel Serrano',      'email_tutor' => 'isabel@mobilefirst.io',     'activo' => true]);
        $e7  = Empresa::create(['nombre' => 'Innovatech Solutions', 'cif' => 'B55667788', 'direccion' => 'Calle Colón 30, Valencia',          'telefono' => '964567890', 'email' => 'contacto@innovatech.es',    'password' => Hash::make('password'), 'sector' => 'Consultoría Informática',            'tutor_empresa' => 'Daniel Ramos',        'email_tutor' => 'daniel@innovatech.es',      'activo' => true]);
        $e8  = Empresa::create(['nombre' => 'EduSoft Plataformas',  'cif' => 'B66778899', 'direccion' => 'Calle Alcalá 200, Madrid',          'telefono' => '915678901', 'email' => 'soporte@edusoft.es',         'password' => Hash::make('password'), 'sector' => 'Software Educativo',                 'tutor_empresa' => 'Patricia Lozano',     'email_tutor' => 'patricia@edusoft.es',       'activo' => true]);
        $e9  = Empresa::create(['nombre' => 'FinTech Nexus Spain',  'cif' => 'A77889900', 'direccion' => 'Paseo Castellana 95, Madrid',       'telefono' => '916789012', 'email' => 'info@fintechnexus.es',       'password' => Hash::make('password'), 'sector' => 'Tecnología Financiera',              'tutor_empresa' => 'Marcos Herrera',      'email_tutor' => 'marcos@fintechnexus.es',    'activo' => true]);
        $e10 = Empresa::create(['nombre' => 'GreenCode Startup',    'cif' => 'B88990011', 'direccion' => 'Calle Industria 7, Bilbao',         'telefono' => '944890123', 'email' => 'hola@greencode.io',          'password' => Hash::make('password'), 'sector' => 'Desarrollo Sostenible y Software',   'tutor_empresa' => 'Nuria Expósito',      'email_tutor' => 'nuria@greencode.io',        'activo' => true]);

        // ─────────────────────────────────────────
        // ALUMNOS (12 alumnos – ciclos DAM y DAW)
        // ─────────────────────────────────────────
        $alumnos = collect([
            ['name' => 'Juan García López',         'email' => 'juan.garcia@alumno.com'],
            ['name' => 'María Pérez González',      'email' => 'maria.perez@alumno.com'],
            ['name' => 'Carlos Rodríguez Martín',   'email' => 'carlos.rodriguez@alumno.com'],
            ['name' => 'Lucía Fernández Torres',    'email' => 'lucia.fernandez@alumno.com'],
            ['name' => 'Alejandro Sánchez Ruiz',    'email' => 'alejandro.sanchez@alumno.com'],
            ['name' => 'Paula Jiménez Castro',      'email' => 'paula.jimenez@alumno.com'],
            ['name' => 'Sergio Morales Ortega',     'email' => 'sergio.morales@alumno.com'],
            ['name' => 'Elena Vargas Navarro',      'email' => 'elena.vargas@alumno.com'],
            ['name' => 'David Romero Gil',          'email' => 'david.romero@alumno.com'],
            ['name' => 'Cristina Herrera Blanco',   'email' => 'cristina.herrera@alumno.com'],
            ['name' => 'Álvaro Molina Reyes',       'email' => 'alvaro.molina@alumno.com'],
            ['name' => 'Natalia Cruz Fuentes',      'email' => 'natalia.cruz@alumno.com'],
        ])->map(fn ($d) => User::create([...$d, 'password' => Hash::make('password'), 'role' => 'alumno']));

        [$a1,$a2,$a3,$a4,$a5,$a6,$a7,$a8,$a9,$a10,$a11,$a12] = $alumnos;

        // ─────────────────────────────────────────
        // SEGUIMIENTOS (curso actual – 12 prácticas)
        // ─────────────────────────────────────────
        $segs = [
            SeguimientoPractica::create(['empresa_id'=>$e1->id,'profesor_id'=>$p1->id,'curso_academico_id'=>$curso->id,'user_id'=>$a1->id,
                'titulo'=>'Desarrollo Backend con Laravel',
                'descripcion'=>'Construcción de una API REST robusta para plataforma de e-commerce con Laravel 11 y MySQL.',
                'fecha_inicio'=>'2026-01-15','fecha_fin'=>'2026-05-30','horas_totales'=>400,'estado'=>'en_curso',
                'objetivos'=>'Dominar Eloquent ORM, autenticación con Sanctum, testing unitario, despliegue en VPS.',
                'actividades'=>'Modelado de base de datos, desarrollo de controladores, validaciones, documentación con Swagger.']),

            SeguimientoPractica::create(['empresa_id'=>$e2->id,'profesor_id'=>$p2->id,'curso_academico_id'=>$curso->id,'user_id'=>$a2->id,
                'titulo'=>'Diseño UI/UX y Frontend Angular',
                'descripcion'=>'Rediseño completo de la web corporativa de un cliente del sector inmobiliario con Angular 18.',
                'fecha_inicio'=>'2026-01-20','fecha_fin'=>'2026-05-25','horas_totales'=>380,'estado'=>'en_curso',
                'objetivos'=>'Aplicar principios UX, maquetación responsive, optimización de rendimiento web.',
                'actividades'=>'Wireframes en Figma, desarrollo de componentes Angular, integración con API REST, accesibilidad WCAG.']),

            SeguimientoPractica::create(['empresa_id'=>$e3->id,'profesor_id'=>$p2->id,'curso_academico_id'=>$curso->id,'user_id'=>$a3->id,
                'titulo'=>'Análisis de Datos con Python y Power BI',
                'descripcion'=>'Extracción, transformación y carga (ETL) de datos de ventas y generación de dashboards interactivos.',
                'fecha_inicio'=>'2026-02-01','fecha_fin'=>'2026-06-15','horas_totales'=>420,'estado'=>'en_curso',
                'objetivos'=>'Pandas, NumPy, visualización con Matplotlib y Power BI, SQL avanzado.',
                'actividades'=>'Limpieza de datos, análisis exploratorio, creación de informes automáticos.']),

            SeguimientoPractica::create(['empresa_id'=>$e4->id,'profesor_id'=>$p3->id,'curso_academico_id'=>$curso->id,'user_id'=>$a4->id,
                'titulo'=>'Administración de Infraestructura Cloud AWS',
                'descripcion'=>'Gestión y automatización de infraestructura en AWS: EC2, S3, RDS y Lambda.',
                'fecha_inicio'=>'2026-01-10','fecha_fin'=>'2026-05-20','horas_totales'=>400,'estado'=>'en_curso',
                'objetivos'=>'Certificación AWS Cloud Practitioner, IaC con Terraform, CI/CD con GitHub Actions.',
                'actividades'=>'Provisionamiento de servidores, pipelines de despliegue, monitorización con CloudWatch.']),

            SeguimientoPractica::create(['empresa_id'=>$e5->id,'profesor_id'=>$p4->id,'curso_academico_id'=>$curso->id,'user_id'=>$a5->id,
                'titulo'=>'Auditoría y Pentesting de Sistemas',
                'descripcion'=>'Realización de test de penetración en entornos controlados de clientes corporativos.',
                'fecha_inicio'=>'2026-02-10','fecha_fin'=>'2026-06-20','horas_totales'=>440,'estado'=>'en_curso',
                'objetivos'=>'Kali Linux, Metasploit, OWASP Top 10, elaboración de informes de seguridad.',
                'actividades'=>'Análisis de vulnerabilidades, ataques controlados, elaboración de informes ejecutivos.']),

            SeguimientoPractica::create(['empresa_id'=>$e6->id,'profesor_id'=>$p1->id,'curso_academico_id'=>$curso->id,'user_id'=>$a6->id,
                'titulo'=>'Desarrollo de App Móvil con Flutter',
                'descripcion'=>'Construcción de una aplicación móvil multiplataforma para gestión de citas médicas.',
                'fecha_inicio'=>'2026-01-25','fecha_fin'=>'2026-06-05','horas_totales'=>410,'estado'=>'en_curso',
                'objetivos'=>'Flutter, Dart, BLoC, integración con API REST, publicación en stores.',
                'actividades'=>'Diseño de UI, desarrollo de pantallas, gestión de estado con BLoC, testing.']),

            SeguimientoPractica::create(['empresa_id'=>$e7->id,'profesor_id'=>$p2->id,'curso_academico_id'=>$curso->id,'user_id'=>$a7->id,
                'titulo'=>'Consultoría e Implantación de ERP',
                'descripcion'=>'Análisis de procesos empresariales e implantación de módulos de Odoo para cliente PYME.',
                'fecha_inicio'=>'2026-01-12','fecha_fin'=>'2026-05-18','horas_totales'=>380,'estado'=>'en_curso',
                'objetivos'=>'Odoo 17, personalización de módulos, migración de datos, formación usuarios.',
                'actividades'=>'Análisis de requisitos, configuración de módulos, importación de datos, documentación.']),

            SeguimientoPractica::create(['empresa_id'=>$e8->id,'profesor_id'=>$p1->id,'curso_academico_id'=>$curso->id,'user_id'=>$a8->id,
                'titulo'=>'Plataforma E-Learning con React',
                'descripcion'=>'Desarrollo de un LMS (Learning Management System) con React y Node.js.',
                'fecha_inicio'=>'2026-02-03','fecha_fin'=>'2026-06-10','horas_totales'=>400,'estado'=>'en_curso',
                'objetivos'=>'React 18, Redux Toolkit, Express.js, videoconferencia con WebRTC.',
                'actividades'=>'Sistema de cursos, evaluaciones online, panel de progreso, notificaciones por email.']),

            SeguimientoPractica::create(['empresa_id'=>$e9->id,'profesor_id'=>$p2->id,'curso_academico_id'=>$curso->id,'user_id'=>$a9->id,
                'titulo'=>'Desarrollo de Microservicios FinTech',
                'descripcion'=>'Arquitectura de microservicios con Spring Boot para pasarela de pagos.',
                'fecha_inicio'=>'2026-01-20','fecha_fin'=>'2026-05-30','horas_totales'=>420,'estado'=>'en_curso',
                'objetivos'=>'Spring Boot, Docker, Kafka, seguridad PCI-DSS, pruebas de carga.',
                'actividades'=>'Diseño de microservicios, contenerización Docker, integración con Stripe API.']),

            SeguimientoPractica::create(['empresa_id'=>$e10->id,'profesor_id'=>$p3->id,'curso_academico_id'=>$curso->id,'user_id'=>$a10->id,
                'titulo'=>'DevOps y Automatización CI/CD',
                'descripcion'=>'Implantación de cultura DevOps: pipelines automáticos, contenedores y monitorización.',
                'fecha_inicio'=>'2026-02-05','fecha_fin'=>'2026-06-12','horas_totales'=>400,'estado'=>'en_curso',
                'objetivos'=>'Jenkins, Docker, Kubernetes, Prometheus/Grafana, GitOps.',
                'actividades'=>'Creación de pipelines, despliegue en K8s, configuración de alertas, documentación.']),

            // Prácticas del curso anterior (finalizadas)
            SeguimientoPractica::create(['empresa_id'=>$e1->id,'profesor_id'=>$p1->id,'curso_academico_id'=>$cursoAnterior->id,'user_id'=>$a11->id,
                'titulo'=>'Desarrollo Full Stack Node + Vue',
                'descripcion'=>'Portal de gestión de reservas para cadena hotelera con Node.js y Vue 3.',
                'fecha_inicio'=>'2025-01-15','fecha_fin'=>'2025-05-30','horas_totales'=>400,'estado'=>'finalizada',
                'objetivos'=>'Vue 3 Composition API, Express.js, PostgreSQL, deploy en Heroku.',
                'actividades'=>'CRUD de reservas, pasarela de pago, panel de administración, testing E2E.']),

            SeguimientoPractica::create(['empresa_id'=>$e3->id,'profesor_id'=>$p2->id,'curso_academico_id'=>$cursoAnterior->id,'user_id'=>$a12->id,
                'titulo'=>'Machine Learning aplicado a Marketing',
                'descripcion'=>'Modelos predictivos para segmentación de clientes y predicción de churn.',
                'fecha_inicio'=>'2025-02-01','fecha_fin'=>'2025-06-15','horas_totales'=>420,'estado'=>'finalizada',
                'objetivos'=>'Scikit-learn, clustering K-Means, redes neuronales, despliegue de modelos con FastAPI.',
                'actividades'=>'Recopilación de datos, entrenamiento de modelos, evaluación de métricas, API de predicción.']),
        ];

        [$s1,$s2,$s3,$s4,$s5,$s6,$s7,$s8,$s9,$s10,$s11,$s12] = $segs;

        // ─────────────────────────────────────────
        // PARTES DIARIOS
        // ─────────────────────────────────────────
        $parte = fn(array $d) => ParteDiario::create($d);

        // Juan / TechSolutions (s1)
        $parte(['seguimiento_practica_id'=>$s1->id,'fecha'=>'2026-01-15','horas_realizadas'=>8,'actividades_realizadas'=>'Incorporación al equipo. Reunión inicial con el CTO. Revisión del repositorio Git existente y configuración del entorno local con Docker.','observaciones'=>'Equipo muy acogedor. Proyecto con buena arquitectura.','dificultades'=>'Problemas al levantar contenedor de MySQL.','soluciones_propuestas'=>'Ajustar versión de imagen Docker a mysql:8.0.','validado_tutor'=>true,'validado_profesor'=>true]);
        $parte(['seguimiento_practica_id'=>$s1->id,'fecha'=>'2026-01-16','horas_realizadas'=>8,'actividades_realizadas'=>'Diseño del modelo de datos para el módulo de pedidos. Creación de migraciones en Laravel. Revisión con compañero senior.','observaciones'=>'Modelo aprobado con pequeños cambios.','dificultades'=>'Relaciones muchos-a-muchos con tablas pivot.','soluciones_propuestas'=>'Uso de belongsToMany con withPivot().','validado_tutor'=>true,'validado_profesor'=>true]);
        $parte(['seguimiento_practica_id'=>$s1->id,'fecha'=>'2026-01-20','horas_realizadas'=>8,'actividades_realizadas'=>'Desarrollo de los controladores ProductoController y CategoriaController con operaciones CRUD completas y Form Requests para validación.','observaciones'=>'API respondiendo correctamente en Postman.','dificultades'=>'Gestión de imágenes de producto.','soluciones_propuestas'=>'Usar Storage::disk(public) para almacenamiento de archivos.','validado_tutor'=>true,'validado_profesor'=>true]);
        $parte(['seguimiento_practica_id'=>$s1->id,'fecha'=>'2026-01-21','horas_realizadas'=>7,'actividades_realizadas'=>'Implementación de autenticación con Laravel Sanctum. Creación de middleware para protección de rutas. Pruebas con Postman.','observaciones'=>'Sistema de tokens funcionando.','dificultades'=>'Expiración de tokens en pruebas.','soluciones_propuestas'=>'Configurar sanctum.expiration en config/sanctum.php.','validado_tutor'=>true,'validado_profesor'=>false]);
        $parte(['seguimiento_practica_id'=>$s1->id,'fecha'=>'2026-01-22','horas_realizadas'=>8,'actividades_realizadas'=>'Desarrollo del módulo de carrito de compras. Lógica de descuentos y cupones. Pruebas unitarias con PHPUnit.','observaciones'=>'12 tests pasando correctamente.','dificultades'=>'Cálculo de IVA con productos exentos.','soluciones_propuestas'=>'Tabla de tipos de IVA separada.','validado_tutor'=>false,'validado_profesor'=>false]);
        $parte(['seguimiento_practica_id'=>$s1->id,'fecha'=>'2026-01-27','horas_realizadas'=>8,'actividades_realizadas'=>'Integración con pasarela de pago Stripe. Gestión de webhooks. Refactorización de servicios.','observaciones'=>'Primer pago real procesado en entorno sandbox.','dificultades'=>'Validación de firma de webhooks.','soluciones_propuestas'=>'Usar Stripe::constructEvent() con clave secreta.','validado_tutor'=>false,'validado_profesor'=>false]);

        // María / WebDesign (s2)
        $parte(['seguimiento_practica_id'=>$s2->id,'fecha'=>'2026-01-20','horas_realizadas'=>8,'actividades_realizadas'=>'Reunión de kickoff con el cliente inmobiliario. Análisis del sitio actual. Investigación de competencia. Propuesta inicial de arquitectura de información.','observaciones'=>'Cliente con ideas muy claras sobre el rediseño.','dificultades'=>'El cliente quiere mantener SEO actual.','soluciones_propuestas'=>'Planificar redirecciones 301 y mantener estructura de URLs.','validado_tutor'=>true,'validado_profesor'=>true]);
        $parte(['seguimiento_practica_id'=>$s2->id,'fecha'=>'2026-01-21','horas_realizadas'=>8,'actividades_realizadas'=>'Diseño de wireframes de baja fidelidad para home, listado de propiedades y ficha de propiedad. Presentación al equipo.','observaciones'=>'Wireframes aprobados con ajustes menores.','dificultades'=>'Filtros de búsqueda complejos.','soluciones_propuestas'=>'Componente de búsqueda avanzada con múltiples parámetros.','validado_tutor'=>true,'validado_profesor'=>true]);
        $parte(['seguimiento_practica_id'=>$s2->id,'fecha'=>'2026-01-22','horas_realizadas'=>7,'actividades_realizadas'=>'Prototipo en Figma de alta fidelidad. Selección de paleta de colores y tipografía. Presentación al cliente.','observaciones'=>'Cliente muy satisfecho con la propuesta visual.','dificultades'=>'Ajuste de contraste para cumplir WCAG AA.','soluciones_propuestas'=>'Usar herramienta de contraste de Figma.','validado_tutor'=>true,'validado_profesor'=>false]);
        $parte(['seguimiento_practica_id'=>$s2->id,'fecha'=>'2026-01-27','horas_realizadas'=>8,'actividades_realizadas'=>'Inicio del desarrollo en Angular 18. Configuración del proyecto con standalone components. Implementación de routing.','observaciones'=>'Estructura de proyecto limpia y escalable.','dificultades'=>'Migración de módulos legacy a standalone.','soluciones_propuestas'=>'Usar ng generate para scaffolding actualizado.','validado_tutor'=>false,'validado_profesor'=>false]);
        $parte(['seguimiento_practica_id'=>$s2->id,'fecha'=>'2026-01-28','horas_realizadas'=>8,'actividades_realizadas'=>'Desarrollo del componente de mapa interactivo con Leaflet. Marcadores de propiedades con popup de información.','observaciones'=>'Mapas funcionando correctamente.','dificultades'=>'Rendimiento con muchos marcadores.','soluciones_propuestas'=>'Implementar clustering de marcadores con Leaflet.markercluster.','validado_tutor'=>false,'validado_profesor'=>false]);

        // Carlos / DataAnalytics (s3)
        $parte(['seguimiento_practica_id'=>$s3->id,'fecha'=>'2026-02-01','horas_realizadas'=>8,'actividades_realizadas'=>'Configuración del entorno Python con Anaconda. Análisis exploratorio inicial del dataset de ventas (500K registros). Identificación de valores nulos y outliers.','observaciones'=>'Dataset con un 12% de valores nulos en columna precio.','dificultades'=>'Encodings inconsistentes en el CSV.','soluciones_propuestas'=>'Normalizar con pandas usando encoding=utf-8-sig.','validado_tutor'=>true,'validado_profesor'=>true]);
        $parte(['seguimiento_practica_id'=>$s3->id,'fecha'=>'2026-02-03','horas_realizadas'=>8,'actividades_realizadas'=>'Limpieza de datos: imputación de nulos con mediana, eliminación de duplicados, normalización de categorías de productos.','observaciones'=>'Dataset limpio con 487K registros válidos.','dificultades'=>'Categorías escritas de forma inconsistente.','soluciones_propuestas'=>'FuzzyWuzzy para matching aproximado de cadenas.','validado_tutor'=>true,'validado_profesor'=>false]);
        $parte(['seguimiento_practica_id'=>$s3->id,'fecha'=>'2026-02-05','horas_realizadas'=>7,'actividades_realizadas'=>'Análisis de series temporales de ventas mensuales 2023-2025. Identificación de tendencias y estacionalidad. Visualización con Matplotlib y Seaborn.','observaciones'=>'Pico claro en noviembre (Black Friday) cada año.','dificultades'=>'Elección del modelo de descomposición.','soluciones_propuestas'=>'Usar statsmodels seasonal_decompose.','validado_tutor'=>false,'validado_profesor'=>false]);

        // Lucía / CloudSystems (s4)
        $parte(['seguimiento_practica_id'=>$s4->id,'fecha'=>'2026-01-10','horas_realizadas'=>8,'actividades_realizadas'=>'Onboarding. Estudio de la arquitectura AWS actual del cliente. Acceso a consola AWS. Revisión de buenas prácticas Well-Architected Framework.','observaciones'=>'Infraestructura existente con deuda técnica considerable.','dificultades'=>'Gestión de credenciales IAM.','soluciones_propuestas'=>'Usar AWS Secrets Manager para rotación automática.','validado_tutor'=>true,'validado_profesor'=>true]);
        $parte(['seguimiento_practica_id'=>$s4->id,'fecha'=>'2026-01-12','horas_realizadas'=>8,'actividades_realizadas'=>'Configuración de Terraform para IaC. Descripción del VPC, subnets públicas/privadas, Security Groups. Primer apply exitoso.','observaciones'=>'Infraestructura versionada en Git por primera vez.','dificultades'=>'Conflictos de estado en tfstate.','soluciones_propuestas'=>'Backend remoto en S3 con DynamoDB para bloqueo.','validado_tutor'=>true,'validado_profesor'=>true]);
        $parte(['seguimiento_practica_id'=>$s4->id,'fecha'=>'2026-01-14','horas_realizadas'=>7,'actividades_realizadas'=>'Configuración de Auto Scaling Group con Launch Template para instancias EC2. Políticas de escalado basadas en CPU.','observaciones'=>'Sistema escala correctamente en pruebas de carga.','dificultades'=>'Tiempo de arranque de instancias alto (3 min).','soluciones_propuestas'=>'Crear AMI personalizada con dependencias preinstaladas.','validado_tutor'=>false,'validado_profesor'=>false]);

        // Alejandro / CyberShield (s5)
        $parte(['seguimiento_practica_id'=>$s5->id,'fecha'=>'2026-02-10','horas_realizadas'=>8,'actividades_realizadas'=>'Introducción a metodologías de pentesting. Configuración de laboratorio con Kali Linux y máquinas virtuales objetivo. Revisión de OWASP Top 10.','observaciones'=>'Entorno de laboratorio funcionando.','dificultades'=>'Configuración de red interna aislada.','soluciones_propuestas'=>'VirtualBox Host-Only Network.','validado_tutor'=>true,'validado_profesor'=>true]);
        $parte(['seguimiento_practica_id'=>$s5->id,'fecha'=>'2026-02-12','horas_realizadas'=>8,'actividades_realizadas'=>'Reconocimiento pasivo de objetivo con OSINT: Shodan, theHarvester, Maltego. Enumeración de subdominios. Análisis de metadatos de documentos públicos.','observaciones'=>'7 subdominios expuestos identificados.','dificultades'=>'Falsos positivos en theHarvester.','soluciones_propuestas'=>'Validar resultados cruzando con nmap.','validado_tutor'=>true,'validado_profesor'=>false]);
        $parte(['seguimiento_practica_id'=>$s5->id,'fecha'=>'2026-02-13','horas_realizadas'=>8,'actividades_realizadas'=>'Escaneo de puertos y servicios con Nmap. Identificación de versiones de software. Búsqueda de CVEs conocidos con searchsploit.','observaciones'=>'Puerto 8080 con Tomcat 9.0.1 vulnerable a CVE-2019-0232.','dificultades'=>'IDS bloquea escaneos agresivos.','soluciones_propuestas'=>'Usar escaneos lentos con -T2 y -f para fragmentación.','validado_tutor'=>false,'validado_profesor'=>false]);

        // Paula / MobileFirst (s6)
        $parte(['seguimiento_practica_id'=>$s6->id,'fecha'=>'2026-01-25','horas_realizadas'=>8,'actividades_realizadas'=>'Configuración del proyecto Flutter. Estudio del diseño proporcionado en Figma. Implementación del sistema de navegación con GoRouter.','observaciones'=>'Estructura de rutas clara y mantenible.','dificultades'=>'Nested navigation con bottom bar.','soluciones_propuestas'=>'ShellRoute en GoRouter para tabs persistentes.','validado_tutor'=>true,'validado_profesor'=>true]);
        $parte(['seguimiento_practica_id'=>$s6->id,'fecha'=>'2026-01-27','horas_realizadas'=>8,'actividades_realizadas'=>'Desarrollo de pantallas de autenticación: login, registro y recuperación de contraseña. Integración con API REST con Dio.','observaciones'=>'Autenticación funcionando en iOS y Android.','dificultades'=>'Gestión del token JWT en almacenamiento seguro.','soluciones_propuestas'=>'flutter_secure_storage para keychain/keystore.','validado_tutor'=>true,'validado_profesor'=>false]);

        // Sergio / Innovatech (s7)
        $parte(['seguimiento_practica_id'=>$s7->id,'fecha'=>'2026-01-12','horas_realizadas'=>8,'actividades_realizadas'=>'Análisis de procesos del cliente (empresa distribuidora). Levantamiento de requisitos con entrevistas a usuarios clave. Modelado AS-IS en BPMN.','observaciones'=>'Procesos muy poco automatizados actualmente.','dificultades'=>'Resistencia al cambio de algunos usuarios.','soluciones_propuestas'=>'Plan de gestión del cambio con formación gradual.','validado_tutor'=>true,'validado_profesor'=>true]);
        $parte(['seguimiento_practica_id'=>$s7->id,'fecha'=>'2026-01-14','horas_realizadas'=>7,'actividades_realizadas'=>'Instalación y configuración de Odoo 17 Community en VPS Ubuntu. Configuración de módulos: Ventas, Compras, Inventario, Contabilidad.','observaciones'=>'Sistema base funcionando.','dificultades'=>'Conflicto de puertos con servicio existente.','soluciones_propuestas'=>'Cambiar Odoo a puerto 8069 y nginx como proxy.','validado_tutor'=>false,'validado_profesor'=>false]);

        // Elena / EduSoft (s8)
        $parte(['seguimiento_practica_id'=>$s8->id,'fecha'=>'2026-02-03','horas_realizadas'=>8,'actividades_realizadas'=>'Diseño de la arquitectura del LMS. Definición de entidades: Curso, Módulo, Lección, Evaluación, Usuario. Configuración de React con Vite y Redux Toolkit.','observaciones'=>'Arquitectura aprobada por el equipo técnico.','dificultades'=>'Modelado de relaciones complejas entre entidades.','soluciones_propuestas'=>'Diagrama ER detallado antes de implementar.','validado_tutor'=>true,'validado_profesor'=>true]);
        $parte(['seguimiento_practica_id'=>$s8->id,'fecha'=>'2026-02-05','horas_realizadas'=>8,'actividades_realizadas'=>'Desarrollo del sistema de autenticación con JWT y refresh tokens. Páginas de login, registro y perfil. Rutas protegidas con React Router 6.','observaciones'=>'Sistema seguro con refresh token rotación.','dificultades'=>'Gestión del estado global de autenticación.','soluciones_propuestas'=>'authSlice en Redux con persistencia en localStorage.','validado_tutor'=>true,'validado_profesor'=>false]);

        // David / FinTech Nexus (s9)
        $parte(['seguimiento_practica_id'=>$s9->id,'fecha'=>'2026-01-20','horas_realizadas'=>8,'actividades_realizadas'=>'Estudio del ecosistema Spring Boot y microservicios. Configuración del proyecto con Spring Initializr. Implementación del primer microservicio de usuarios.','observaciones'=>'Microservicio desplegado localmente con Docker.','dificultades'=>'Comunicación entre microservicios.','soluciones_propuestas'=>'Service discovery con Eureka o Kubernetes DNS.','validado_tutor'=>true,'validado_profesor'=>true]);

        // Cristina / GreenCode (s10)
        $parte(['seguimiento_practica_id'=>$s10->id,'fecha'=>'2026-02-05','horas_realizadas'=>8,'actividades_realizadas'=>'Auditoría del pipeline CI/CD existente. Identificación de cuellos de botella. Propuesta de mejoras con Jenkins declarativo y caché de dependencias.','observaciones'=>'Pipeline pasó de 18 a 7 minutos tras optimización.','dificultades'=>'Tests flaky que rompían la build aleatoriamente.','soluciones_propuestas'=>'Retry plugin en Jenkins para tests no deterministas.','validado_tutor'=>true,'validado_profesor'=>true]);

        // Álvaro / TechSolutions curso anterior (s11)
        $parte(['seguimiento_practica_id'=>$s11->id,'fecha'=>'2025-01-15','horas_realizadas'=>8,'actividades_realizadas'=>'Inicio del proyecto. Configuración de Vue 3 con Vite y Pinia. Diseño del sistema de autenticación.','observaciones'=>'Equipo muy profesional.','dificultades'=>'','soluciones_propuestas'=>'','validado_tutor'=>true,'validado_profesor'=>true]);
        $parte(['seguimiento_practica_id'=>$s11->id,'fecha'=>'2025-01-16','horas_realizadas'=>8,'actividades_realizadas'=>'Desarrollo del CRUD de reservas. Integración con API Express.js. Tests con Vitest.','observaciones'=>'Todos los tests pasando.','dificultades'=>'Transacciones de base de datos.','soluciones_propuestas'=>'Usar transacciones de Knex.js.','validado_tutor'=>true,'validado_profesor'=>true]);

        // Natalia / DataAnalytics curso anterior (s12)
        $parte(['seguimiento_practica_id'=>$s12->id,'fecha'=>'2025-02-01','horas_realizadas'=>8,'actividades_realizadas'=>'Exploración del dataset de clientes. Primera iteración del modelo de clustering K-Means con 5 segmentos.','observaciones'=>'Silhouette score de 0.62, buen resultado.','dificultades'=>'Elección del número óptimo de clusters.','soluciones_propuestas'=>'Método del codo y análisis de silueta.','validado_tutor'=>true,'validado_profesor'=>true]);
        $parte(['seguimiento_practica_id'=>$s12->id,'fecha'=>'2025-02-03','horas_realizadas'=>8,'actividades_realizadas'=>'Modelo de predicción de churn con Random Forest. Accuracy del 89%. Deploy del modelo con FastAPI.','observaciones'=>'Resultados muy por encima del objetivo del 80%.','dificultades'=>'Desbalanceo de clases.','soluciones_propuestas'=>'SMOTE para oversampling de clase minoritaria.','validado_tutor'=>true,'validado_profesor'=>true]);

        // ─────────────────────────────────────────
        // VALORACIONES
        // ─────────────────────────────────────────
        $val = fn(array $d) => Valoracion::create($d);

        $val(['seguimiento_practica_id'=>$s1->id,'profesor_id'=>$p1->id,'puntuacion'=>9,'aspecto_valorado'=>'Capacidad técnica','comentarios'=>'Juan demuestra un dominio excelente de Laravel. Implementó Sanctum y las pruebas unitarias de forma autónoma y profesional.']);
        $val(['seguimiento_practica_id'=>$s1->id,'profesor_id'=>$p1->id,'puntuacion'=>8,'aspecto_valorado'=>'Actitud y trabajo en equipo','comentarios'=>'Muy buena integración con el equipo de TechSolutions. Colaborador y proactivo en las reuniones diarias.']);
        $val(['seguimiento_practica_id'=>$s1->id,'profesor_id'=>$p1->id,'puntuacion'=>7,'aspecto_valorado'=>'Documentación y comunicación','comentarios'=>'Los comentarios en el código son mejorables. Se recomienda adoptar PHPDoc de forma más sistemática.']);

        $val(['seguimiento_practica_id'=>$s2->id,'profesor_id'=>$p2->id,'puntuacion'=>10,'aspecto_valorado'=>'Creatividad y diseño','comentarios'=>'María tiene un talento natural para el diseño. El prototipo Figma sorprendió gratamente al cliente. Nivel muy alto para segundo año.']);
        $val(['seguimiento_practica_id'=>$s2->id,'profesor_id'=>$p2->id,'puntuacion'=>8,'aspecto_valorado'=>'Dominio de Angular','comentarios'=>'Rápida evolución en Angular 18. Gestiona bien los componentes standalone y el routing. Necesita profundizar más en RxJS.']);

        $val(['seguimiento_practica_id'=>$s3->id,'profesor_id'=>$p2->id,'puntuacion'=>9,'aspecto_valorado'=>'Análisis y pensamiento crítico','comentarios'=>'Carlos identifica patrones en los datos de forma muy eficiente. Su análisis de estacionalidad fue especialmente valorado por el equipo.']);

        $val(['seguimiento_practica_id'=>$s4->id,'profesor_id'=>$p3->id,'puntuacion'=>9,'aspecto_valorado'=>'Autonomía e iniciativa','comentarios'=>'Lucía configuró el backend de Terraform de forma completamente autónoma. Gran capacidad de autoaprendizaje en AWS.']);

        $val(['seguimiento_practica_id'=>$s5->id,'profesor_id'=>$p4->id,'puntuacion'=>10,'aspecto_valorado'=>'Rigor y metodología','comentarios'=>'Alejandro sigue la metodología de pentesting con un rigor impresionante. Los informes que entrega son de calidad profesional.']);
        $val(['seguimiento_practica_id'=>$s5->id,'profesor_id'=>$p4->id,'puntuacion'=>9,'aspecto_valorado'=>'Ética profesional','comentarios'=>'Demuestra plena conciencia de los límites éticos y legales del hacking ético. Actitud muy madura y responsable.']);

        $val(['seguimiento_practica_id'=>$s6->id,'profesor_id'=>$p1->id,'puntuacion'=>8,'aspecto_valorado'=>'Desarrollo móvil','comentarios'=>'Paula ha aplicado BLoC de forma correcta desde el principio. La gestión del estado con flutter_secure_storage fue una solución elegante.']);

        $val(['seguimiento_practica_id'=>$s11->id,'profesor_id'=>$p1->id,'puntuacion'=>8,'aspecto_valorado'=>'Capacidad técnica','comentarios'=>'Álvaro demostró sólidos conocimientos en Vue 3 y Node.js. Buena práctica completada con éxito.']);
        $val(['seguimiento_practica_id'=>$s12->id,'profesor_id'=>$p2->id,'puntuacion'=>9,'aspecto_valorado'=>'Análisis de datos e IA','comentarios'=>'Natalia obtuvo resultados destacables con el modelo de churn. El uso de SMOTE para el desbalanceo fue acertado y bien justificado.']);

        // ─────────────────────────────────────────
        // RESUMEN
        // ─────────────────────────────────────────
        $this->command->info('  Base de datos poblada con exito');
        $this->command->info('  -------------------------------------------');
        $this->command->info('  Admin:      admin@practichub.com  / password');
        $this->command->info('  Profesores: ana.martinez@iestech.es ... (password)');
        $this->command->info('  Alumnos:    juan.garcia@alumno.com ... (password)');
        $this->command->info('  Empresas:   contacto@techsolutions.com ... (password)');
        $this->command->info('  -------------------------------------------');
        $this->command->info('  Empresas: 10 | Alumnos: 12 | Profesores: 4');
        $this->command->info('  Seguimientos: 12 | Partes: 28 | Valoraciones: 12');
    }
}

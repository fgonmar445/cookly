# Cookly — Tu Asistente de Cocina Inteligente

🌐 [English version](README.en.md)

[![Demo en vivo](https://img.shields.io/badge/Demo_en_vivo-cookly--jeke.onrender.com-4ADE80?style=for-the-badge&logo=render&logoColor=white)](https://cookly-jeke.onrender.com/)

[![Laravel Version](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.0-38B2AC?style=for-the-badge&logo=tailwind-css)](https://tailwindcss.com)
[![PHP Version](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php)](https://php.net)
[![PostgreSQL](https://img.shields.io/badge/PostgreSQL-Neon-4169E1?style=for-the-badge&logo=postgresql&logoColor=white)](https://neon.tech)
[![Docker](https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&logo=docker&logoColor=white)](https://www.docker.com)
[![Render](https://img.shields.io/badge/Render-46E3B7?style=for-the-badge&logo=render&logoColor=white)](https://render.com)
[![Cloudinary](https://img.shields.io/badge/Cloudinary-3448C5?style=for-the-badge&logo=cloudinary&logoColor=white)](https://cloudinary.com)
[![API Provider](https://img.shields.io/badge/API-TheMealDB-orange?style=for-the-badge)](https://www.themealdb.com)
[![Mailing](https://img.shields.io/badge/SMTP-Brevo-blue?style=for-the-badge)](https://www.brevo.com)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg?style=for-the-badge)](https://opensource.org/licenses/MIT)

<img src="./public/cookly_logo_banner.png" alt="Cookly Banner">

**Cookly** es una plataforma web integral y de diseño prémium orientada a revolucionar la gestión de la cocina doméstica y potenciar la creatividad culinaria. Mediante la toma de decisiones basada en los ingredientes disponibles en el hogar y un potente cruce de datos con bases globales, Cookly permite reducir el desperdicio alimentario, planificar menús y explorar la gastronomía internacional de forma sencilla e intuitiva.

🔗 **Pruébalo en vivo:** [https://cookly-jeke.onrender.com/](https://cookly-jeke.onrender.com/)

---

## Índice

1. [Características Principales](#características-principales)
2. [Arquitectura de Seguridad](#arquitectura-de-seguridad)
3. [Módulos de la Aplicación](#módulos-de-la-aplicación)
4. [Hub de Traducción Gastronómica Local](#hub-de-traducción-gastronómica-local-ingredientsphp)
5. [Despliegue e Infraestructura de Producción](#despliegue-e-infraestructura-de-producción)
6. [Panel de Administración](#panel-de-administración)
7. [Stack Tecnológico](#stack-tecnológico)
8. [Guía de Instalación](#guía-de-instalación)
9. [Cuentas de Acceso Rápido](#cuentas-de-acceso-rápido)
10. [Mapa de Navegación](#mapa-de-navegación)

---

## Características Principales

- **Gestión Inteligente de Despensa**: Inventario digital de ingredientes clasificados por categorías con autocompletado y vinculación dinámica.
- **Búsqueda Multidimensional**: Localiza platos por nombre, región geográfica, categoría, o introduciendo los ingredientes específicos que tienes a mano.
- **Generador de Recomendaciones**: Algoritmo que analiza tu inventario actual para priorizar y sugerir recetas que maximizan el aprovechamiento de tus alimentos.
- **Comunidad y Exploración**: Ecosistema social donde los chefs domésticos pueden compartir sus creaciones, con filtros avanzados por **Recientes** y **Populares** (basados en el número de favoritos de la comunidad).
- **Favoritos en Tiempo Real**: Almacenamiento instantáneo de recetas con sincronización fluida entre orígenes locales y la API externa.
- **Diseño Prémium Esmeralda**: Interfaz altamente pulida, con esquemas de color cuidados, bordes suaves y una experiencia de usuario (UX) adaptada a dispositivos móviles, tabletas y escritorio.

---

## Arquitectura de Seguridad

El proyecto implementa estándares rigurosos de seguridad respaldados por el framework Laravel para garantizar la integridad de los datos y la protección de los usuarios:

- **Prevención de Inyección SQL**: Todas las consultas a la base de datos utilizan el ORM **Eloquent** y _Query Builder_, vinculando parámetros de forma segura (_Prepared Statements_) a través de PDO.
- **Defensa contra XSS (Cross-Site Scripting)**: El motor de plantillas **Blade** procesa y escapa de forma nativa (`{{ }}`) cualquier cadena de salida mediante `htmlspecialchars()`, neutralizando la ejecución de scripts maliciosos.
- **Saneamiento y Validación**: Uso estricto de clases `FormRequest` y métodos de validación en controladores para verificar tipos de datos, formatos y requerimientos antes de la persistencia.
- **Límite de Tasa (Rate Limiting)**: Protección integrada en rutas sensibles (como inicios de sesión y verificación de correos) para mitigar ataques de fuerza bruta y denegación de servicio (DoS).
- **Protección CSRF**: Todas las transacciones de estado (`POST`, `PUT`, `DELETE`) exigen la verificación de un token de sesión único y cifrado.

---

## Módulos de la Aplicación

### 1. Landing Page & Dashboard Personal
Puerta de entrada dinámica que presenta al usuario un resumen directo de su actividad, recetas aleatorias de inspiración diaria, platos más populares de la comunidad y sugerencias basadas en su despensa.

### 2. Mi Despensa
Interfaz visual para añadir, consultar y eliminar ingredientes disponibles en casa, permitiendo marcar los elementos base esenciales.

### 3. Explorador de Recetas Externas
Integración directa con la base de datos global para descubrir miles de combinaciones culinarias, con traducción automática de categorías, regiones e ingredientes al español.

### 4. Creación y Comunidad
Formularios de alta precisión para que el usuario documente sus propias recetas (con subida de imágenes optimizada y selección de ingredientes base). Incluye un muro público comunitario.

---

## Hub de Traducción Gastronómica Local (`ingredients.php`)

Dado que la API externa *TheMealDB* opera íntegramente en inglés, Cookly incorpora un componente nativo de traducción automática basado en diccionarios PHP optimizados. Este sistema intercepta las respuestas JSON de la API y mapea los elementos dinámicamente en tiempo real sin llamadas a servicios externos de pago:
- **Ingredientes:** *Chicken* ➔ *Pollo*, *Garlic* ➔ *Ajo*.
- **Categorías Gastronómicas:** *Dessert* ➔ *Postres*, *Vegetarian* ➔ *Vegetariano*.
- **Cocinas / Regiones:** *Italian* ➔ *Italiana*, *Mexican* ➔ *Mexicana*.

---

## Vista Previa de la Aplicación (Capturas de Pantalla)

A continuación se muestran los principales módulos e interfaces de la interfaz prémium esmeralda de Cookly en funcionamiento:

| Dashboard del Usuario | Gestión de la Despensa |
| :---: | :---: |
| <img src="./public/images/dashboard.png" width="100%" alt="Dashboard Principal"> | <img src="./public/images/ingredientes.png" width="100%" alt="Interfaz de Despensa"> |
| *Panel de control central con sugerencias diarias y populares.* | *Buscador asíncrono y control de stock de ingredientes en tiempo real.* |

| Explorador de Recetas (API) | 
| :---: |   
| <img src="./public/images/buscar.png" width="100%" alt="Buscador de Recetas"> |
| *Filtrado avanzado con traducción automática de gastronomía global.* |

| Panel de Administración | Diseño Adaptativo Móvil |
| :---: | :---: |
| <img src="./public/images/admin.png" width="100%" alt="Panel Admin"> | <img src="./public/images/mobile.png" width="100%" alt="Vista Responsive"> |
| *Métricas globales, moderación activa y logs de auditoría.* | *Experiencia de usuario fluida y optimizada para smartphone.* |

## Despliegue e Infraestructura de Producción

La plataforma pasó de correr en un VPS administrado a mano a una infraestructura containerizada y gestionada en la nube, más fácil de reproducir y mantener:

- **Contenerización:** imagen Docker construida en 3 etapas (compilación de assets con Node/Vite, dependencias PHP con Composer, y una imagen final ligera de **PHP 8.2 + Apache**), definida en el `Dockerfile` del repositorio.
- **Hosting:** **Render** (Web Service desplegado directamente desde el `Dockerfile`, sin necesidad de configurar servidor propio).
- **Base de datos:** **PostgreSQL gestionado por Neon** (serverless, con conexión directa para migraciones y *connection pooling* para las consultas de la aplicación), migrado desde MySQL sin tener que tocar una sola migración gracias a que todo el acceso a datos pasa por Eloquent/Query Builder.
- **Almacenamiento de imágenes:** **Cloudinary** — las imágenes que suben los usuarios al crear recetas ya no se guardan en disco local (efímero en un contenedor), sino en la nube, con CDN y optimización automática.
- **Correo transaccional:** **Brevo** vía SMTP (puerto 2525, compatible con las restricciones de salida del hosting) para los correos de verificación de cuenta.
- **Cifrado y Seguridad:** HTTPS gestionado automáticamente por Render, con `trustProxies` configurado en Laravel para detectar correctamente el esquema seguro detrás del proxy inverso.
- **Estrategia de Caché:** Optimización del rendimiento de la API mediante capas de caché en Laravel (1 hora para inspiración diaria y 10 minutos para el recomendador por ingredientes).

---

## Panel de Administración

Área restringida mediante _middleware_ dedicada a la supervisión total del sistema:

- **Métricas Globales**: Contadores de usuarios, recetas creadas, elementos en favoritos e incorporaciones recientes.
- **Gestión de Usuarios**: Panel para visualizar cuentas registradas, modificar roles (Administrador/Usuario) o revocar accesos.
- **Gestión de Recetas y Catálogo**: Control sobre el contenido publicado y un módulo completo de administración (CRUD) de ingredientes base del sistema.
- **Registro de Actividad (Logs)**: Trazabilidad inmutable en base de datos de las acciones de moderación de los administradores (Ej: `Cambiado rol de Felipe: user -> admin` o `Eliminado ingrediente: Cilantro`).

---

## Stack Tecnológico

| Tecnología | Rol en el Proyecto |
| :--- | :--- |
| **Laravel 12** | Framework principal (Arquitectura MVC, enrutamiento, seguridad y lógica) |
| **Tailwind CSS 3** | Sistema de diseño de utilidades para una estética moderna y responsiva |
| **PostgreSQL (Neon)** | Motor relacional gestionado en producción para el almacenamiento de datos persistentes |
| **Docker** | Contenerización de la aplicación para un despliegue reproducible |
| **Render** | Hosting de la aplicación (Web Service desde Dockerfile) |
| **Cloudinary** | Almacenamiento y optimización de imágenes subidas por los usuarios |
| **Brevo** | Envío de correos transaccionales (verificación de cuenta) vía SMTP |
| **TheMealDB API** | Proveedor REST de datos culinarios a escala global |
| **Blade** | Motor de renderizado y vistas del lado del servidor |
| **JavaScript / Alpine** | Interactividad y actualizaciones asíncronas en el navegador |

---

## Guía de Instalación

### Opción A: con Docker (recomendada, igual que en producción)

```bash
# 1. Clonar el repositorio
git clone https://github.com/fgonmar445/cookly.git
cd cookly

# 2. Configurar variables de entorno
cp .env.example .env
# Rellena APP_KEY, DATABASE_URL (PostgreSQL), CLOUDINARY_URL y las credenciales de Brevo

# 3. Construir la imagen
docker build -t cookly .

# 4. Ejecutar (migra la base de datos automáticamente al arrancar)
docker run --rm -p 8080:8080 --env-file .env -e PORT=8080 cookly

# 5. (Opcional) Sembrar usuarios de prueba
docker run --rm --env-file .env cookly php artisan db:seed --force
```

### Opción B: entorno local sin Docker

```bash
# 1. Clonar el repositorio
git clone https://github.com/fgonmar445/cookly.git
cd cookly

# 2. Instalar dependencias de PHP y Node.js
composer install
npm install
npm run build

# 3. Configurar variables de entorno
cp .env.example .env
php artisan key:generate
# ⚠️ NOTA: Configura tus credenciales de base de datos y Brevo (SMTP) en el archivo .env antes de continuar.

# 4. Preparar la Base de Datos (Migraciones y datos iniciales)
php artisan migrate --seed

# 5. Configurar enlace simbólico para imágenes locales
php artisan storage:link

# 6. Iniciar el servidor de desarrollo
php artisan serve
```

---

## Cuentas de Acceso Rápido

El comando de inicialización (`--seed`) genera de forma completamente automatizada dos usuarios de prueba con sus respectivas contraseñas encriptadas, listos para explorar la plataforma:

| Rol                  | Correo Electrónico | Contraseña | Acceso                             |
| :------------------- | :----------------- | :--------- | :--------------------------------- |
| **Administrador**    | `admin@cookly.com` | `admin123` | Dashboard de Usuario + Panel Admin |
| **Usuario Estándar** | `user@cookly.com`  | `user123`  | Dashboard de Usuario               |

---

## Mapa de Navegación

```mermaid
flowchart TD

    %% ============================
    %% PÁGINA PÚBLICA
    %% ============================
    A[Inicio] --> B[Iniciar sesión]
    A --> C[Registrarse]

    %% AUTENTICACIÓN
    B --> D[Olvidé mi contraseña]
    D --> E[Restablecer contraseña]
    C --> B
    B --> F[Verificar email]
    F --> G[Confirmar contraseña]

    %% ACCESO AL DASHBOARD
    B --> H[Dashboard]

    %% ============================
    %% ZONA PRIVADA (USUARIO)
    %% ============================

    %% INGREDIENTES
    H --> I[Ingredientes]
    I --> I1[Ingredientes principales]
    I --> I2[Mis ingredientes]
    I --> I3[Todos los ingredientes]

    %% FAVORITOS
    H --> J[Mis favoritos]

    %% RECETAS EXTERNAS
    H --> K[Recetas externas]
    K --> K1[Buscar por nombre]
    K --> K2[Buscar por ingredientes]
    K --> K3[Buscar por categorías]
    K --> K4[Buscar por cocina]
    K --> K5[Ver receta]

    %% MIS RECETAS
    H --> L[Mis recetas]
    L --> L1[Crear receta]
    L --> L2[Editar receta]
    L --> L3[Eliminar receta]

    %% RECETAS DE LA COMUNIDAD
    H --> M[Recetas de la comunidad]
    M --> M1[Explorar recetas]
    M --> M2[Ver detalle]

    %% RECETA ALEATORIA
    H --> N[Receta aleatoria]
    N --> N1[Ver receta]

    %% RECOMENDADOR
    H --> O[Recomendador]
    O --> O1[Generar recomendaciones]
    O --> O2[Ver receta]

    %% PERFIL
    H --> R[Perfil]
    R --> R1[Editar perfil]
    R --> R2[Actualizar contraseña]
    R --> R3[Eliminar cuenta]

    %% ============================
    %% ADMINISTRACIÓN
    %% ============================

    H --> P{¿Es administrador?}
    P -->|Sí| Q[Panel admin]
    P -->|No| H

    %% DASHBOARD ADMIN (ESTADÍSTICAS)
    Q --> Q0[Resumen del panel]
    Q0 --> Q0A[Total usuarios]
    Q0 --> Q0B[Total recetas]
    Q0 --> Q0C[Nuevas esta semana]
    Q0 --> Q0D[Total favoritos]

    %% GESTIÓN DE USUARIOS
    Q --> Q1[Gestión de usuarios]
    Q1 --> Q1A[Ver usuarios]
    Q1 --> Q1B[Editar rol]
    Q1 --> Q1C[Eliminar]

    %% GESTIÓN DE RECETAS
    Q --> Q2[Gestión de recetas]
    Q2 --> Q2A[Ver recetas de usuarios]
    Q2 --> Q2C[Eliminar]

    %% GESTIÓN DE INGREDIENTES
    Q --> Q3[Gestión de ingredientes]
    Q3 --> Q3A[Ver ingredientes base]
    Q3 --> Q3B[Crear / Editar]
    Q3 --> Q3C[Eliminar]

    %% LOGS
    Q --> Q4[Logs del sistema]
```

---

<div align="center">
    <p>Desarrollado por <b>Felipe González</b> para el <b>TFG de DAW</b>.</p>
    <p>🔗 <a href="https://cookly-jeke.onrender.com/">Ver demo en vivo</a></p>
</div>

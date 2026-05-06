# Cookly — Tu Asistente de Cocina Inteligente

[![Laravel Version](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.0-38B2AC?style=for-the-badge&logo=tailwind-css)](https://tailwindcss.com)
[![PHP Version](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php)](https://php.net)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg?style=for-the-badge)](https://opensource.org/licenses/MIT)

<img src="./public/cookly_logo_banner.png">

**Cookly** es una plataforma integral diseñada para optimizar la gestión de la cocina doméstica y fomentar la exploración culinaria. Mediante el uso de inteligencia de datos y una interfaz de usuario premium, Cookly permite a los usuarios maximizar el uso de sus ingredientes disponibles, reducir el desperdicio y descubrir nuevas gastronomías de todo el mundo.

---

## Índice

1. [Características Principales](#-características-principales)
2. [Vistas de la Aplicación](#-vistas-de-la-aplicación)
3. [Panel de Administración](#-panel-de-administración)
4. [Tecnologías](#-tecnologías)
5. [Instalación](#-instalación)
6. [Cuentas de Prueba](#-cuentas-de-prueba)
7. [Arquitectura](#-arquitectura)

---

## Características Principales

- **Gestión de Despensa**: Inventario digital de ingredientes con categorización inteligente.
- **Búsqueda Multimodal**: Localiza recetas por nombre, país, categoría o por los ingredientes que ya posees.
- **Generador de Recetas**: Algoritmo que cruza tu despensa con la base de datos global para sugerir platos instantáneos.
- **Comunidad**: Sistema de publicación donde los usuarios pueden compartir sus propias creaciones culinarias.
- **Favoritos Dinámicos**: Biblioteca personal con guardado rápido y sincronización en tiempo real.
- **Aesthetic Emerald Design**: Interfaz moderna, limpia y minimalista optimizada para cualquier dispositivo.

---

## Vistas de la Aplicación

_(En esta sección puedes incluir capturas de pantalla para cada módulo)_

### Landing Page & Dashboard

La puerta de entrada a Cookly, con un diseño hero impactante y un resumen de actividad para el usuario.

> **[CAPTURA: LANDING PAGE]**
> ![Landing Preview](https://via.placeholder.com/800x400?text=Captura+de+la+Landing+Page)

### Despensa y Catálogo

Gestión visual de ingredientes con búsqueda predictiva y selección rápida.

> **[CAPTURA: MI DESPENSA]**
> ![Pantry Preview](https://via.placeholder.com/800x400?text=Captura+de+la+Despensa)

### Buscador de Recetas

Explorador visual con tarjetas detalladas, filtros por región (Cocina Italiana, Japonesa, etc.) y categorías.

> **[CAPTURA: BUSCADOR]**
> ![Search Preview](https://via.placeholder.com/800x400?text=Captura+del+Buscador)

### Detalle de Receta

Vista inmersiva con ingredientes traducidos, instrucciones detalladas y video tutorial (YouTube integration).

> **[CAPTURA: DETALLE DE RECETA]**
> ![Recipe Detail](https://via.placeholder.com/800x400?text=Captura+de+Detalle+de+Receta)

---

## Panel de Administración

Cookly incluye un robusto sistema de gestión para administradores:

- **Estadísticas en Tiempo Real**: Gráficos y contadores de crecimiento de la plataforma.
- **Moderación de Usuarios**: Capacidad para asignar roles (Admin/User) y gestionar bajas.
- **Control de Contenido**: Supervisión de las recetas creadas por la comunidad para garantizar la calidad.
- **Auditoría (Logs)**: Historial detallado de todas las acciones administrativas realizadas.

> **[CAPTURA: ADMIN DASHBOARD]**
> ![Admin Preview](https://via.placeholder.com/800x400?text=Captura+del+Panel+Admin)

---

## Tecnologías

| Tecnología         | Uso                                           |
| :----------------- | :-------------------------------------------- |
| **Laravel 12**     | Core del Framework & Arquitectura MVC         |
| **Tailwind CSS**   | Estilizado premium y diseño responsivo        |
| **MySQL / SQLite** | Persistencia de datos y relaciones complejas  |
| **TheMealDB API**  | Fuente de datos externa para recetas globales |
| **Alpine.js / JS** | Micro-interacciones y dinamismo en el cliente |
| **Blade**          | Motor de plantillas servidor                  |

---

## Instalación

```bash
# 1. Obtener el código
git clone https://github.com/fgonmar445/cookly.git
cd cookly

# 2. Dependencias PHP y JS
composer install
npm install && npm run build

# 3. Entorno
cp .env.example .env
php artisan key:generate

# 4. Base de Datos (Migraciones y Semillas)
php artisan migrate --seed
# 5. Servidor
php artisan serve
```

---

## Cuentas de Prueba

El proyecto incluye un _seeder_ que crea automáticamente las dos cuentas de prueba.  
Esto permite que cualquier persona pueda iniciar sesión sin necesidad de registrar usuarios manualmente.

### Cómo generar los usuarios

1. Configura la base de datos en tu archivo `.env`.
2. Ejecuta las migraciones junto con los seeders:

```bash
php artisan migrate --seed
```

Esto ejecutará el AdminSeeder y creará automáticamente las siguientes cuentas:

| Perfil               | Email              | Password   |
| :------------------- | :----------------- | :--------- |
| **Administrador**    | `admin@cookly.com` | `admin123` |
| **Usuario Estándar** | `user@cookly.com`  | `user123`  |

### ¿Qué hace exactamente el seeder?

- El archivo AdminSeeder.php utiliza updateOrCreate, lo que garantiza que:
- No se duplican usuarios si se ejecuta varias veces.
- Las contraseñas se encriptan automáticamente con bcrypt.
- Los roles se asignan correctamente (admin y user).

## Arquitectura

El proyecto sigue los estándares de **Clean Code** de Laravel:

- **Modelos Eloquent** con relaciones complejas (M:N para ingredientes/recetas).
- **Middleware Personalizado** para la seguridad del panel administrativo.
- **Caché Layer** para optimizar las peticiones a la API externa.
- **Controladores Focused** para una lógica de negocio desacoplada.

---

Desarrollado por **Felipe González** para el **TFG de DAW**.

```

```

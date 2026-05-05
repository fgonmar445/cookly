# 🍳 Cookly — Tu Asistente de Cocina Inteligente

[![Laravel Version](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.0-38B2AC?style=for-the-badge&logo=tailwind-css)](https://tailwindcss.com)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg?style=for-the-badge)](https://opensource.org/licenses/MIT)

**Cookly** es una plataforma moderna diseñada para revolucionar la forma en que cocinas. Utilizando una interfaz premium basada en **Emerald Design**, Cookly te ayuda a gestionar tu despensa, descubrir recetas internacionales y conectar con una comunidad de amantes de la cocina.

---

## ✨ Características Principales

### 👨‍🍳 Para Usuarios
- **Despensa Inteligente**: Gestiona tus ingredientes en tiempo real y recibe sugerencias basadas en lo que tienes.
- **Búsqueda Avanzada**: Filtra miles de platos por nombre, ingredientes, categorías o regiones (TheMealDB API).
- **Comunidad**: Crea, edita y comparte tus propias recetas con otros usuarios.
- **Favoritos**: Guarda tus platos preferidos en una biblioteca personal.
- **Recomendador**: Algoritmo inteligente que sugiere qué cocinar hoy para evitar el desperdicio de comida.

### 🛡️ Panel de Administración
- **Dashboard de Estadísticas**: Visualización de métricas clave (usuarios totales, recetas nuevas, actividad).
- **Gestión de Usuarios**: Control total sobre cuentas, roles (Admin/User) y seguridad.
- **Moderación de Contenido**: Supervisión y eliminación de recetas de la comunidad inapropiadas.
- **Logs de Actividad**: Registro histórico de acciones administrativas para mayor transparencia.

---

## 🚀 Tecnologías

| Capa | Tecnología |
|------|------------|
| **Backend** | Laravel 12 (PHP 8.2+) |
| **Frontend** | Blade Templates + Tailwind CSS (Emerald Theme) |
| **Base de Datos** | MySQL / SQLite |
| **API Externa** | TheMealDB (Global Recipe Database) |
| **Iconografía** | Heroicons & Custom SVG |

---

## 🛠️ Instalación y Configuración

Poner en marcha **Cookly** es muy sencillo:

1. **Clonar el repositorio**
   ```bash
   git clone https://github.com/fgonmar445/cookly.git
   cd cookly
   ```

2. **Instalar dependencias**
   ```bash
   composer install
   npm install && npm run build
   ```

3. **Configurar el entorno**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Base de Datos y Datos Iniciales**
   ```bash
   # Crea tu DB y configura el .env antes de este paso
   php artisan migrate --seed
   
   # Para crear las cuentas de prueba (Admin y User):
   php artisan db:seed --class=AdminSeeder
   ```

5. **Iniciar Servidor**
   ```bash
   php artisan serve
   ```

---

## 🔐 Cuentas de Demostración

| Rol | Email | Password |
|------|-------|----------|
| **Administrador** | `admin@cookly.com` | `admin123` |
| **Usuario Estándar** | `user@cookly.com` | `user123` |

---

## 📸 Interfaz (Aesthetic)

Cookly utiliza un sistema de diseño basado en **Emerald Green**, con un enfoque en la legibilidad y la elegancia:
- **Tipografía**: Outfit (Google Fonts)
- **Componentes**: Tarjetas con bordes `rounded-2xl`, sombras suaves y micro-animaciones.
- **Accesibilidad**: Diseño 100% responsivo.

---

## 📄 Licencia

Este proyecto es de código abierto bajo la licencia [MIT](https://opensource.org/licenses/MIT).

---
Desarrollado como proyecto de **TFG / DAW**. 🥂

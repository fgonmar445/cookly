<p align="center">
  <img src="/public/cookly_logo_banner.png" width="600" alt="Cookly Logo">
</p>

# Cookly

Cookly es tu asistente de cocina definitivo. Descubre miles de recetas, gestiona tus ingredientes y encuentra la inspiración que necesitas para tu próximo plato.

## Características Principales

- **Búsqueda Avanzada**: Encuentra recetas por nombre, categoría, país o incluso por los ingredientes que tienes en tu despensa.
- **Favoritos**: Guarda tus recetas preferidas para acceder a ellas rápidamente en cualquier momento.
- **Receta Aleatoria**: ¿No sabes qué cocinar? ¡Deja que Cookly decida por ti con un solo clic!
- **Recomendador Inteligente**: Cookly analiza los ingredientes que ya tienes y te sugiere las mejores recetas que puedes preparar ahora mismo.
- **Diseño Responsivo**: Una interfaz moderna y limpia diseñada con Tailwind CSS para una experiencia fluida en cualquier dispositivo.

## Tecnologías Utilizadas

- **Framework**: [Laravel 10+](https://laravel.com)
- **Estilos**: [Tailwind CSS](https://tailwindcss.com)
- **API**: [TheMealDB](https://www.themealdb.com/api.php) para una base de datos de recetas global y actualizada.
- **Base de Datos**: MySQL/SQLite para gestionar usuarios, ingredientes y favoritos.

## Instalación y Configuración

Sigue estos pasos para poner en marcha Cookly en tu entorno local:

1. **Clonar el repositorio**:

    ```bash
    git clone https://github.com/fgonmar445/cookly.git
    cd cookly
    ```

2. **Instalar dependencias**:

    ```bash
    composer install
    npm install && npm run dev
    ```

3. **Configurar el entorno**:

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Configurar la base de datos**:
   Crea una base de datos y actualiza las credenciales en el archivo `.env`.

5. **Ejecutar migraciones**:

    ```bash
    php artisan migrate
    ```

6. **Iniciar el servidor**:
    ```bash
    php artisan serve
    ```

## Licencia

Este proyecto está bajo la licencia MIT. Consulta el archivo `LICENSE` para más detalles.

---

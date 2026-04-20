<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Cookly</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

    <!-- NAVBAR -->
    <nav class="bg-white shadow-md p-4 flex justify-between items-center">

        <div class="text-xl font-bold text-green-600">
            🍽 Cookly
        </div>

        <div class="space-x-4">
            <a href="/dashboard" class="text-gray-700 hover:text-green-600">Dashboard</a>
            <a href="/ingredientes" class="text-gray-700 hover:text-green-600">Ingredientes</a>
            <a href="/recetas" class="text-gray-700 hover:text-green-600">Recetas</a>
            <a href="/favoritos" class="text-gray-700 hover:text-green-600">Favoritos</a>
        </div>

    </nav>

    <!-- CONTENIDO -->
    <main class="p-6">

        <div class="max-w-6xl mx-auto bg-white p-6 rounded-xl shadow">

            @yield('content')

        </div>

    </main>

</body>

</html>
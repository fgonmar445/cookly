<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Cookly</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

    <div class="flex">

        <!-- SIDEBAR -->
        <aside class="w-64 bg-white shadow-md min-h-screen p-6">

            <!-- LOGO -->
            <h1 class="text-3xl font-bold text-green-600 mb-8">
                Cookly
            </h1>

            <!-- NAV -->
            <nav class="space-y-3">

                <a href="/dashboard"
                    class="block px-3 py-2 rounded hover:bg-green-100 text-gray-700 hover:text-green-700">
                    Dashboard
                </a>

                <a href="{{ route('ingredientes.index') }}"
                    class="block px-3 py-2 rounded hover:bg-green-100 text-gray-700 hover:text-green-700">
                    Ingredientes principales
                </a>

                <a href="{{ route('ingredientes.todos') }}"
                    class="block px-3 py-2 rounded hover:bg-green-100 text-gray-700 hover:text-green-700">
                    Todos los ingredientes
                </a>

                <a href="{{ route('mis.ingredientes') }}"
                    class="block px-3 py-2 rounded hover:bg-green-100 text-gray-700 hover:text-green-700">
                    Mis ingredientes
                </a>



                <a href="{{ route('buscar') }}"
                    class="block px-3 py-2 rounded hover:bg-green-100 text-gray-700 hover:text-green-700">
                    Buscar recetas
                </a>

                <a href="{{ route('buscar.categorias') }}"
                    class="block px-3 py-2 rounded hover:bg-green-100 text-gray-700 hover:text-green-700">
                    Categorías de recetas
                </a>

                <a href="/favoritos"
                    class="block px-3 py-2 rounded hover:bg-green-100 text-gray-700 hover:text-green-700">
                    Favoritos
                </a>

            </nav>

        </aside>

        <!-- CONTENIDO -->
        <main class="flex-1 p-8">

            <div class="bg-white p-6 rounded-xl shadow">
                @yield('content')
            </div>

        </main>

    </div>

</body>

</html>
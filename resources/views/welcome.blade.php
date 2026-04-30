<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cookly</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-900">

    <div class="min-h-screen flex flex-col">

        <!-- NAV SIMPLE -->
        <header class="flex justify-between items-center px-6 py-4">
            <h1 class="text-xl font-bold text-emerald-600">Cookly</h1>

            <div class="space-x-4 text-sm">
                <a href="{{ route('login') }}" class="bg-emerald-600 text-white px-5 py-3 font-semibold rounded hover:bg-emerald-700 transition">
                    Login
                </a>
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center 
           bg-white border border-emerald-600 text-emerald-600 
           hover:bg-emerald-50 
           px-5 py-3 rounded font-semibold transition-colors">
                    Registro
                </a>
            </div>
        </header>

        <!-- HERO -->
        <main class="flex-1 flex items-center justify-center px-6">

            <div class="text-center max-w-2xl">

                <h2 class="text-4xl md:text-5xl font-bold leading-tight">
                    Descubre recetas con los ingredientes que tienes
                </h2>

                <p class="mt-4 text-gray-500 text-lg">
                    Cookly te permite buscar recetas, guardar favoritos y crear tu propia lista de ingredientes usando TheMealDB.
                </p>

                <div class="mt-6 flex justify-center gap-4">
                    <a href="{{ route('register') }}"
                        class="bg-emerald-600 text-white px-6 py-3 font-semibold rounded hover:bg-emerald-700 transition">
                        Empezar
                    </a>

                    <a href="{{ route('login') }}"
                        class="inline-flex items-center justify-center 
           bg-white border border-emerald-600 text-emerald-600 
           hover:bg-emerald-50 
           px-3 py-1 rounded text-sm font-semibold transition-colors">
                        Iniciar sesión
                    </a>
                </div>

            </div>

        </main>

        <!-- FEATURES -->
        <section class="grid md:grid-cols-3 gap-6 px-6 py-10 max-w-5xl mx-auto">

            <div class="text-center">
                <h3 class="font-semibold text-lg">Ingredientes</h3>
                <p class="text-gray-500 text-sm mt-2">Guarda tus ingredientes personales</p>
            </div>

            <div class="text-center">
                <h3 class="font-semibold text-lg">Recetas</h3>
                <p class="text-gray-500 text-sm mt-2">Busca recetas de TheMealDB</p>
            </div>

            <div class="text-center">
                <h3 class="font-semibold text-lg">Favoritos</h3>
                <p class="text-gray-500 text-sm mt-2">Guarda tus recetas favoritas</p>
            </div>

        </section>

        <!-- FOOTER -->
        <footer class="text-center text-xs text-gray-400 py-6">
            © {{ date('Y') }} Cookly - Proyecto DAW
        </footer>

    </div>

</body>

</html>
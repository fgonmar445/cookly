<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Cookly</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        async function toggleFavorito(id, btn) {
            try {
                let res = await fetch(`/favoritos/toggle/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                let data = await res.json();

                if (data.success) {
                    if (data.isFavorito) {
                        btn.innerHTML = 'Quitar';
                        // Actualizamos la clase si fuera necesario, aunque aquí son iguales
                        if (typeof favoritos !== 'undefined' && Array.isArray(favoritos)) {
                            if (!favoritos.includes(id)) favoritos.push(id);
                        }
                    } else {
                        btn.innerHTML = 'Añadir';
                        if (typeof favoritos !== 'undefined' && Array.isArray(favoritos)) {
                            let index = favoritos.indexOf(id);
                            if (index > -1) favoritos.splice(index, 1);
                        }
                    }

                    // Si estamos en la página de favoritos, recargamos
                    if (window.location.pathname === '/favoritos') {
                        if (typeof cargar === 'function') cargar();
                    }
                }
            } catch (error) {
                console.error("Error toggling favorito:", error);
            }
        }
    </script>
</head>

<body class="bg-gray-100 min-h-screen">

    <div class="flex">

        <!-- SIDEBAR -->
        <aside class="w-64 bg-white shadow-md min-h-screen p-6 sticky top-0 h-screen">

            <!-- LOGO -->
            <h1 class="text-3xl font-bold text-emerald-600 mb-8">
                Cookly
            </h1>

            <!-- NAV -->
            <nav class="space-y-3">

                <a href="/dashboard"
                    class="block px-3 py-2 rounded hover:bg-emerald-100 text-gray-700 hover:text-emerald-700">
                    Dashboard
                </a>

                <a href="{{ route('ingredientes.index') }}"
                    class="block px-3 py-2 rounded hover:bg-emerald-100 text-gray-700 hover:text-emerald-700">
                    Ingredientes principales
                </a>

                <a href="{{ route('ingredientes.todos') }}"
                    class="block px-3 py-2 rounded hover:bg-emerald-100 text-gray-700 hover:text-emerald-700">
                    Todos los ingredientes
                </a>

                <a href="{{ route('mis.ingredientes') }}"
                    class="block px-3 py-2 rounded hover:bg-emerald-100 text-gray-700 hover:text-emerald-700">
                    Mis ingredientes
                </a>



                <a href="{{ route('buscar') }}"
                    class="block px-3 py-2 rounded hover:bg-emerald-100 text-gray-700 hover:text-emerald-700">
                    Buscar recetas
                </a>

                <a href="{{ route('recetas.create') }}"
                    class="block px-3 py-2 rounded hover:bg-emerald-100 text-gray-700 hover:text-emerald-700">
                    Crear receta
                </a>

                <a href="{{ route('recetas.mias') }}"
                    class="block px-3 py-2 rounded hover:bg-emerald-100 text-gray-700 hover:text-emerald-700">
                    Mis recetas
                </a>

                <a href="/favoritos"
                    class="block px-3 py-2 rounded hover:bg-emerald-100 text-gray-700 hover:text-emerald-700">
                    Favoritos
                </a>


            </nav>

            <div class="mt-12">

                {{-- PERFIL --}}
                <a href="{{ route('profile.edit') }}"
                    class="block bg-white border border-emerald-600 text-emerald-600 
           px-4 py-2 rounded-lg font-semibold hover:bg-emerald-50 transition mt-6">
                    Perfil
                </a>

                {{-- LOGOUT --}}
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit"
                        class="w-full bg-red-600 text-white px-4 py-2 rounded-lg font-semibold 
               hover:bg-red-700 transition">
                        Cerrar sesión
                    </button>
                </form>
            </div>


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
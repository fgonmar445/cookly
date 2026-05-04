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
        <aside class="w-64 bg-white shadow-md min-h-screen p-6 sticky top-0 h-screen flex flex-col">

            <!-- LOGO -->
            <h1 class="text-3xl font-bold text-emerald-600 mb-8">
                Cookly
            </h1>

            <!-- CONTENEDOR PRINCIPAL (ocupa todo el espacio disponible) -->
            <div class="flex-1">

                <!-- SECCIÓN: INGREDIENTES -->
                <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Ingredientes</h3>
                <nav class="space-y-1 mb-6">

                    <a href="{{ route('ingredientes.index') }}"
                        class="flex items-center gap-2 px-3 py-1.5 rounded hover:bg-emerald-100 text-gray-700 hover:text-emerald-700 text-sm">
                        <span>Ingredientes principales</span>
                    </a>

                    <a href="{{ route('ingredientes.todos') }}"
                        class="flex items-center gap-2 px-3 py-1.5 rounded hover:bg-emerald-100 text-gray-700 hover:text-emerald-700 text-sm">
                        <span>Todos los ingredientes</span>
                    </a>

                    <a href="{{ route('mis.ingredientes') }}"
                        class="flex items-center gap-2 px-3 py-1.5 rounded hover:bg-emerald-100 text-gray-700 hover:text-emerald-700 text-sm">
                        <span>Mis ingredientes</span>
                    </a>

                </nav>

                <!-- SECCIÓN: RECETAS -->
                <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Recetas</h3>
                <nav class="space-y-1 mb-6">

                    <a href="{{ route('buscar') }}"
                        class="flex items-center gap-2 px-3 py-1.5 rounded hover:bg-emerald-100 text-gray-700 hover:text-emerald-700 text-sm">
                        <span>Buscar recetas</span>
                    </a>

                    <a href="{{ route('recetas.create') }}"
                        class="flex items-center gap-2 px-3 py-1.5 rounded hover:bg-emerald-100 text-gray-700 hover:text-emerald-700 text-sm">
                        <span>Crear receta</span>
                    </a>

                    <a href="{{ route('recetas.mias') }}"
                        class="flex items-center gap-2 px-3 py-1.5 rounded hover:bg-emerald-100 text-gray-700 hover:text-emerald-700 text-sm">
                        <span>Mis recetas</span>
                    </a>

                    <a href="{{ route('recetas.usuarios') }}"
                        class="flex items-center gap-2 px-3 py-1.5 rounded hover:bg-emerald-100 text-gray-700 hover:text-emerald-700 text-sm">
                        <span>Explorar</span>
                    </a>

                    <a href="/favoritos"
                        class="flex items-center gap-2 px-3 py-1.5 rounded hover:bg-emerald-100 text-gray-700 hover:text-emerald-700 text-sm">
                        <span>Favoritos</span>
                    </a>

                </nav>

            </div> <!-- FIN DEL FLEX-1 -->

            <!-- SECCIÓN DE CUENTA (siempre abajo) -->
            <div class="mt-6">

                <a href="{{ route('profile.edit') }}"
                    class="block bg-white border border-emerald-600 text-emerald-600 
                  px-4 py-2 rounded-lg font-semibold hover:bg-emerald-50 transition text-sm">
                    Perfil
                </a>

                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit"
                        class="w-full bg-red-600 text-white px-4 py-2 rounded-lg font-semibold 
                       hover:bg-red-700 transition text-sm">
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
@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-4">Recetas</h1>

<p class="text-gray-600 mb-4">
    Busca recetas por nombre o usa filtros avanzados
</p>

{{-- BUSCADOR + BOTONES --}}
<div class="flex flex-col md:flex-row gap-3 mb-6">

    {{-- BUSCADOR --}}
    <div class="flex-1">
        <input id="search" type="text"
            class="border p-2 rounded w-full mb-2 md:mb-0"
            placeholder="Ej: chicken, pasta, soup...">
    </div>

    <button onclick="buscarNombre()"
        class="bg-blue-500 text-white px-4 py-2 rounded">
        Buscar
    </button>

    {{-- BOTÓN CATEGORÍAS --}}
    <button onclick="togglePanel('panelCategorias')"
        class="bg-green-500 text-white px-4 py-2 rounded">
        Categoría
    </button>

    {{-- BOTÓN ÁREAS --}}
    <button onclick="togglePanel('panelAreas')"
        class="bg-green-500 text-white px-4 py-2 rounded">
        Área
    </button>
</div>

{{-- PANEL CATEGORÍAS --}}
<div id="panelCategorias"
    class="hidden bg-gray-100 p-4 rounded mb-4 transition-all duration-300">

    <h2 class="text-xl font-semibold mb-3">Categorías</h2>

    <form id="filtroCategorias" onsubmit="buscarFiltros(event)">
        <div class="grid grid-cols-2 md:grid-cols-3 gap-2 mb-4">
            @foreach(config('ingredients.categorias') as $key => $value)
            <label class="flex items-center gap-2">
                <input type="checkbox" name="categorias[]" value="{{ $key }}">
                {{ ucfirst($value) }}
            </label>
            @endforeach
        </div>

        <button type="submit"
            class="bg-green-600 text-white px-4 py-2 rounded">
            Aplicar categorías
        </button>
    </form>
</div>

{{-- PANEL ÁREAS --}}
<div id="panelAreas"
    class="hidden    p-4 rounded mb-6 transition-all duration-300">

    <h2 class="text-xl font-semibold mb-3">Áreas</h2>

    <form id="filtroAreas" onsubmit="buscarFiltros(event)">
        <div class="grid grid-cols-2 md:grid-cols-3 gap-2 mb-4">
            @foreach(config('ingredients.areas') as $key => $value)
            <label class="flex items-center gap-2">
                <input type="checkbox" name="areas[]" value="{{ $key }}">
                {{ ucfirst($value) }}
            </label>
            @endforeach
        </div>

        <button type="submit"
            class="bg-green-600 text-white px-4 py-2 rounded">
            Aplicar áreas
        </button>
    </form>
</div>

{{-- RESULTADOS --}}
<div id="lista" class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-4"></div>

<script>
    // ---------------------------------------------------------
    // MOSTRAR / OCULTAR PANEL
    // ---------------------------------------------------------
    function togglePanel(id) {
        document.getElementById(id).classList.toggle('hidden');
    }

    // ---------------------------------------------------------
    // BUSCAR POR NOMBRE
    // ---------------------------------------------------------
    async function buscarNombre() {
        let q = document.getElementById('search').value.trim();
        let cont = document.getElementById('lista');
        cont.innerHTML = '';

        if (q.length === 0) {
            cont.innerHTML = "<p>Introduce un nombre para buscar</p>";
            return;
        }

        let res = await fetch(`https://www.themealdb.com/api/json/v1/1/search.php?s=${q}`);
        let data = await res.json();

        if (!data.meals) {
            cont.innerHTML = "<p>No hay resultados</p>";
            return;
        }

        mostrarResultados(data.meals);
    }

    // ---------------------------------------------------------
    // BUSCAR POR FILTROS (categorías + áreas)
    // ---------------------------------------------------------
    async function buscarFiltros(e) {
        e.preventDefault();

        let form = new FormData(e.target);
        let categorias = form.getAll('categorias[]');
        let areas = form.getAll('areas[]');

        let cont = document.getElementById('lista');
        cont.innerHTML = '';

        let resultados = {};

        // --- Categorías ---
        for (let cat of categorias) {
            let res = await fetch(`https://www.themealdb.com/api/json/v1/1/filter.php?c=${cat}`);
            let data = await res.json();
            if (data.meals) data.meals.forEach(m => resultados[m.idMeal] = m);
        }

        // --- Áreas ---
        for (let area of areas) {
            let res = await fetch(`https://www.themealdb.com/api/json/v1/1/filter.php?a=${area}`);
            let data = await res.json();
            if (data.meals) data.meals.forEach(m => resultados[m.idMeal] = m);
        }

        let final = Object.values(resultados);

        if (final.length === 0) {
            cont.innerHTML = "<p>No hay resultados</p>";
            return;
        }

        mostrarResultados(final);
    }

    // ---------------------------------------------------------
    // MOSTRAR RESULTADOS
    // ---------------------------------------------------------
    function mostrarResultados(lista) {
        let cont = document.getElementById('lista');
        cont.innerHTML = '';

        lista.forEach(r => {
            cont.innerHTML += `
                <div class="bg-white p-3 rounded shadow">
                    <img src="${r.strMealThumb}" class="rounded mb-2">
                    <h3 class="font-bold">${r.strMeal}</h3>

                    <a href="/receta/${r.idMeal}"
                        class="bg-green-500 text-white px-2 py-1 rounded mt-2 inline-block">
                        Ver receta
                    </a>
                </div>
            `;
        });
    }
</script>

@endsection
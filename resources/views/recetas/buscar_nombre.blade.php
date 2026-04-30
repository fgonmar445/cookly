@extends('layouts.app')

@section('content')

<div class="flex justify-end mb-4">
    <a href="{{ route('buscar') }}"
        class="flex items-center gap-1 text-emerald-600 hover:text-emerald-800 border border-emerald-600 px-3 py-1 rounded">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 19l-7-7 7-7" />
        </svg>
        Volver
    </a>
</div>


<h1 class="text-2xl font-bold mb-4">Buscar por nombre</h1>

<p class="text-gray-600 mb-4">
    Escribe el nombre de una receta o parte del nombre.
</p>

<div class="flex-1 max-w-sm gap-3 mb-6">

    <form onsubmit="event.preventDefault(); buscarNombre();" class="flex gap-3 mb-6">
        <input id="search" type="text"
            class="border p-2 rounded w-full
           focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
            placeholder=" Ej: Pasta carbonara...">

        <button type="submit"
            class="bg-emerald-500 text-white px-4 py-2 rounded">
            Buscar
        </button>
    </form>

</div>

<div id="lista" class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-4"></div>

{{-- PLANTILLA PARA JS --}}
<template id="tarjeta-template">
    @include('components.tarjeta-receta', ['r' => null])
</template>

<script>
    const favoritos = @json($favoritos);
    const esToEn = @json(config('ingredients.es_to_en'));

    async function buscarNombre() {
        let q = document.getElementById('search').value.trim().toLowerCase();
        let cont = document.getElementById('lista');
        cont.innerHTML = '';

        if (q.length === 0) {
            cont.innerHTML = "<p>Introduce un nombre para buscar</p>";
            return;
        }

        // Normalizar acentos
        q = q.normalize("NFD").replace(/[\u0300-\u036f]/g, "");

        // Traducir si existe en el diccionario ES → EN
        let q_en = esToEn[q] ?? q;

        // Buscar en inglés
        let res = await fetch(`https://www.themealdb.com/api/json/v2/1/search.php?s=${q_en}`);
        let data = await res.json();

        // Si no encuentra nada, intentar búsqueda parcial
        if (!data.meals) {
            let all = await fetch(`https://www.themealdb.com/api/json/v2/1/search.php?s=`);
            let allData = await all.json();

            if (!allData.meals) {
                cont.innerHTML = "<p>No hay resultados</p>";
                return;
            }

            // Filtrar manualmente por coincidencia en español o inglés
            let filtradas = allData.meals.filter(r =>
                r.strMeal.toLowerCase().includes(q_en) ||
                r.strMeal.toLowerCase().includes(q)
            );

            if (filtradas.length === 0) {
                cont.innerHTML = "<p>No hay resultados</p>";
                return;
            }

            mostrarResultados(filtradas);
            return;
        }

        mostrarResultados(data.meals);

        document.getElementById('search').addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault(); // evita recargar la página
                buscarNombre();
            }
        });

    }


    function mostrarResultados(lista) {
        let cont = document.getElementById('lista');
        let template = document.getElementById('tarjeta-template').innerHTML;
        cont.innerHTML = '';

        lista.forEach(r => {
            let esFavorita = favoritos.includes(r.idMeal);

            let html = template
                .replace(/STR_MEAL_THUMB/g, r.strMealThumb)
                .replace(/STR_MEAL/g, r.strMeal)
                .replace(/ID_MEAL/g, r.idMeal)
                .replace('Añadir', esFavorita ? 'Quitar' : 'Añadir');

            cont.innerHTML += html;
        });
    }

</script>

@endsection
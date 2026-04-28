@extends('layouts.app')

@section('content')

<div class="flex justify-end mb-4">
    <a href="{{ route('buscar') }}"
        class="flex items-center gap-1 text-green-600 hover:text-green-800 border border-green-600 px-3 py-1 rounded">
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

<div class="flex gap-3 mb-6">
    <input id="search" type="text"
        class="border p-2 rounded w-full"
        placeholder="Ej: chicken, pasta, soup...">

    <button onclick="buscarNombre()"
        class="bg-green-500 text-white px-4 py-2 rounded">
        Buscar
    </button>
</div>

<div id="lista" class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-4"></div>

<script>
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
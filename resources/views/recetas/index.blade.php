@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-4">Recetas</h1>

<p class="text-gray-600 mb-4">
    Busca recetas por nombre
</p>

<input id="search" type="text"
    class="border p-2 rounded w-full mb-4"
    placeholder="Ej: chicken">

<button onclick="buscar()"
    class="bg-blue-500 text-white px-4 py-2 rounded">
    Buscar
</button>

<div id="lista" class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-4"></div>

<script>
    async function buscar() {
        let q = document.getElementById('search').value;

        let res = await fetch(`https://www.themealdb.com/api/json/v1/1/search.php?s=${q}`);
        let data = await res.json();

        let cont = document.getElementById('lista');
        cont.innerHTML = '';

        if (!data.meals) {
            cont.innerHTML = "<p>No hay resultados</p>";
            return;
        }

        data.meals.forEach(r => {
            cont.innerHTML += `
            <div class="bg-white p-3 rounded shadow">
                <img src="${r.strMealThumb}" class="rounded mb-2">
                <h3 class="font-bold">${r.strMeal}</h3>

                <button class="bg-green-500 text-white px-2 py-1 rounded mt-2">
                    Ver receta
                </button>
            </div>
        `;
        });
    }
</script>

@endsection
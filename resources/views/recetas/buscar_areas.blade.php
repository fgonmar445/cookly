@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-4">Buscar por área</h1>

<p class="text-gray-600 mb-4">
    Selecciona un país o región para ver sus recetas típicas.
</p>

<div class="grid grid-cols-2 md:grid-cols-3 gap-3">
    @foreach(config('ingredients.areas') as $key => $value)
    <button onclick="buscarArea('{{ $key }}')"
        class="bg-blue-500 text-white p-3 rounded">
        {{ ucfirst($value) }}
    </button>
    @endforeach
</div>

<div id="lista" class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-6"></div>

<script>
    async function buscarArea(area) {
        let cont = document.getElementById('lista');
        cont.innerHTML = '';

        let res = await fetch(`https://www.themealdb.com/api/json/v1/1/filter.php?a=${area}`);
        let data = await res.json();

        if (!data.meals) {
            cont.innerHTML = "<p>No hay recetas en esta área</p>";
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
                    class="bg-blue-500 text-white px-2 py-1 rounded mt-2 inline-block">
                    Ver receta
                </a>
            </div>
        `;
        });
    }
</script>

@endsection
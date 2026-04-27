@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-4">Recomendador de recetas</h1>

<p class="text-gray-600 mb-4">
    Selecciona los ingredientes que tienes y te mostraremos las recetas más compatibles.
</p>

{{-- LISTA DE INGREDIENTES --}}
<div id="ingredientes" class="grid grid-cols-2 md:grid-cols-4 gap-2 mb-4">
    @foreach(config('ingredients.es_to_en') as $es => $en)
    <label class="bg-white p-2 rounded shadow cursor-pointer flex items-center gap-2">
        <input type="checkbox" value="{{ $es }}" onchange="toggleIngrediente(this)">
        {{ ucfirst($es) }}
    </label>
    @endforeach
</div>

<button onclick="recomendar()"
    class="bg-green-600 text-white px-4 py-2 rounded mt-4">
    Buscar recetas recomendadas
</button>

{{-- RESULTADOS --}}
<div id="resultados" class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-6"></div>

<script>
    const dictES_EN = @json(config('ingredients.es_to_en'));
    let seleccionados = [];

    // ---------------------------------------------------------
    // SELECCIONAR / DESELECCIONAR INGREDIENTES
    // ---------------------------------------------------------
    function toggleIngrediente(el) {
        let nombre = el.value;

        if (el.checked) {
            seleccionados.push(nombre);
        } else {
            seleccionados = seleccionados.filter(i => i !== nombre);
        }
    }

    // ---------------------------------------------------------
    // RECOMENDAR RECETAS
    // ---------------------------------------------------------
    async function recomendar() {
        let cont = document.getElementById('resultados');
        cont.innerHTML = '';

        if (seleccionados.length === 0) {
            cont.innerHTML = "<p>Selecciona al menos un ingrediente</p>";
            return;
        }

        let mapaRecetas = {}; // idMeal → { datos, coincidencias }

        for (let ing of seleccionados) {
            let ingEN = dictES_EN[ing] ?? ing;

            let res = await fetch(`https://www.themealdb.com/api/json/v1/1/filter.php?i=${ingEN}`);
            let data = await res.json();

            if (!data.meals) continue;

            data.meals.forEach(r => {
                if (!mapaRecetas[r.idMeal]) {
                    mapaRecetas[r.idMeal] = {
                        datos: r,
                        coincidencias: 0
                    };
                }
                mapaRecetas[r.idMeal].coincidencias++;
            });
        }

        let lista = Object.values(mapaRecetas);

        if (lista.length === 0) {
            cont.innerHTML = "<p>No encontramos recetas con esos ingredientes</p>";
            return;
        }

        // Ordenar por coincidencias (más relevantes primero)
        lista.sort((a, b) => b.coincidencias - a.coincidencias);

        // Mostrar resultados
        lista.forEach(item => {
            let r = item.datos;

            cont.innerHTML += `
                <div class="bg-white p-3 rounded shadow">
                    <img src="${r.strMealThumb}" class="rounded mb-2">
                    <h3 class="font-bold">${r.strMeal}</h3>

                    <p class="text-sm text-gray-600 mb-2">
                        Coincidencias: <strong>${item.coincidencias}</strong>
                    </p>

                    <a href="/receta/${r.idMeal}"
                        class="bg-green-500 text-white px-2 py-1 rounded inline-block">
                        Ver receta
                    </a>
                </div>
            `;
        });
    }
</script>

@endsection
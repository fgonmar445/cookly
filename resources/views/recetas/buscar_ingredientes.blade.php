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



<h1 class="text-2xl font-bold mb-4">Buscar por ingredientes</h1>

<p class="text-gray-600 mb-4">
    Escribe un ingrediente y añádelo a la lista. Puedes seleccionar varios.
</p>

{{-- INPUT + SUGERENCIAS --}}
<div class="relative mb-4">
    <input id="inputIng" type="text"
        class="border p-2 rounded w-full"
        placeholder="Ej: pollo, tomate, arroz..."
        oninput="buscarSugerencias()">

    <div id="sugerencias"
        class="absolute bg-white border rounded w-full mt-1 hidden z-10"></div>
</div>

{{-- TAGS SELECCIONADOS --}}
<div id="tags" class="flex flex-wrap gap-2 mb-4"></div>

<button onclick="buscarPorIngredientes()"
    class="bg-blue-600 text-white px-4 py-2 rounded">
    Buscar recetas
</button>

{{-- RESULTADOS --}}
<div id="lista" class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-6"></div>

<script>
    // Cargar diccionarios desde config/ingredients.php
    const dictES_EN = (config('ingredients.es_to_en'));
    const dictEN_ES = (config('ingredients.en_to_es'));

    let ingredientesSeleccionados = [];

    // ---------------------------------------------------------
    // AUTOCOMPLETADO
    // ---------------------------------------------------------
    function buscarSugerencias() {
        let q = document.getElementById('inputIng').value.toLowerCase();
        let box = document.getElementById('sugerencias');

        if (q.length < 2) {
            box.classList.add('hidden');
            return;
        }

        // Filtrar ingredientes del diccionario ES → EN
        let sugerencias = Object.keys(dictES_EN)
            .filter(i => i.startsWith(q))
            .slice(0, 8);

        if (sugerencias.length === 0) {
            box.classList.add('hidden');
            return;
        }

        box.innerHTML = sugerencias.map(s =>
            `<div class="p-2 hover:bg-gray-200 cursor-pointer"
                  onclick="addIngrediente('${s}')">${s}</div>`
        ).join('');

        box.classList.remove('hidden');
    }

    // ---------------------------------------------------------
    // AÑADIR INGREDIENTE COMO TAG
    // ---------------------------------------------------------
    function addIngrediente(nombre) {
        if (!ingredientesSeleccionados.includes(nombre)) {
            ingredientesSeleccionados.push(nombre);
            renderTags();
        }

        document.getElementById('inputIng').value = '';
        document.getElementById('sugerencias').classList.add('hidden');
    }

    function renderTags() {
        let cont = document.getElementById('tags');
        cont.innerHTML = '';

        ingredientesSeleccionados.forEach(ing => {
            cont.innerHTML += `
                <span class="bg-purple-200 text-purple-800 px-2 py-1 rounded flex items-center gap-2">
                    ${ing}
                    <button onclick="removeIngrediente('${ing}')" class="font-bold">×</button>
                </span>
            `;
        });
    }

    function removeIngrediente(nombre) {
        ingredientesSeleccionados = ingredientesSeleccionados.filter(i => i !== nombre);
        renderTags();
    }

    // ---------------------------------------------------------
    // BUSCAR RECETAS POR TODOS LOS INGREDIENTES
    // ---------------------------------------------------------
    async function buscarPorIngredientes() {
        let cont = document.getElementById('lista');
        cont.innerHTML = '';

        if (ingredientesSeleccionados.length === 0) {
            cont.innerHTML = "<p>Selecciona al menos un ingrediente</p>";
            return;
        }

        let resultados = [];

        for (let ing of ingredientesSeleccionados) {
            // Traducir ES → EN usando tu diccionario real
            let ingEN = dictES_EN[ing] ?? ing;

            let res = await fetch(`https://www.themealdb.com/api/json/v1/1/filter.php?i=${ingEN}`);
            let data = await res.json();

            if (!data.meals) {
                cont.innerHTML = `<p>No hay recetas con ${ing}</p>`;
                return;
            }

            resultados.push(data.meals);
        }

        // Intersección: recetas que contienen TODOS los ingredientes
        let comunes = resultados.reduce((a, b) =>
            a.filter(x => b.some(y => y.idMeal === x.idMeal))
        );

        if (comunes.length === 0) {
            cont.innerHTML = "<p>No hay recetas que contengan todos esos ingredientes</p>";
            return;
        }

        mostrarResultados(comunes);
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
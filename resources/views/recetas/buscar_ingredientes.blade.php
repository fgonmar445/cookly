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



<h1 class="text-2xl font-bold mb-4">Buscar por ingredientes</h1>

<p class="text-gray-600 mb-4">
    Escribe un ingrediente y añádelo a la lista. Puedes seleccionar varios.
</p>

{{-- INPUT + SUGERENCIAS --}}
<div class="relative mb-4">
    <input id="inputIng" type="text"
        class="border p-2 rounded w-full"
        placeholder="Ej: Pollo, Tomate, Arroz..."
        oninput="buscarSugerencias()">

    <div id="sugerencias"
        class="absolute bg-white border rounded w-full mt-1 hidden z-10"></div>
</div>

{{-- TAGS SELECCIONADOS --}}
<div id="tags" class="flex flex-wrap gap-2 mb-4"></div>

<button onclick="buscarPorIngredientes()"
    class="bg-emerald-600 text-white px-4 py-2 rounded">
    Buscar recetas
</button>

{{-- RESULTADOS --}}
<div id="lista" class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-6"></div>

<script>
    // Cargar diccionarios desde config/ingredients.php
    const dictES_EN = @json(config('ingredients.es_to_en'));
    const dictEN_ES = @json(config('ingredients.en_to_es'));

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

        box.innerHTML = sugerencias.map(s => {
            let sCap = capitalizar(s);
            return `<div class="p-2 hover:bg-gray-200 cursor-pointer"
                  onclick="addIngrediente('${s}')">${sCap}</div>`
        }).join('');

        box.classList.remove('hidden');
    }

    // ---------------------------------------------------------
    // AÑADIR INGREDIENTE COMO TAG
    // ---------------------------------------------------------
    function capitalizar(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

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
            let ingCap = capitalizar(ing);
            cont.innerHTML += `
                <span class="bg-white border border-emerald-600 text-emerald-600 px-2 py-1 rounded flex items-center gap-2">
                    ${ingCap}
                    <button onclick="removeIngrediente('${ingCap}')" class="font-bold">×</button>
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
        // resultados = array con listas de recetas por ingrediente

        // 1. INTERSECCIÓN (recetas que contienen TODOS los ingredientes)
        let interseccion = resultados.reduce((a, b) =>
            a.filter(x => b.some(y => y.idMeal === x.idMeal))
        );

        // 2. UNIÓN (recetas que contienen AL MENOS UNO)
        let union = [];
        resultados.forEach(lista => {
            lista.forEach(r => {
                if (!union.some(x => x.idMeal === r.idMeal)) {
                    union.push(r);
                }
            });
        });

        // 3. Si hay intersección, ponerlas primero
        let final = [...interseccion, ...union.filter(r =>
            !interseccion.some(i => i.idMeal === r.idMeal)
        )];

        mostrarResultados(final);
    }

    const favoritos = @json($favoritos);

    // ---------------------------------------------------------
    // MOSTRAR RESULTADOS
    // ---------------------------------------------------------
    function mostrarResultados(lista) {
        let cont = document.getElementById('lista');
        cont.innerHTML = '';

        lista.forEach(r => {
            let esFavorita = favoritos.includes(r.idMeal);

            cont.innerHTML += `
                <div class="bg-white p-3 rounded shadow">
                    <img src="${r.strMealThumb}" class="rounded mb-2">
                    <h3 class="font-bold mb-2">${r.strMeal}</h3>

                    <div class="flex justify-between items-center mt-2">

                        <a href="/receta/${r.idMeal}"
                            class="bg-emerald-600 text-white px-3 py-1 rounded inline-block text-sm">
                            Ver receta
                        </a>

                        <button onclick="toggleFavorito('${r.idMeal}', this)"
                            class="inline-flex items-center justify-center bg-white border border-emerald-600 text-emerald-600 hover:bg-emerald-50 px-3 py-1 rounded text-sm font-semibold transition-colors ">
                            ${esFavorita ? 'Quitar' : 'Añadir'}
                        </button>
                    </div>
                </div>
            `;
        });
    }

    async function toggleFavorito(id, btn) {
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
                btn.className = "inline-flex items-center justify-center bg-white border border-emerald-600 text-emerald-600 hover:bg-emerald-50 px-3 py-1 rounded text-sm font-semibold transition-colors ";
                if (!favoritos.includes(id)) favoritos.push(id);
            } else {
                btn.innerHTML = 'Añadir';
                btn.className = "inline-flex items-center justify-center bg-white border border-emerald-600 text-emerald-600 hover:bg-emerald-50 px-3 py-1 rounded text-sm font-semibold transition-colors ";
                let index = favoritos.indexOf(id);
                if (index > -1) favoritos.splice(index, 1);
            }
        }
    }
</script>

@endsection
@extends('layouts.app')

@section('content')

<div class="flex justify-start mb-8">
    <a href="{{ route('buscar') }}"
        class="inline-flex items-center gap-2 text-slate-500 hover:text-emerald-600 font-bold text-sm transition-all group">
        <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center group-hover:bg-emerald-50 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </div>
        Volver al explorador
    </a>
</div>

<div class="mb-10">
    <h1 class="text-3xl font-black text-slate-800 mb-2 tracking-tight">Buscar por ingredientes</h1>
    <p class="text-slate-500">Añade los ingredientes que tienes y nosotros encontraremos la receta perfecta.</p>
</div>

{{-- INPUT + SUGERENCIAS --}}
<div class="max-w-3xl mb-12">
    <form onsubmit="event.preventDefault(); buscarPorIngredientes();" class="flex flex-col md:flex-row gap-4">
        <div class="relative flex-1">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <input id="inputIng" type="text"
                class="block w-full pl-11 pr-4 py-4 bg-white border border-slate-100 rounded-2xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all shadow-sm"
                placeholder="Ej: Pollo, Tomate, Arroz..."
                oninput="buscarSugerencias()">

            <div id="sugerencias"
                class="absolute left-0 right-0 bg-white border border-slate-100 rounded-2xl mt-2 hidden z-20 shadow-xl overflow-hidden"></div>
        </div>

        <button type="submit"
            class="px-8 py-4 bg-emerald-600 text-white font-bold rounded-2xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-600/20 active:scale-95 whitespace-nowrap">
            Buscar Recetas
        </button>
    </form>
    
    <div id="tags" class="flex flex-wrap gap-2 mt-6"></div>
</div>


{{-- RESULTADOS --}}
<div id="lista" class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-6"></div>

{{-- PLANTILLA PARA JS --}}
<template id="tarjeta-template">
    @include('components.tarjeta-receta', ['r' => null])
</template>

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
            return `<div class="p-4 hover:bg-emerald-50 hover:text-emerald-700 cursor-pointer transition-colors border-b border-slate-50 last:border-0 font-medium"
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
        nombre = nombre.toLowerCase(); // normalizar SIEMPRE

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
            <span class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-50 text-emerald-700 rounded-xl font-bold text-xs border border-emerald-100 shadow-sm animate-in fade-in zoom-in duration-300">
                ${ingCap}
                <button onclick="removeIngrediente('${ing}')" class="w-5 h-5 flex items-center justify-center hover:bg-emerald-200 rounded-full transition-colors">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </span>
        `;
        });
    }


    function removeIngrediente(nombre) {
        nombre = nombre.toLowerCase();
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

        // Mapeos para ampliar búsqueda sin descargar toda la base
        const categoriasRelacionadas = {
            'pasta': ['Pasta'],
            'spaghetti': ['Pasta'],
            'fideos': ['Miscellaneous'],
            'noodles': ['Miscellaneous'],
            'arroz': ['Side'],
            'arroz arborio': ['Side'],
            'queso': ['Vegetarian'],
            'carne': ['Beef', 'Pork', 'Chicken'],
            'pescado': ['Seafood'],
        };

        const areasRelacionadas = {
            'pasta': ['Italian'],
            'spaghetti': ['Italian'],
            'risotto': ['Italian'],
            'arroz': ['Chinese', 'Japanese', 'Indian'],
            'fideos': ['Chinese', 'Thai'],
            'noodles': ['Chinese', 'Thai'],
            'curry': ['Indian'],
        };

        for (let ing of ingredientesSeleccionados) {

            // Normalizar el ingrediente seleccionado como tag
            let original = ing; // por si quieres mostrarlo luego
            ing = ing.toLowerCase().trim();

            // Correcciones de palabras comunes del usuario
            const equivalenciasBusqueda = {
                'pasta': 'pasta',
                'pasta cocida': 'pasta',
                'espagueti': 'spaghetti',
                'espaguetis': 'spaghetti',
                'spagueti': 'spaghetti',
                'spaguetti': 'spaghetti',
                'spagetti': 'spaghetti',
                'fideo': 'noodles',
                'fideos': 'noodles'
            };

            // Si existe equivalencia, reemplazar
            if (equivalenciasBusqueda[ing]) {
                ing = equivalenciasBusqueda[ing];
            }


            // Traducir ES → EN usando tu diccionario real
            let ingEN = dictES_EN[ing] ?? ing;

            // 1) Buscar por ingrediente principal
            let res = await fetch(`https://www.themealdb.com/api/json/v2/1/filter.php?i=${ingEN}`);
            let data = await res.json();

            if (data.meals) {
                resultados.push(data.meals);
                continue;
            }

            // 2) Buscar por nombre
            let resName = await fetch(`https://www.themealdb.com/api/json/v2/1/search.php?s=${ing}`);
            let dataName = await resName.json();

            if (dataName.meals) {
                resultados.push(dataName.meals);
                continue;
            }

            // 3) Buscar por categoría relacionada
            let cats = categoriasRelacionadas[ing] || [];
            let catResults = [];

            for (let c of cats) {
                let resCat = await fetch(`https://www.themealdb.com/api/json/v2/1/filter.php?c=${c}`);
                let dataCat = await resCat.json();
                if (dataCat.meals) catResults.push(...dataCat.meals);
            }

            if (catResults.length > 0) {
                resultados.push(catResults);
                continue;
            }

            // 4) Buscar por área relacionada
            let ars = areasRelacionadas[ing] || [];
            let areaResults = [];

            for (let a of ars) {
                let resArea = await fetch(`https://www.themealdb.com/api/json/v2/1/filter.php?a=${a}`);
                let dataArea = await resArea.json();
                if (dataArea.meals) areaResults.push(...dataArea.meals);
            }

            if (areaResults.length > 0) {
                resultados.push(areaResults);
                continue;
            }

            // 5) Si no hay nada de nada
            cont.innerHTML = `<p>No hay recetas con ${ing}</p>`;
            return;
        }

        // INTERSECCIÓN (recetas que contienen TODOS los ingredientes)
        let interseccion = resultados.reduce((a, b) =>
            a.filter(x => b.some(y => y.idMeal === x.idMeal))
        );

        // UNIÓN (recetas que contienen AL MENOS UNO)
        let union = [];
        resultados.forEach(lista => {
            lista.forEach(r => {
                if (!union.some(x => x.idMeal === r.idMeal)) {
                    union.push(r);
                }
            });
        });

        // Final: intersección primero, luego unión sin duplicados
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
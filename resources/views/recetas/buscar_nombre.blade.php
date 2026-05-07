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
    <h1 class="text-3xl font-black text-slate-800 mb-2 tracking-tight">Buscar por nombre</h1>
    <p class="text-slate-500">Encuentra tu próxima comida favorita entre miles de recetas internacionales.</p>
</div>

<div class="max-w-2xl mb-12">
    <form onsubmit="event.preventDefault(); buscarNombre();" class="flex gap-3">
        <div class="relative flex-1">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input id="search" type="text"
                class="block w-full pl-11 pr-4 py-4 bg-white border border-slate-100 rounded-2xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all shadow-sm"
                placeholder="Ej: Pasta carbonara, Tacos, Sushi...">
        </div>

        <button type="submit"
            class="px-8 py-4 bg-emerald-600 text-white font-bold rounded-2xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-600/20 active:scale-95">
            Buscar Receta
        </button>
    </form>
</div>

<div id="lista" class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-4"></div>

{{-- PLANTILLA PARA JS --}}
<template id="tarjeta-template">
    @include('components.tarjeta-receta', ['r' => null])
</template>

<script>
    let favoritos = @json($favoritos ?? []);
    if (!Array.isArray(favoritos)) favoritos = [];
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
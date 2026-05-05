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
    <h1 class="text-3xl font-black text-slate-800 mb-2 tracking-tight">Recomendador inteligente</h1>
    <p class="text-slate-500">Analizamos tu despensa para sugerirte las mejores recetas que puedes cocinar ahora mismo.</p>
</div>

@php
// 1. Obtener IDs de ingredientes del usuario desde lista_ingredientes
$misIngredientes = DB::table('lista_ingredientes')
->where('id_usuario', auth()->id())
->pluck('id_ingrediente')
->toArray();

// 2. Obtener nombres EN directamente (tu tabla ya está en inglés)
$ingredientesGlobales = DB::table('ingredientes')
->whereIn('id_ingrediente', $misIngredientes)
->pluck('nombre')
->toArray();

// 3. Lista de ingredientes que TheMealDB soporta en filter.php
$ingredientesValidos = [
"chicken","beef","pork","lamb","salmon","tuna","shrimp",
"pasta","rice","egg","milk","cheese"
];

// 4. Normalizar ingredientes complejos
$ingredientesEN = [];

foreach ($ingredientesGlobales as $ing) {
$ing = strtolower(trim($ing));

// Normalización automática
if (str_contains($ing, "chicken")) $ing = "chicken";
if (str_contains($ing, "pork")) $ing = "pork";
if (str_contains($ing, "salmon")) $ing = "salmon";
if (str_contains($ing, "tuna")) $ing = "tuna";
if (str_contains($ing, "shrimp")) $ing = "shrimp";
if (str_contains($ing, "rice")) $ing = "rice";
if (str_contains($ing, "pasta")) $ing = "pasta";
if (str_contains($ing, "egg")) $ing = "egg";
if (str_contains($ing, "milk")) $ing = "milk";
if (str_contains($ing, "cheese")) $ing = "cheese";

// Solo añadir si es válido
if (in_array($ing, $ingredientesValidos)) {
$ingredientesEN[] = $ing;
}
}
@endphp

@if(empty($ingredientesEN))
<p class="text-red-500">No tienes ingredientes compatibles con el recomendador.</p>
<p class="text-gray-600">Añade ingredientes como pollo, pasta, arroz, salmón, etc.</p>
@else

<button onclick="recomendar()"
    class="inline-flex items-center px-8 py-4 bg-emerald-600 text-white font-bold rounded-2xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-600/20 active:scale-95 mb-12">
    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
    </svg>
    Generar Recomendaciones
</button>

<div id="resultados" class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-6"></div>

@endif

{{-- PLANTILLA PARA JS --}}
<template id="tarjeta-template">
    @include('components.tarjeta-receta', [
    'r' => [
    'extraHtml' => 'EXTRA_HTML'
    ]
    ])
</template>

<script>
    const ingredientes = @json($ingredientesEN);
    const favoritos = @json($favoritos);

    async function recomendar() {
        let cont = document.getElementById('resultados');
        cont.innerHTML = '';

        let mapa = {}; // idMeal → { datos, coincidencias }

        for (let ing of ingredientes) {
            let res = await fetch(`https://www.themealdb.com/api/json/v1/1/filter.php?i=${ing}`);
            let data = await res.json();

            if (!data.meals) continue;

            data.meals.forEach(r => {
                if (!mapa[r.idMeal]) {
                    mapa[r.idMeal] = {
                        datos: r,
                        coincidencias: 0
                    };
                }
                mapa[r.idMeal].coincidencias++;
            });
        }

        let lista = Object.values(mapa);

        if (lista.length === 0) {
            cont.innerHTML = "<p>No encontramos recetas con tus ingredientes.</p>";
            return;
        }

        lista.sort((a, b) => b.coincidencias - a.coincidencias);

        let template = document.getElementById('tarjeta-template').innerHTML;

        lista.forEach(item => {
            let r = item.datos;
            let esFavorita = favoritos.includes(r.idMeal);

            let extraHtml = `
                <p class="text-xs text-gray-500 mb-2">
                    Coincidencias: <strong>${item.coincidencias}</strong>
                </p>
            `;

            let html = template
                .replace(/STR_MEAL_THUMB/g, r.strMealThumb)
                .replace(/STR_MEAL/g, r.strMeal)
                .replace(/ID_MEAL/g, r.idMeal)
                .replace('EXTRA_HTML', extraHtml)
                .replace('Añadir', esFavorita ? 'Quitar' : 'Añadir');

            cont.innerHTML += html;
        });
    }
</script>

@endsection
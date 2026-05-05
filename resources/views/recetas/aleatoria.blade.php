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
    <h1 class="text-3xl font-black text-slate-800 mb-2 tracking-tight">Receta aleatoria</h1>
    <p class="text-slate-500 text-sm">¿No sabes qué cocinar? Deja que el azar decida tu próxima gran cena.</p>
</div>

<div class="flex flex-col items-start">
    <button onclick="cargarAleatoria()"
        class="inline-flex items-center px-10 py-5 bg-emerald-600 text-white font-black rounded-3xl hover:bg-emerald-700 transition-all shadow-xl shadow-emerald-600/20 active:scale-95 mb-12">
        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
        </svg>
        ¡Sorpréndeme con algo nuevo!
    </button>

    <div id="resultado" class="w-full max-w-md animate-fade-in"></div>
</div>

{{-- PLANTILLA PARA JS --}}
<template id="tarjeta-template">
    @include('components.tarjeta-receta', ['r' => null])
</template>

<script>
    const favoritos = @json($favoritos);

    async function cargarAleatoria() {
        let res = await fetch("https://www.themealdb.com/api/json/v2/1/random.php");
        let data = await res.json();

        if (!data.meals) return;

        let r = data.meals[0];
        let esFavorita = favoritos.includes(r.idMeal);

        // Pintar el card usando la plantilla
        let template = document.getElementById('tarjeta-template').innerHTML;
        let html = template
            .replace(/STR_MEAL_THUMB/g, r.strMealThumb)
            .replace(/STR_MEAL/g, r.strMeal)
            .replace(/ID_MEAL/g, r.idMeal)
            .replace('Añadir', esFavorita ? 'Quitar' : 'Añadir');

        document.getElementById('resultado').innerHTML = html;
    }

</script>

@endsection
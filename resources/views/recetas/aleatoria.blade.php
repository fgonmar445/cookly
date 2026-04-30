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



<h1 class="text-2xl font-bold mb-4">Receta aleatoria</h1>

<button onclick="cargarAleatoria()"
    class="bg-emerald-600 text-white px-4 py-2 rounded mb-4">
    Obtener receta aleatoria
</button>

<div id="resultado"></div>

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
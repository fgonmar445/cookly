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
    <h1 class="text-3xl font-black text-slate-800 mb-2 tracking-tight">Buscar por categoría</h1>
    <p class="text-slate-500">Explora platos filtrados por tipo de cocina o estilo de alimento.</p>
</div>

<div class="flex flex-wrap gap-2 mb-12">
    @foreach(config('ingredients.categorias') as $key => $value)
    <button onclick="buscarCategoria('{{ $key }}')"
        class="inline-flex items-center px-5 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl text-sm font-bold hover:border-emerald-500 hover:text-emerald-600 hover:bg-emerald-50 transition-all shadow-sm active:scale-95">
        {{ ucfirst($value) }}
    </button>
    @endforeach
</div>

<div id="lista" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8 mt-6"></div>

{{-- PLANTILLA PARA JS --}}
<template id="tarjeta-template">
    @include('components.tarjeta-receta', ['r' => null])
</template>

<script>
    const favoritos = @json($favoritos);

    async function buscarCategoria(cat) {
        let cont = document.getElementById('lista');
        cont.innerHTML = '';

        let res = await fetch(`https://www.themealdb.com/api/json/v1/1/filter.php?c=${cat}`);
        let data = await res.json();

        if (!data.meals) {
            cont.innerHTML = "<p>No hay recetas en esta categoría</p>";
            return;
        }

        mostrarResultados(data.meals);
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
@extends('layouts.app')

@section('content')

<div class="flex justify-end mb-4">
    <a href="{{ route('buscar') }}" class="flex items-center gap-1 text-blue-600 hover:text-blue-800 mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        Volver
    </a>
</div>


<h1 class="text-2xl font-bold mb-4">Receta aleatoria</h1>

<button onclick="cargarAleatoria()"
    class="bg-green-600 text-white px-4 py-2 rounded mb-4">
    Obtener receta aleatoria
</button>

<div id="resultado"></div>

<script>
    async function cargarAleatoria() {
        let res = await fetch("https://www.themealdb.com/api/json/v1/1/random.php");
        let data = await res.json();

        if (!data.meals) return;

        let r = data.meals[0];

        document.getElementById('resultado').innerHTML = `
        <div class="bg-white p-4 rounded shadow">
            <img src="${r.strMealThumb}" class="rounded mb-2 w-64 h-64 object-cover">
            <h2 class="text-xl font-bold mb-2">${r.strMeal}</h2>
            <a href="/receta/${r.idMeal}?name=${encodeURIComponent(r.strMeal)}"
                class="bg-green-600 text-white px-3 py-1 rounded inline-block">
                Ver receta completa
            </a>
        </div>
    `;
    }
</script>

@endsection
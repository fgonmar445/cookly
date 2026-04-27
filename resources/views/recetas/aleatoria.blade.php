@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-4">Receta aleatoria</h1>

<button onclick="cargarAleatoria()"
    class="bg-pink-600 text-white px-4 py-2 rounded mb-4">
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
            <img src="${r.strMealThumb}" class="rounded mb-2">
            <h2 class="text-xl font-bold mb-2">${r.strMeal}</h2>
            <a href="/receta/${r.idMeal}"
                class="bg-pink-600 text-white px-3 py-1 rounded inline-block">
                Ver receta completa
            </a>
        </div>
    `;
    }
</script>

@endsection
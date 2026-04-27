@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-4">Recomendador</h1>

<p class="text-gray-600 mb-4">
    Te recomendamos recetas basadas en los ingredientes que ya tienes en tu lista.
</p>

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
    class="bg-green-600 text-white px-4 py-2 rounded">
    Buscar recetas recomendadas
</button>

<div id="resultados" class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-6"></div>

@endif

<script>
    const ingredientes = @json($ingredientesEN);

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

        lista.forEach(item => {
            let r = item.datos;

            cont.innerHTML += `
                <div class="bg-white p-3 rounded shadow">
                    <img src="${r.strMealThumb}" class="rounded mb-2">
                    <h3 class="font-bold">${r.strMeal}</h3>

                    <p class="text-sm text-gray-600 mb-2">
                        Coincidencias: <strong>${item.coincidencias}</strong>
                    </p>

                    <a href="/receta/${r.idMeal}?name=${encodeURIComponent(r.strMeal)}"
                        class="bg-green-500 text-white px-2 py-1 rounded inline-block">
                        Ver receta
                    </a>
                </div>
            `;
        });
    }
</script>

@endsection
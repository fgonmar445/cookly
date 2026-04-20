@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-4">Recomendador</h1>

<p class="text-gray-600 mb-4">
    Selecciona ingredientes y encuentra recetas
</p>

<div id="ingredientes" class="grid grid-cols-2 md:grid-cols-4 gap-2"></div>

<button onclick="recomendar()"
    class="bg-green-600 text-white px-4 py-2 rounded mt-4">
    Buscar recetas
</button>

<div id="resultados" class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-4"></div>

<script>
    let seleccionados = [];

    async function cargarIngredientes() {
        let res = await fetch('https://www.themealdb.com/api/json/v1/1/list.php?i=list');
        let data = await res.json();

        let cont = document.getElementById('ingredientes');

        data.meals.forEach(i => {
            cont.innerHTML += `
            <label class="bg-white p-2 rounded shadow cursor-pointer">
                <input type="checkbox" onchange="toggle('${i.strIngredient}', this)">
                ${i.strIngredient}
            </label>
        `;
        });
    }

    function toggle(nombre, el) {
        if (el.checked) {
            seleccionados.push(nombre);
        } else {
            seleccionados = seleccionados.filter(i => i !== nombre);
        }
    }

    async function recomendar() {
        let cont = document.getElementById('resultados');
        cont.innerHTML = '';

        for (let ing of seleccionados) {
            let res = await fetch(`https://www.themealdb.com/api/json/v1/1/filter.php?i=${ing}`);
            let data = await res.json();

            if (data.meals) {
                data.meals.forEach(r => {
                    cont.innerHTML += `
                    <div class="bg-white p-3 rounded shadow">
                        <img src="${r.strMealThumb}" class="rounded">
                        <h3 class="font-bold">${r.strMeal}</h3>
                    </div>
                `;
                });
            }
        }
    }

    cargarIngredientes();
</script>

@endsection
@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-4">Ingredientes</h1>

<p class="text-gray-600 mb-4">
    Selecciona ingredientes para añadir a tu lista
</p>

<div id="lista" class="grid grid-cols-1 md:grid-cols-3 gap-3"></div>

<script>
    async function cargar() {
        let res = await fetch('https://www.themealdb.com/api/json/v1/1/list.php?i=list');
        let data = await res.json();

        let cont = document.getElementById('lista');
        cont.innerHTML = '';

        data.meals.forEach(i => {
            cont.innerHTML += `
            <div class="bg-white p-3 rounded shadow flex justify-between items-center">
                <span>${i.strIngredient}</span>

                <button onclick="añadir('${i.strIngredient}')"
                    class="bg-green-500 text-white px-2 py-1 rounded text-sm">
                    Añadir
                </button>
            </div>
        `;
        });
    }

    async function añadir(nombre) {
        await fetch('/api/lista-ingredientes', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                id_usuario: 1,
                nombre: nombre
            })
        });

        alert('Ingrediente añadido');
    }

    cargar();
</script>

@endsection
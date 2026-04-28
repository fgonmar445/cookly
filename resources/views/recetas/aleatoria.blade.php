@extends('layouts.app')

@section('content')

<div class="flex justify-end mb-4">
    <a href="{{ route('buscar') }}"
        class="flex items-center gap-1 text-green-600 hover:text-green-800 border border-green-600 px-3 py-1 rounded">
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
    class="bg-green-600 text-white px-4 py-2 rounded mb-4">
    Obtener receta aleatoria
</button>

<div id="resultado"></div>

<script>
    const favoritos = @json($favoritos);

    async function cargarAleatoria() {
        let res = await fetch("https://www.themealdb.com/api/json/v1/1/random.php");
        let data = await res.json();

        if (!data.meals) return;

        let r = data.meals[0];
        let esFavorita = favoritos.includes(r.idMeal);

        // Pintar el card
        document.getElementById('resultado').innerHTML = `
        <div class="bg-white p-4 rounded shadow max-w-sm">
            <img src="${r.strMealThumb}" class="rounded mb-2 w-full h-64 object-cover">
            <h2 class="text-xl font-bold mb-2">${r.strMeal}</h2>

            <div class="flex justify-between items-center mt-2">

                <a href="/receta/${r.idMeal}"
                    class="bg-green-600 text-white px-3 py-1 rounded inline-block text-sm">
                    Ver receta
                </a>

                <button onclick="toggleFavorito('${r.idMeal}', this)"
                    class="inline-flex items-center justify-center bg-white border border-green-600 text-green-600 hover:bg-green-50 px-3 py-1 rounded text-sm font-semibold transition-colors ">
                    ${esFavorita ? 'Quitar' : 'Añadir'}
                </button>
            </div>
        </div>
    `;
    }

    async function toggleFavorito(id, btn) {
        let res = await fetch(`/favoritos/toggle/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        let data = await res.json();

        if (data.success) {
            if (data.isFavorito) {
                btn.innerHTML = 'Quitar';
                btn.className = "inline-flex items-center justify-center bg-white border border-green-600 text-green-600 hover:bg-green-50 px-3 py-1 rounded text-sm font-semibold transition-colors ";
                if (!favoritos.includes(id)) favoritos.push(id);
            } else {
                btn.innerHTML = 'Añadir';
                btn.className = "inline-flex items-center justify-center bg-white border border-green-600 text-green-600 hover:bg-green-50 px-3 py-1 rounded text-sm font-semibold transition-colors ";
                let index = favoritos.indexOf(id);
                if (index > -1) favoritos.splice(index, 1);
            }
        }
    }
</script>

@endsection
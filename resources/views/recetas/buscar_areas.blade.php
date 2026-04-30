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


<h1 class="text-2xl font-bold mb-4">Buscar por cocina</h1>

<p class="text-gray-600 mb-4">
    Selecciona un tipo de cocina para ver sus recetas típicas.
</p>

<div class="grid grid-cols-7 gap-2 place-items-start">
    @foreach(config('ingredients.areas') as $key => $value)
    <button onclick="buscarArea('{{ $key }}')"
        class="inline-flex items-center justify-center 
           px-3 py-1 border border-emerald-600 text-emerald-600 bg-white 
           rounded text-sm font-semibold hover:bg-emerald-50 transition-colors
           min-w-[110px]">
        {{ ucfirst($value) }}
    </button>
    @endforeach
</div>

<div id="lista" class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-6"></div>

<script>
    const favoritos = @json($favoritos);

    async function buscarArea(area) {
        let cont = document.getElementById('lista');
        cont.innerHTML = '';

        let res = await fetch(`https://www.themealdb.com/api/json/v1/1/filter.php?a=${area}`);
        let data = await res.json();

        if (!data.meals) {
            cont.innerHTML = "<p>No hay recetas en esta área</p>";
            return;
        }

        mostrarResultados(data.meals);
    }

    function mostrarResultados(lista) {
        let cont = document.getElementById('lista');
        cont.innerHTML = '';

        lista.forEach(r => {
            let esFavorita = favoritos.includes(r.idMeal);

            cont.innerHTML += `
            <div class="bg-white p-3 rounded shadow">
                <img src="${r.strMealThumb}" class="rounded mb-2">
                <h3 class="font-bold mb-2">${r.strMeal}</h3>

                <div class="flex justify-between items-center mt-2">
                    <a href="/receta/${r.idMeal}"
                        class="bg-emerald-600 text-white px-3 py-1 rounded inline-block text-sm">
                        Ver receta
                    </a>

                    <button onclick="toggleFavorito('${r.idMeal}', this)"
                        class="inline-flex items-center justify-center 
           bg-white border border-emerald-600 text-emerald-600 
           hover:bg-emerald-50 
           px-3 py-1 rounded text-sm font-semibold transition-colors">
                        ${esFavorita ? 'Quitar' : 'Añadir'}
                    </button>
                </div>
            </div>
        `;
        });
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
                btn.className = 'inline-flex items-center justify-center px-3 py-1 rounded text-sm border border-emerald-600 bg-white text-emerald-600 hover:bg-emerald-50 transition-colors';
                if (!favoritos.includes(id)) favoritos.push(id);
            } else {
                btn.innerHTML = 'Añadir';
                btn.className = 'inline-flex items-center justify-center px-3 py-1 rounded text-sm border border-emerald-600 bg-white text-emerald-600 hover:bg-emerald-50 transition-colors';
                let index = favoritos.indexOf(id);
                if (index > -1) favoritos.splice(index, 1);
            }
        }
    }
</script>

@endsection
<div class="bg-white p-3 rounded shadow">
    <img src="{{ $r['strMealThumb'] }}" class="rounded mb-2 w-full">
    <h3 class="font-bold mb-2">{{ $r['strMeal'] }}</h3>

    <div class="flex justify-between items-center mt-2">

        <a href="/receta/{{ $r['idMeal'] }}"
            class="bg-emerald-600 text-white px-3 py-1 rounded inline-block text-sm">
            Ver receta
        </a>

        <button onclick="toggleFavorito('{{ $r['idMeal'] }}', this)"
            class="inline-flex items-center justify-center bg-white border border-emerald-600 text-emerald-600 hover:bg-emerald-50 px-3 py-1 rounded text-sm font-semibold transition-colors ">
            {{ $r['esFavorita'] ? 'Quitar' : 'Añadir' }}
        </button>
    </div>
</div>
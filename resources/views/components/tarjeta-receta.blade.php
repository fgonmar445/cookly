@php
// Si $r no existe (por ejemplo dentro de <template>), crear un array vacío
    $r = $r ?? [];
    @endphp

    <div class="bg-white p-3 rounded shadow receta-card">

        <img src="{{ $r['strMealThumb'] ?? 'STR_MEAL_THUMB' }}" class="rounded mb-2 w-full">

        <h3 class="font-bold mb-2">{{ $r['strMeal'] ?? 'STR_MEAL' }}</h3>

        {{-- Contenido extra opcional (recomendador, coincidencias, etc.) --}}
        {!! $r['extraHtml'] ?? '' !!}

        <div class="flex justify-between items-center mt-2">

            <a href="/receta/{{ $r['idMeal'] ?? 'ID_MEAL' }}"
                class="bg-emerald-600 text-white px-3 py-1 rounded inline-block text-sm">
                Ver receta
            </a>

            <button onclick="toggleFavorito('{{ $r['idMeal'] ?? 'ID_MEAL' }}', this)"
                class="inline-flex items-center justify-center bg-white border border-emerald-600 text-emerald-600 hover:bg-emerald-50 px-3 py-1 rounded text-sm font-semibold transition-colors favorito-btn">
                {{ ($r['esFavorita'] ?? false) ? 'Quitar' : 'Añadir' }}
            </button>

        </div>
    </div>
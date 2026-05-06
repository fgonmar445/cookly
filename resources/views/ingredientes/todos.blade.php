    @extends('layouts.app')

    @section('content')

    <h1 class="text-3xl font-bold text-gray-800 mb-6">Buscar ingredientes</h1>

    {{-- Buscador --}}
    <form method="GET" class="mb-6 flex gap-2">
        <input type="text" name="search" value="{{ request()->query('search') }}"
            placeholder="Buscar ingrediente..."
            class="w-full p-3 border rounded-lg shadow-sm">
        <button type="submit" class="bg-emerald-600 text-white px-6 py-3 rounded-lg hover:bg-emerald-700 shadow-sm transition-colors">
            Buscar
        </button>
    </form>

    @if ($search && empty($resultados))
    <p class="text-gray-600">No se encontraron ingredientes.</p>
    @endif

    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">

        @foreach ($resultados as $ing)

        @php
        $nombreEn = strtolower($ing['strIngredient']); // inglés
        $nombreEs = $traducciones['en_to_es'][$nombreEn] ?? $nombreEn; // traducido a español
        
        $nombreTrad = ucfirst($nombreEs);
        $nombreApi = ucfirst($nombreEn);
        $img = "https://www.themealdb.com/images/ingredients/{$nombreApi}.png";

        // Normalizar nombres para la comparación (quitando acentos como en web.php)
        $searchNames = [
            $nombreEn,
            str_replace(['á', 'é', 'í', 'ó', 'ú', 'ñ'], ['a', 'e', 'i', 'o', 'u', 'n'], $nombreEn),
            $nombreEs,
            str_replace(['á', 'é', 'í', 'ó', 'ú', 'ñ'], ['a', 'e', 'i', 'o', 'u', 'n'], $nombreEs)
        ];

        $yaLoTiene = false;
        foreach ($searchNames as $name) {
            if (in_array(strtolower(trim($name)), $misIngredientes)) {
                $yaLoTiene = true;
                break;
            }
        }
        @endphp

        <div class="bg-white p-4 rounded-xl shadow hover:shadow-md transition">
            <img src="{{ $img }}" class="w-20 h-20 mx-auto mb-3 rounded bg-gray-200">
            <p class="text-center font-medium mb-2">{{ $nombreTrad }}</p>

            {{-- Si el ingrediente YA está añadido --}}
            @if ($yaLoTiene)
            <button class="px-3 py-2 bg-gray-50 text-gray-400 font-bold rounded-xl cursor-not-allowed text-xs border border-gray-100 w-full">
                Añadido
            </button>
            @else
            <form action="{{ route('ingredientes.add') }}" method="POST">
                @csrf
                <input type="hidden" name="ingredient" value="{{ $nombreEs }}">
                <button class="px-3 py-2 bg-emerald-50 text-emerald-600 font-bold rounded-xl hover:bg-emerald-600 hover:text-white transition-all text-xs border border-emerald-100 w-full">
                    Añadir
                </button>
            </form>
            @endif

        </div>

        @endforeach

    </div>

    @endsection
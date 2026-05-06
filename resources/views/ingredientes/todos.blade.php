    @extends('layouts.app')

    @section('content')

    <div class="mb-12 px-2">
        <h1 class="text-3xl font-black text-slate-800 mb-2 tracking-tight">Catálogo de Ingredientes</h1>
        <p class="text-slate-500 text-sm md:text-base leading-relaxed">Busca y añade ingredientes básicos a tu despensa personal.</p>
    </div>

    {{-- Buscador --}}
    <div class="max-w-2xl mb-12">
        <form method="GET" class="flex flex-col sm:flex-row gap-4">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request()->query('search') }}"
                    placeholder="Buscar ingrediente..."
                    class="block w-full pl-11 pr-4 py-4 bg-white border border-slate-100 rounded-2xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all shadow-sm">
            </div>
            <button type="submit" class="px-8 py-4 bg-emerald-600 text-white font-bold rounded-2xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-600/20 active:scale-95 whitespace-nowrap">
                Buscar
            </button>
        </form>
    </div>

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

        static $vistos = [];

        if (in_array($nombreEs, $vistos)) {
        continue; // evita duplicados
        }

        $vistos[] = $nombreEs;

        @endphp

        <div class="bg-white p-5 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-emerald-100/50 transition-all duration-300 group">
            <div class="w-20 h-20 bg-slate-50 rounded-2xl overflow-hidden flex items-center justify-center p-2 border border-slate-100 mx-auto mb-4 group-hover:bg-white group-hover:scale-105 transition-all">
                <img src="{{ $img }}" class="w-full h-full object-contain">
            </div>
            <p class="text-center font-bold text-slate-700 mb-4 truncate text-sm">{{ $nombreTrad }}</p>

            {{-- Si el ingrediente YA está añadido --}}
            @if ($yaLoTiene)
            <button class="w-full px-3 py-2 bg-slate-50 text-slate-400 font-bold rounded-xl cursor-not-allowed text-[10px] border border-slate-100 uppercase tracking-wider">
                Añadido
            </button>
            @else
            <form action="{{ route('ingredientes.add') }}" method="POST">
                @csrf
                <input type="hidden" name="ingredient" value="{{ $nombreEs }}">
                <button class="w-full px-3 py-2 bg-emerald-50 text-emerald-600 font-bold rounded-xl hover:bg-emerald-600 hover:text-white transition-all text-[10px] border border-emerald-100 uppercase tracking-wider active:scale-95">
                    Añadir
                </button>
            </form>
            @endif

        </div>

        @endforeach

    </div>

    @endsection
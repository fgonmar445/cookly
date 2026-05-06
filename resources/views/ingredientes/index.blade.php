@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-6 mb-12">
        <div class="px-2">
            <h1 class="text-3xl font-black text-slate-800 tracking-tight mb-2">Ingredientes</h1>
            <p class="text-slate-500 text-sm md:text-base leading-relaxed">Gestiona los alimentos básicos disponibles para tus recetas.</p>
        </div>

        <a href="{{ route('mis.ingredientes') }}"
            class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-4 bg-white border border-slate-200 text-slate-700 font-bold rounded-2xl hover:border-emerald-500 hover:text-emerald-600 transition-all shadow-sm group active:scale-95 text-sm">
            <svg class="w-5 h-5 mr-2 text-slate-400 group-hover:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
            Mi Despensa
        </a>
    </div>

    @foreach ($categorias as $categoria => $lista)

    <h2 class="text-2xl font-semibold text-emerald-700 mb-3">{{ $categoria }}</h2>

    <ul class="bg-white border border-gray-200 rounded-xl p-4 mb-8 shadow-sm">

        @foreach ($lista as $ing)

        @php
        // Normalizar nombre para generar la URL de TheMealDB
        $nombreApi = ucfirst(strtolower($ing));

        // Buscar ingrediente global en la BD
        $ingredienteGlobal = DB::table('ingredientes')->where('nombre', $ing)->first();

        // Si existe en la BD y tiene imagen → usarla
        if ($ingredienteGlobal && $ingredienteGlobal->imagen) {
        $img = $ingredienteGlobal->imagen;
        } else {
        // Si NO existe o no tiene imagen → generar URL automática
        $img = "https://www.themealdb.com/images/ingredients/{$nombreApi}.png";
        }

        // Nombre traducido
        $nombre = ucfirst($traducciones[$ing] ?? $ing);

        // Comprobar si está añadido
        $registro = null;
        $estaAñadido = false;

        if ($ingredienteGlobal) {
        $registro = $misIngredientes->firstWhere('id_ingrediente', $ingredienteGlobal->id_ingrediente);
        $estaAñadido = $registro !== null;
        }


        @endphp


        <li class="flex items-center justify-between py-4 border-b border-slate-50 last:border-none group">

            <div class="flex items-center gap-4">

                {{-- Imagen --}}
                <div class="w-12 h-12 bg-slate-50 rounded-2xl overflow-hidden flex items-center justify-center p-1 border border-slate-100 group-hover:bg-white group-hover:shadow-md transition-all">
                    @if ($img)
                    <img src="{{ $img }}" class="w-full h-full object-contain">
                    @else
                    <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                    </svg>
                    @endif
                </div>

                {{-- Nombre --}}
                <span class="font-bold text-slate-700">{{ $nombre }}</span>
            </div>

            {{-- Botón dinámico --}}
            @if ($estaAñadido)
            <form action="{{ route('ingredientes.eliminar') }}" method="POST">
                @csrf
                <input type="hidden" name="id_lista" value="{{ $registro->id_lista }}">
                <button class="px-5 py-2 bg-red-50 text-red-600 font-bold rounded-xl hover:bg-red-600 hover:text-white transition-all text-xs border border-red-100">
                    Eliminar
                </button>
            </form>
            @else
            <form action="{{ route('ingredientes.add') }}" method="POST">
                @csrf
                <input type="hidden" name="ingredient" value="{{ $ing }}">
                <button class="px-5 py-2 bg-emerald-50 text-emerald-600 font-bold rounded-xl hover:bg-emerald-600 hover:text-white transition-all text-xs border border-emerald-100">
                    Añadir
                </button>
            </form>
            @endif

        </li>

        @endforeach

    </ul>

    @endforeach

</div>

@endsection
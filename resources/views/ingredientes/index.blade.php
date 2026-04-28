@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Ingredientes principales</h1>

        <a href="{{ route('mis.ingredientes') }}"
            class="bg-emerald-600 text-white px-4 py-2 rounded hover:bg-emerald-700">
            Mis ingredientes
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


        <li class="flex items-center justify-between py-2 border-b last:border-none">

            <div class="flex items-center gap-3">

                {{-- Imagen --}}
                @if ($img)
                <img src="{{ $img }}" class="w-10 h-10 rounded">
                @else
                <div class="w-10 h-10 bg-gray-200 rounded"></div>
                @endif

                {{-- Nombre --}}
                <span class="font-medium">{{ $nombre }}</span>
            </div>

            {{-- Botón dinámico --}}
            @if ($estaAñadido)
            <form action="{{ route('ingredientes.eliminar') }}" method="POST">
                @csrf
                <input type="hidden" name="id_lista" value="{{ $registro->id_lista }}">
                <button class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                    Eliminar
                </button>
            </form>
            @else
            <form action="{{ route('ingredientes.add') }}" method="POST">
                @csrf
                <input type="hidden" name="ingredient" value="{{ $ing }}">
                <button class="bg-emerald-600 text-white px-3 py-1 rounded hover:bg-emerald-700">
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
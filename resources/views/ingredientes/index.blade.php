@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Ingredientes disponibles</h1>

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
        // Normalizar nombre para la API
        $nombreApi = ucfirst(strtolower($ing));

        // Obtener datos desde la API
        $url = "https://www.themealdb.com/api/json/v1/1/search.php?i=" . urlencode($nombreApi);
        $data = json_decode(file_get_contents($url), true);
        $info = $data['ingredients'][0] ?? null;

        // Buscar ingrediente global
        $ingredienteGlobal = DB::table('ingredientes')->where('nombre', $ing)->first();

        // Imagen desde BD
        $img = $ingredienteGlobal->imagen ?? null;

        // Imagen por defecto si no existe


        // Nombre traducido
        $nombre = $traducciones[$ing] ?? ucfirst($ing);

        // Comprobar si está añadido
        $estaAñadido = false;

        if ($ingredienteGlobal) {
        $estaAñadido = in_array($ingredienteGlobal->id_ingrediente, $misIngredientes);
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
                <input type="hidden" name="ingredient" value="{{ $ing }}">
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
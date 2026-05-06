@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold text-gray-800 mb-6">Mis ingredientes</h1>


@if ($misIngredientes->isEmpty())

<p class="text-gray-600">Todavía no has añadido ningún ingrediente.</p>
@else

<ul class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">

    @foreach ($misIngredientes as $ing)

    @php

    // Nombre original en español
    $nombreEs = strtolower(trim($ing->nombre));

    // Convertir español → inglés para la API
    $nombreEn = $traducciones['es_to_en'][$nombreEs] ?? $ing->nombre;

    // Para la URL de TheMealDB (primera letra mayúscula)
    $nombreApi = ucfirst($nombreEn);

    // Buscar ingrediente global
    $ingredienteGlobal = DB::table('ingredientes')->where('nombre', $ing->nombre)->first();

    // Imagen: BD → API
    $img = $ingredienteGlobal && $ingredienteGlobal->imagen
    ? $ingredienteGlobal->imagen
    : "https://www.themealdb.com/images/ingredients/{$nombreApi}.png";

    // Nombre mostrado (inglés → español) — ¡AQUÍ ESTABA EL FALLO!
    $nombre = ucfirst($traducciones['en_to_es'][strtolower($nombreEn)] ?? $ing->nombre);
    @endphp





    <li class="flex items-center justify-between py-3 border-b last:border-none">

        <div class="flex items-center gap-3">
            <img src="{{ $img }}" class="w-10 h-10 rounded bg-gray-200">
            <span class="font-medium">{{ $nombre }}</span>
        </div>

        <form action="{{ route('ingredientes.eliminar') }}" method="POST">
            @csrf
            <input type="hidden" name="id_lista" value="{{ $ing->id_lista }}">
            <button class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                Eliminar
            </button>
        </form>


    </li>

    @endforeach

</ul>

@endif

@endsection
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
    $nombre = strtolower($ing['strIngredient']);
    if (str_contains($nombre, 'graham')) continue;

    $nombreApi = ucfirst($nombre);
    $img = "https://www.themealdb.com/images/ingredients/{$nombreApi}.png";
    $nombreTrad = ucfirst($traducciones[$nombre] ?? $nombre);
    @endphp

    <div class="bg-white p-4 rounded-xl shadow hover:shadow-md transition">
        <img src="{{ $img }}" class="w-20 h-20 mx-auto mb-3 rounded bg-gray-200">
        <p class="text-center font-medium mb-2">{{ $nombreTrad }}</p>

        {{-- Si el ingrediente YA está añadido --}}
        @if (in_array(strtolower($ing['strIngredient']), $misIngredientes))

        <button class="bg-gray-400 text-white px-3 py-1 rounded w-full cursor-not-allowed">
            Añadido
        </button>

        {{-- Si NO está añadido --}}
        @else
        <form action="{{ route('ingredientes.add') }}" method="POST">
            @csrf
            <input type="hidden" name="ingredient" value="{{ $nombre }}">
            <button class="bg-emerald-600 text-white px-3 py-1 rounded hover:bg-emerald-700 w-full">
                Añadir
            </button>
        </form>
        @endif
    </div>

    @endforeach

</div>

@endsection
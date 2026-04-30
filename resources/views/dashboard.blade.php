@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto">

    <h1 class="text-3xl font-bold text-gray-800 mb-6">Bienvenido a Cookly</h1>
    <p class="text-gray-600 mb-8">Tu centro personal de recetas y recomendaciones</p>

    {{-- ACCESOS RÁPIDOS --}}
    <h2 class="text-lg font-semibold mb-3">Accesos rápidos</h2>
    <div class="flex gap-2 overflow-x-auto pb-2 mb-8">

        <a href="{{ route('buscar.nombre') }}"
            class="inline-flex items-center justify-center bg-white border border-emerald-600 text-emerald-600 hover:bg-emerald-50 px-3 py-1.5 rounded-lg text-sm font-semibold whitespace-nowrap">
            Nombre
        </a>

        <a href="{{ route('buscar.ingredientes') }}"
            class="inline-flex items-center justify-center bg-white border border-emerald-600 text-emerald-600 hover:bg-emerald-50 px-3 py-1.5 rounded-lg text-sm font-semibold whitespace-nowrap">
            Ingredientes
        </a>

        <a href="{{ route('buscar.categorias') }}"
            class="inline-flex items-center justify-center bg-white border border-emerald-600 text-emerald-600 hover:bg-emerald-50 px-3 py-1.5 rounded-lg text-sm font-semibold whitespace-nowrap">
            Categoría
        </a>

        <a href="{{ route('buscar.areas') }}"
            class="inline-flex items-center justify-center bg-white border border-emerald-600 text-emerald-600 hover:bg-emerald-50 px-3 py-1.5 rounded-lg text-sm font-semibold whitespace-nowrap">
            País
        </a>

        <a href="{{ route('buscar.aleatoria') }}"
            class="inline-flex items-center justify-center bg-white border border-emerald-600 text-emerald-600 hover:bg-emerald-50 px-3 py-1.5 rounded-lg text-sm font-semibold whitespace-nowrap">
            Aleatoria
        </a>

        <a href="{{ route('buscar.recomendador') }}"
            class="inline-flex items-center justify-center bg-white border border-emerald-600 text-emerald-600 hover:bg-emerald-50 px-3 py-1.5 rounded-lg text-sm font-semibold whitespace-nowrap">
            Recomendador
        </a>

    </div>

    {{-- RECOMENDACIONES --}}
    <h2 class="text-lg font-semibold mb-3">Recomendaciones para ti</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-10">

        @forelse ($recomendaciones as $r)
        @include('components.tarjeta-receta', ['r' => $r])
        @empty
        <p class="text-gray-500">Añade ingredientes para recibir recomendaciones.</p>
        @endforelse

    </div>

    {{-- RECETAS ALEATORIAS --}}
    <h2 class="text-lg font-semibold mb-3">Recetas aleatorias del día</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-10">

        @foreach ($random as $r)
        @include('components.tarjeta-receta', ['r' => $r])
        @endforeach

    </div>

    {{-- POPULARES --}}
    <h2 class="text-lg font-semibold mb-3">Recetas más populares</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-10">

        @foreach ($populares as $r)
        @include('components.tarjeta-receta', ['r' => $r])
        @endforeach

    </div>

    {{-- FAVORITOS --}}
    <h2 class="text-lg font-semibold mb-3">Tus favoritos recientes</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-10">

        @foreach ($favoritos as $r)
        @include('components.tarjeta-receta', ['r' => $r])
        @endforeach

    </div>

</div>

@endsection
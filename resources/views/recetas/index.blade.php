@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-6">Recetas</h1>

<p class="text-gray-600 mb-6">
    Elige cómo quieres buscar recetas
</p>

{{-- BOTONES PRINCIPALES --}}
<div class="flex gap-4 overflow-x-auto pb-2">

    <a href="{{ route('buscar.nombre') }}"
        class="inline-flex items-center justify-center bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-lg text-sm font-semibold whitespace-nowrap">
        Nombre
    </a>

    <a href="{{ route('buscar.ingredientes') }}"
        class="inline-flex items-center justify-center bg-white border border-green-600 text-green-600 hover:bg-green-50 px-3 py-1.5 rounded-lg text-sm font-semibold whitespace-nowrap">
        Ingredientes
    </a>

    <a href="{{ route('buscar.categorias') }}"
        class="inline-flex items-center justify-center bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-lg text-sm font-semibold whitespace-nowrap">
        Categoría
    </a>

    <a href="{{ route('buscar.areas') }}"
        class="inline-flex items-center justify-center bg-white border border-green-600 text-green-600 hover:bg-green-50 px-3 py-1.5 rounded-lg text-sm font-semibold whitespace-nowrap">
        País
    </a>

    <a href="{{ route('buscar.aleatoria') }}"
        class="inline-flex items-center justify-center bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-lg text-sm font-semibold whitespace-nowrap">
        Aleatoria
    </a>

    <a href="{{ route('buscar.recomendador') }}"
        class="inline-flex items-center justify-center bg-white border border-green-600 text-green-600 hover:bg-green-50 px-3 py-1.5 rounded-lg text-sm font-semibold whitespace-nowrap">
        Recomendador
    </a>

</div>



@endsection
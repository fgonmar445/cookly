@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-4">Bienvenido a Cookly</h1>
<p class="text-gray-600 mb-8">Tu centro personal de recetas y recomendaciones</p>

{{-- ACCESOS RÁPIDOS --}}
<h2 class="text-lg font-semibold mb-3">Accesos rápidos</h2>
<div class="flex gap-2 overflow-x-auto pb-2 mb-8">

    <a href="{{ route('buscar.nombre') }}"
        class="inline-flex items-center justify-center bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1.5 rounded-lg text-sm font-semibold whitespace-nowrap">
        Nombre
    </a>

    <a href="{{ route('buscar.ingredientes') }}"
        class="inline-flex items-center justify-center bg-white border border-emerald-600 text-emerald-600 hover:bg-emerald-50 px-3 py-1.5 rounded-lg text-sm font-semibold whitespace-nowrap">
        Ingredientes
    </a>

    <a href="{{ route('buscar.categorias') }}"
        class="inline-flex items-center justify-center bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1.5 rounded-lg text-sm font-semibold whitespace-nowrap">
        Categoría
    </a>

    <a href="{{ route('buscar.areas') }}"
        class="inline-flex items-center justify-center bg-white border border-emerald-600 text-emerald-600 hover:bg-emerald-50 px-3 py-1.5 rounded-lg text-sm font-semibold whitespace-nowrap">
        País
    </a>

    <a href="{{ route('buscar.aleatoria') }}"
        class="inline-flex items-center justify-center bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1.5 rounded-lg text-sm font-semibold whitespace-nowrap">
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
    {{-- Aquí irían tarjetas dinámicas --}}
    <div class="bg-white shadow rounded-lg p-4 text-center">
        <p class="font-semibold">Recomendación 1</p>
    </div>
    <div class="bg-white shadow rounded-lg p-4 text-center">
        <p class="font-semibold">Recomendación 2</p>
    </div>
    <div class="bg-white shadow rounded-lg p-4 text-center">
        <p class="font-semibold">Recomendación 3</p>
    </div>
</div>

{{-- RECETA ALEATORIA --}}
<h2 class="text-lg font-semibold mb-3">Receta aleatoria del día</h2>
<div class="bg-white shadow rounded-lg p-4 mb-10">
    <p class="font-semibold mb-2">Nombre de la receta</p>
    <a href="{{ route('buscar.aleatoria') }}"
        class="inline-flex items-center justify-center bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1.5 rounded-lg text-sm font-semibold">
        Ver receta
    </a>
</div>

{{-- POPULARES --}}
<h2 class="text-lg font-semibold mb-3">Recetas más populares</h2>
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-10">
    <div class="bg-white shadow rounded-lg p-4 text-center">
        <p class="font-semibold">Popular 1</p>
    </div>
    <div class="bg-white shadow rounded-lg p-4 text-center">
        <p class="font-semibold">Popular 2</p>
    </div>
    <div class="bg-white shadow rounded-lg p-4 text-center">
        <p class="font-semibold">Popular 3</p>
    </div>
</div>

{{-- FAVORITOS --}}
<h2 class="text-lg font-semibold mb-3">Tus favoritos recientes</h2>
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-10">
    <div class="bg-white shadow rounded-lg p-4 text-center">
        <p class="font-semibold">Favorito 1</p>
    </div>
    <div class="bg-white shadow rounded-lg p-4 text-center">
        <p class="font-semibold">Favorito 2</p>
    </div>
    <div class="bg-white shadow rounded-lg p-4 text-center">
        <p class="font-semibold">Favorito 3</p>
    </div>
</div>

@endsection
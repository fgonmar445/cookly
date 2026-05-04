@extends('layouts.app')

@section('header_title', 'Tu Panel de Cocina')

@section('content')
<div class="max-w-7xl mx-auto">

    <!-- Welcome Section -->
    <div class="mb-12">
        <h1 class="text-4xl font-bold text-slate-800 mb-2">Hola, {{ Auth::user()->name }}</h1>
        <p class="text-slate-500">¿Qué te apetece cocinar hoy? Tenemos sugerencias basadas en tus gustos.</p>
    </div>

    <!-- Quick Navigation Grid -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-16">
        @php
        $nav = [
        ['name' => 'Por Nombre', 'route' => 'buscar.nombre', 'icon' => 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'],
        ['name' => 'Ingredientes', 'route' => 'buscar.ingredientes', 'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'],
        ['name' => 'Categorías', 'route' => 'buscar.categorias', 'icon' => 'M4 6h16M4 12h16m-7 6h7'],
        ['name' => 'Por Cocina', 'route' => 'buscar.areas', 'icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064'],
        ['name' => 'Aleatoria', 'route' => 'buscar.aleatoria', 'icon' => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15'],
        ['name' => 'Recomendador', 'route' => 'buscar.recomendador', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'],
        ];
        @endphp

        @foreach($nav as $item)
        <a href="{{ route($item['route']) }}" class="flex flex-col items-center justify-center p-6 bg-white border border-slate-100 rounded-3xl shadow-sm hover:shadow-xl hover:shadow-emerald-100 hover:border-emerald-100 transition-all group">
            <div class="w-12 h-12 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-400 group-hover:bg-emerald-500 group-hover:text-white transition-all mb-3 shadow-inner">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}" />
                </svg>
            </div>
            <span class="text-xs font-bold text-slate-600 group-hover:text-emerald-600 tracking-wide">{{ $item['name'] }}</span>
        </a>
        @endforeach
    </div>

    <!-- Sections Layout -->
    <div class="space-y-16">

        <!-- Recomendaciones Section -->
        @if(count($recomendaciones) > 0)
        <div>
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-bold text-slate-800">Para chuparse los dedos</h2>
                <a href="{{ route('buscar.recomendador') }}" class="text-emerald-600 font-bold text-sm hover:underline">Ver más sugerencias</a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($recomendaciones as $r)
                @include('components.tarjeta-receta', ['r' => $r])
                @endforeach
            </div>
        </div>
        @endif

        <!-- Random Recipes -->
        <div>
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-bold text-slate-800">Recetas del mundo</h2>
                <a href="{{ route('buscar.aleatoria') }}" class="text-emerald-600 font-bold text-sm hover:underline">¡Otra al azar!</a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($random as $r)
                @include('components.tarjeta-receta', ['r' => $r])
                @endforeach
            </div>
        </div>

        <!-- Populares -->
        <div>
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-bold text-slate-800">Tendencia en Cookly</h2>
                <span class="text-slate-400 text-sm font-medium">Lo más guardado por la comunidad</span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($populares as $r)
                @include('components.tarjeta-receta', ['r' => $r])
                @endforeach
            </div>
        </div>

        <!-- Favoritos -->
        @if(count($favoritos) > 0)
        <div>
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-bold text-slate-800">Tus favoritos recientes</h2>
                <a href="{{ route('favoritos.index') }}" class="text-emerald-600 font-bold text-sm hover:underline">Ver todo mi libro</a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($favoritos as $r)
                @include('components.tarjeta-receta', ['r' => $r])
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>
@endsection
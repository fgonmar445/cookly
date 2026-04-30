@extends('layouts.app')

@section('content')

{{-- BOTÓN VOLVER --}}
<div class="flex justify-end">
    <a href="{{ route('buscar') }}" class="flex items-center gap-1 text-emerald-600 hover:text-emerald-800 border border-emerald-600 px-3 py-1 rounded">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        Volver
    </a>
</div>

{{-- TÍTULO --}}
<h1 class="text-3xl font-bold mb-4">{{ $receta['strMeal'] }}</h1>

{{-- BOTÓN FAVORITOS --}}
<form action="{{ route('favoritos.toggle', $receta['idMeal']) }}" method="POST" class="mb-6">
    @csrf
    <input type="hidden" name="name" value="{{ $receta['strMeal'] }}">

    @if ($isFavorita)
    <button type="submit"
        class="inline-flex items-center justify-center bg-white border border-emerald-600 text-emerald-600 hover:bg-emerald-50 px-4 py-2 rounded-lg text-sm font-semibold">
        Eliminar de favoritos
    </button>
    @else
    <button type="submit"
        class="inline-flex items-center justify-center 
       bg-white border border-emerald-600 text-emerald-600 
       hover:bg-emerald-50 
       px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
        Añadir a favoritos
    </button>
    @endif
</form>




{{-- IMAGEN --}}
<img src="{{ $receta['strMealThumb'] }}"
    alt="Imagen de {{ $receta['strMeal'] }}"
    class="w-full max-w-xl rounded-lg shadow mb-6">

{{-- INFO EXTRA --}}
<div class="text-gray-600 mb-6">
    <p><strong>Categoría:</strong> {{ $receta['strCategory'] }}</p>
    <p><strong>País:</strong> {{ $receta['strArea'] }}</p>
</div>

{{-- INGREDIENTES --}}
<h2 class="text-xl font-semibold mb-2">Ingredientes</h2>
<ul class="list-disc pl-6 mb-8">
    @for ($i = 1; $i <= 20; $i++)
        @php
        $ing=$receta["strIngredient{$i}"] ?? null;
        $cant=$receta["strMeasure{$i}"] ?? null;
        @endphp

        @if ($ing)
        <li>{{ $cant }} - {{ $ing }}</li>
        @endif
        @endfor
</ul>

{{-- INSTRUCCIONES --}}
<h2 class="text-xl font-semibold mb-2">Instrucciones</h2>
<p class="leading-relaxed whitespace-pre-line mb-8">
    {{ $receta['strInstructions'] }}
</p>

{{-- VIDEO --}}
@if (!empty($receta['strYoutube']))
<h2 class="text-xl font-semibold mb-2">Video</h2>
<iframe class="w-full max-w-xl aspect-video rounded-lg shadow"
    src="https://www.youtube.com/embed/{{ Str::after($receta['strYoutube'], 'v=') }}"
    allowfullscreen>
</iframe>
@endif

@endsection
@extends('layouts.app')

@section('header_title', $receta['strMeal'])

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Hero Section -->
    <div class="relative rounded-[2rem] md:rounded-[2.5rem] overflow-hidden mb-8 md:mb-12 shadow-2xl shadow-emerald-100/50">
        <img src="{{ $receta['strMealThumb'] }}"
            alt="Imagen de {{ $receta['strMeal'] }}"
            class="w-full h-64 md:h-96 object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent flex items-end">
            <div class="p-6 md:p-8 lg:p-12 w-full flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-3 md:mb-4">
                        <span class="px-3 py-1 bg-emerald-500 text-white text-[10px] font-bold uppercase tracking-widest rounded-lg">
                            {{ $receta['strCategory'] }}
                        </span>
                        <span class="px-3 py-1 bg-white/20 backdrop-blur-md text-white text-[10px] font-bold uppercase tracking-widest rounded-lg">
                            {{ $receta['strArea'] }}
                        </span>
                    </div>
                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white tracking-tight leading-tight">
                        {{ $receta['strMeal'] }}
                    </h1>
                </div>
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                    @if($recetaBD && $recetaBD->id_usuario == Auth::id())
                        <div class="flex gap-2">
                            <a href="{{ route('recetas.edit', $recetaBD->id_receta) }}" 
                               class="flex-1 inline-flex items-center justify-center gap-2 bg-emerald-500 text-white hover:bg-emerald-600 transition-all px-6 py-3 rounded-2xl font-black text-xs md:text-sm shadow-xl shadow-emerald-500/20 group">
                                <svg class="w-4 h-4 md:w-5 md:h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Editar
                            </a>
                            <form action="{{ route('recetas.destroy', $recetaBD->id_receta) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres borrar esta receta?')" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-full inline-flex items-center justify-center gap-2 bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white transition-all px-6 py-3 rounded-2xl font-black text-xs md:text-sm border border-rose-100 shadow-xl shadow-rose-100/50 group text-center">
                                    <svg class="w-4 h-4 md:w-5 md:h-5 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Borrar
                                </button>
                            </form>
                        </div>
                    @endif

                    <form action="{{ route('favoritos.toggle', $receta['idMeal']) }}" method="POST" class="w-full sm:w-auto">
                        @csrf
                        <input type="hidden" name="name" value="{{ $receta['strMeal'] }}">
                        <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 bg-white text-slate-900 hover:bg-emerald-500 hover:text-white transition-all px-6 py-3 rounded-2xl font-black text-xs md:text-sm shadow-xl group">
                            <svg class="w-4 h-4 md:w-5 md:h-5 transition-all {{ $isFavorita ? 'fill-emerald-500 text-emerald-500 group-hover:fill-white group-hover:text-white' : 'group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            {{ $isFavorita ? 'En Favoritos' : 'Añadir a Favoritos' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- Sidebar: Ingredientes -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm sticky top-24">
                <h2 class="text-xl font-bold text-slate-800 mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Ingredientes
                </h2>
                <ul class="space-y-4">
                    @for ($i = 1; $i <= 20; $i++)
                        @php
                        $ing=$receta["strIngredient{$i}"] ?? null;
                        $cant=$receta["strMeasure{$i}"] ?? null;
                        @endphp
                        @if ($ing)
                            <li class="flex items-start">
                                <span class="w-2 h-2 rounded-full bg-emerald-400 mt-2 mr-3 flex-shrink-0"></span>
                                <div>
                                    <span class="font-bold text-slate-800">{{ $cant }}</span>
                                    <span class="text-slate-600 text-sm ml-1">{{ $ing }}</span>
                                </div>
                            </li>
                        @endif
                    @endfor
                </ul>
            </div>
        </div>

        <!-- Main Content: Instrucciones -->
        <div class="lg:col-span-2">
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-slate-800 mb-6">Instrucciones de preparación</h2>
                <div class="prose prose-slate max-w-none">
                    <p class="leading-relaxed text-slate-600 whitespace-pre-line text-lg">
                        {{ $receta['strInstructions'] }}
                    </p>
                </div>
            </div>

            @if (!empty($receta['strYoutube']))
                <div class="pt-12 border-t border-slate-100">
                    <h2 class="text-2xl font-bold text-slate-800 mb-6">Videotutorial</h2>
                    <div class="rounded-3xl overflow-hidden shadow-2xl shadow-slate-200 aspect-video">
                        <iframe class="w-full h-full"
                            src="https://www.youtube.com/embed/{{ Str::after($receta['strYoutube'], 'v=') }}"
                            allowfullscreen>
                        </iframe>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
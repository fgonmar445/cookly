@extends('layouts.app')

@section('header_title', 'Explorar Comunidad')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <p class="text-slate-500 text-sm">Descubre las últimas creaciones de otros chefs en Cookly.</p>
        </div>
        <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-slate-400">
            <span>Filtrar por:</span>
            <button class="px-3 py-1 bg-white border border-slate-200 rounded-full text-slate-600 hover:border-emerald-500 hover:text-emerald-600 transition-all">Recientes</button>
            <button class="px-3 py-1 bg-white border border-slate-200 rounded-full text-slate-600 hover:border-emerald-500 hover:text-emerald-600 transition-all">Populares</button>
        </div>
    </div>

    @if($recetas->isEmpty())
        <div class="text-center py-20 bg-white rounded-3xl border border-slate-100 shadow-sm">
            <h3 class="text-xl font-bold text-slate-800 mb-2">Aún no hay recetas públicas</h3>
            <p class="text-slate-500 mb-8 max-w-xs mx-auto">Sé el primero en compartir una receta con el mundo.</p>
            <a href="{{ route('recetas.create') }}" class="inline-flex items-center px-6 py-3 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-sm">
                Crear Receta
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($recetas as $receta)
                <a href="{{ route('recetas.show', $receta->id_receta) }}"
                    class="group bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-300 overflow-hidden">
                    
                    <div class="relative h-48 overflow-hidden">
                        <img src="{{ $receta->imagen ? asset('storage/'.$receta->imagen) : '/img/no-image.png' }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute top-3 left-3 px-2 py-1 bg-black/40 backdrop-blur-md rounded-lg text-[10px] font-bold text-white uppercase tracking-wider">
                            {{ $receta->categoria ?? 'Receta' }}
                        </div>
                    </div>

                    <div class="p-5">
                        <h3 class="font-bold text-slate-800 group-hover:text-emerald-600 transition-colors line-clamp-1 mb-1">
                            {{ $receta->nombre }}
                        </h3>
                        <div class="flex items-center justify-between mt-4 pt-4 border-t border-slate-50">
                            <span class="text-xs text-slate-400 font-medium flex items-center">
                                <svg class="w-3.5 h-3.5 mr-1 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{ $receta->area ?? 'Internacional' }}
                            </span>
                            <div class="w-6 h-6 rounded-full bg-slate-100 flex items-center justify-center text-[10px] font-bold text-slate-500 border border-white shadow-sm">
                                {{ strtoupper(substr($receta->usuario->name ?? '?', 0, 1)) }}
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-12 flex justify-center">
            {{ $recetas->links() }}
        </div>
    @endif
</div>
@endsection
@extends('layouts.app')

@section('header_title', 'Mis Recetas Personales')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-10">
        <div>
            <p class="text-slate-500 text-sm">Gestiona las recetas que has compartido con la comunidad.</p>
        </div>
        <a href="{{ route('recetas.create') }}" class="inline-flex items-center px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-sm">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Nueva Receta
        </a>
    </div>

    @if($recetas->isEmpty())
        <div class="text-center py-20 bg-white rounded-3xl border border-slate-100 shadow-sm">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">Aún no tienes recetas</h3>
            <p class="text-slate-500 mb-8 max-w-xs mx-auto">Comienza a crear tu propio libro de cocina digital hoy mismo.</p>
            <a href="{{ route('recetas.create') }}" class="text-emerald-600 font-bold hover:underline">Crear mi primera receta</a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
            @foreach($recetas as $receta)
                <div class="group bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-300 overflow-hidden flex flex-col h-full">
                    <!-- Image Wrapper -->
                    <div class="relative h-56 overflow-hidden">
                        <img src="{{ $receta->imagen ? asset('storage/'.$receta->imagen) : '/img/no-image.png' }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-6">
                            <a href="{{ route('recetas.show', $receta->id_receta) }}" class="text-white font-semibold text-sm underline underline-offset-4">Ver detalles</a>
                        </div>
                        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider text-emerald-700 shadow-sm">
                            {{ $receta->categoria ?? 'General' }}
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-6 flex-1 flex flex-col">
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-slate-800 mb-2 group-hover:text-emerald-600 transition-colors">
                                {{ $receta->nombre }}
                            </h3>
                            <p class="text-slate-500 text-sm line-clamp-2 mb-4">
                                {{ $receta->descripcion ?? 'Sin descripción disponible.' }}
                            </p>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-between pt-6 border-t border-slate-50 mt-auto">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('recetas.edit', $receta->id_receta) }}"
                                    class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 text-slate-600 hover:bg-emerald-50 hover:text-emerald-600 transition-all shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <form action="{{ route('recetas.destroy', $receta->id_receta) }}" method="POST"
                                    onsubmit="return confirm('¿Seguro que quieres borrar esta receta?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 text-slate-600 hover:bg-red-50 hover:text-red-600 transition-all shadow-sm">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                            <span class="text-xs font-medium text-slate-400">
                                {{ $receta->area ?? 'Cocina variada' }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
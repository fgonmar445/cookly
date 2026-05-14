@extends('layouts.app')

@section('header_title', 'Explorar Comunidad')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <p class="text-slate-500 text-sm">Descubre las últimas creaciones de otros chefs en Cookly.</p>
        </div>
        <div class="flex items-center gap-2 text-xs uppercase tracking-wider text-slate-400">
            <span>Filtrar por:</span>
            <a href="{{ route('recetas.usuarios', ['filter' => 'recientes']) }}" class="px-2.5 py-1 text-[10px] border rounded-full transition-all {{ ($filter ?? 'recientes') === 'recientes' ? 'bg-orange-500 text-white border-orange-500 font-bold shadow-sm' : 'bg-white border-slate-200 text-slate-600 hover:border-orange-500 hover:text-orange-600' }}">Recientes</a>
            <a href="{{ route('recetas.usuarios', ['filter' => 'populares']) }}" class="px-2.5 py-1 text-[10px] border rounded-full transition-all {{ ($filter ?? 'recientes') === 'populares' ? 'bg-orange-500 text-white border-orange-500 font-bold shadow-sm' : 'bg-white border-slate-200 text-slate-600 hover:border-orange-500 hover:text-orange-600' }}">Populares</a>
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
        @include('components.tarjeta-receta', ['r' => $receta])
        @endforeach
    </div>

    <div class="mt-12 flex justify-center">
        {{ $recetas->links() }}
    </div>
    @endif
</div>
@endsection
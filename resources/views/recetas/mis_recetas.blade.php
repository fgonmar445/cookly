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
                @include('components.tarjeta-receta', ['r' => $receta])
            @endforeach
        </div>
    @endif
</div>
@endsection
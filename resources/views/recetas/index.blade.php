@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-12">
        <h1 class="text-4xl font-black text-slate-800 mb-2 tracking-tight">Explorador de Recetas</h1>
        <p class="text-slate-500 text-lg">Encuentra tu próxima inspiración culinaria utilizando nuestros potentes motores de búsqueda.</p>
    </div>

    {{-- GRIDS DE NAVEGACIÓN PROFESIONAL --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">

        {{-- Por Nombre --}}
        <a href="{{ route('buscar.nombre') }}" class="group relative bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-2xl hover:shadow-emerald-100 transition-all duration-500 hover:-translate-y-2 overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-50 rounded-bl-full -mr-10 -mt-10 group-hover:bg-emerald-100 transition-colors duration-500"></div>

            <div class="w-16 h-16 bg-emerald-600 rounded-2xl flex items-center justify-center text-white mb-8 shadow-lg shadow-emerald-600/20 group-hover:scale-110 transition-transform duration-500">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>

            <h3 class="text-2xl font-black text-slate-800 mb-3">Por Nombre</h3>
            <p class="text-slate-500 leading-relaxed mb-6">Busca recetas específicas por su nombre original o ingredientes clave.</p>

            <div class="flex items-center text-emerald-600 font-bold text-sm">
                Explorar ahora
                <svg class="w-4 h-4 ml-2 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </div>
        </a>

        {{-- Por Ingredientes --}}
        <a href="{{ route('buscar.ingredientes') }}" class="group relative bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-2xl hover:shadow-emerald-100 transition-all duration-500 hover:-translate-y-2 overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-bl-full -mr-10 -mt-10 group-hover:bg-blue-100 transition-colors duration-500"></div>

            <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center text-white mb-8 shadow-lg shadow-blue-600/20 group-hover:scale-110 transition-transform duration-500">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>

            <h3 class="text-2xl font-black text-slate-800 mb-3">Ingredientes</h3>
            <p class="text-slate-500 leading-relaxed mb-6">Dinos qué tienes en la nevera y te diremos qué puedes cocinar hoy mismo.</p>

            <div class="flex items-center text-blue-600 font-bold text-sm">
                Filtrar despensa
                <svg class="w-4 h-4 ml-2 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </div>
        </a>

        {{-- Por Categoría --}}
        <a href="{{ route('buscar.categorias') }}" class="group relative bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-2xl hover:shadow-amber-100 transition-all duration-500 hover:-translate-y-2 overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-amber-50 rounded-bl-full -mr-10 -mt-10 group-hover:bg-amber-100 transition-colors duration-500"></div>

            <div class="w-16 h-16 bg-amber-500 rounded-2xl flex items-center justify-center text-white mb-8 shadow-lg shadow-amber-500/20 group-hover:scale-110 transition-transform duration-500">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </div>

            <h3 class="text-2xl font-black text-slate-800 mb-3">Categorías</h3>
            <p class="text-slate-500 leading-relaxed mb-6">Explora por tipo de plato: postres, carnes, mariscos, platos vegetarianos y más.</p>

            <div class="flex items-center text-amber-600 font-bold text-sm">
                Ver categorías
                <svg class="w-4 h-4 ml-2 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </div>
        </a>

        {{-- Por Cocina --}}
        <a href="{{ route('buscar.cocinas') }}" class="group relative bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-2xl hover:shadow-indigo-100 transition-all duration-500 hover:-translate-y-2 overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-50 rounded-bl-full -mr-10 -mt-10 group-hover:bg-indigo-100 transition-colors duration-500"></div>

            <div class="w-16 h-16 bg-indigo-600 rounded-2xl flex items-center justify-center text-white mb-8 shadow-lg shadow-indigo-600/20 group-hover:scale-110 transition-transform duration-500">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064" />
                </svg>
            </div>

            <h3 class="text-2xl font-black text-slate-800 mb-3">Cocina del Mundo</h3>
            <p class="text-slate-500 leading-relaxed mb-6">Viaja a través del paladar explorando recetas típicas de docenas de países.</p>

            <div class="flex items-center text-indigo-600 font-bold text-sm">
                Viajar por regiones
                <svg class="w-4 h-4 ml-2 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </div>
        </a>

        {{-- Aleatoria --}}
        <a href="{{ route('buscar.aleatoria') }}" class="group relative bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-2xl hover:shadow-orange-100 transition-all duration-500 hover:-translate-y-2 overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-orange-50 rounded-bl-full -mr-10 -mt-10 group-hover:bg-orange-100 transition-colors duration-500"></div>

            <div class="w-16 h-16 bg-orange-500 rounded-2xl flex items-center justify-center text-white mb-8 shadow-lg shadow-orange-500/20 group-hover:scale-110 transition-transform duration-500">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
            </div>

            <h3 class="text-2xl font-black text-slate-800 mb-3">Receta Aleatoria</h3>
            <p class="text-slate-500 leading-relaxed mb-6">¿Te sientes con suerte? Deja que nosotros elijamos una receta sorpresa para ti.</p>

            <div class="flex items-center text-orange-600 font-bold text-sm">
                Probar suerte
                <svg class="w-4 h-4 ml-2 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </div>
        </a>

        {{-- Recomendador --}}
        <a href="{{ route('buscar.recomendador') }}" class="group relative bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-2xl hover:shadow-violet-100 transition-all duration-500 hover:-translate-y-2 overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-violet-50 rounded-bl-full -mr-10 -mt-10 group-hover:bg-violet-100 transition-colors duration-500"></div>

            <div class="w-16 h-16 bg-violet-600 rounded-2xl flex items-center justify-center text-white mb-8 shadow-lg shadow-violet-600/20 group-hover:scale-110 transition-transform duration-500">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>

            <h3 class="text-2xl font-black text-slate-800 mb-3">Recomendador</h3>
            <p class="text-slate-500 leading-relaxed mb-6">Nuestro motor avanzado para encontrarte la mejor receta basada en tu inventario.</p>

            <div class="flex items-center text-violet-600 font-bold text-sm">
                Generar sugerencias
                <svg class="w-4 h-4 ml-2 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </div>
        </a>

    </div>
</div>
@endsection
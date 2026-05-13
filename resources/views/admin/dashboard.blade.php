@extends('layouts.app')

@section('header_title', 'Panel de Control — Admin')

@section('content')
<div class="space-y-8 animate-fade-in">

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <!-- Total Usuarios -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Usuarios</p>
                    <h4 class="text-2xl font-bold text-slate-800">{{ $totalUsers }}</h4>
                </div>
            </div>
        </div>

        <!-- Total Recetas -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Recetas</p>
                    <h4 class="text-2xl font-bold text-slate-800">{{ $totalRecipes }}</h4>
                </div>
            </div>
        </div>

        <!-- Recetas esta semana -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500">Nuevas esta semana</p>
                    <h4 class="text-2xl font-bold text-slate-800">{{ $recipesThisWeek }}</h4>
                </div>
            </div>
        </div>

        <!-- Total Favoritos -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-orange-50 rounded-2xl flex items-center justify-center text-orange-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Favoritos</p>
                    <h4 class="text-2xl font-bold text-slate-800">{{ $totalFavorites }}</h4>
                </div>
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        <!-- Últimos Usuarios -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-50 flex items-center justify-between">
                <h3 class="font-bold text-slate-800">Usuarios Recientes</h3>
                <a href="{{ route('admin.users') }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 uppercase tracking-wider">Ver todos</a>
            </div>
            <div class="divide-y divide-slate-50">
                @foreach($latestUsers as $user)
                <div class="p-4 flex items-center gap-4 hover:bg-slate-50 transition-colors">
                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 font-bold">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-slate-800">{{ $user->name }}</p>
                        <p class="text-xs text-slate-500">{{ $user->email }}</p>
                    </div>
                    <div class="text-xs text-slate-400">
                        {{ $user->created_at->diffForHumans() }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Últimas Recetas -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-50 flex items-center justify-between">
                <h3 class="font-bold text-slate-800">Recetas de la Comunidad</h3>
                <a href="{{ route('admin.recipes') }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 uppercase tracking-wider">Moderar</a>
            </div>
            <div class="divide-y divide-slate-50">
                @foreach($latestRecipes as $recipe)
                <div class="p-4 flex items-center gap-4 hover:bg-slate-50 transition-colors">
                    @if(!empty($recipe->imagen))
                    <img src="{{ $recipe->imagen }}" class="w-10 h-10 rounded-xl object-cover shadow-sm" alt="">
                    @else
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    @endif
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-slate-800">{{ $recipe->nombre }}</p>
                        <p class="text-xs text-slate-500">Por {{ optional($recipe->usuario)->name ?? 'Anónimo' }}</p>
                    </div>
                    <div class="text-xs text-slate-400">
                        {{ $recipe->created_at->diffForHumans() }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>

    <!-- Acciones Adicionales -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <a href="{{ route('admin.ingredientes.index') }}" class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-all group flex items-center justify-between hover:border-emerald-200">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 group-hover:bg-emerald-100 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800">Gestionar Ingredientes</h3>
                    <p class="text-sm font-medium text-slate-500">Base de datos de alimentos</p>
                </div>
            </div>
            <div class="text-slate-300 group-hover:text-emerald-500 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </div>
        </a>
    </div>

</div>
@endsection
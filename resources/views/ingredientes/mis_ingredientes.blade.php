@extends('layouts.app')

@section('content')

<div class="mb-12 px-2">
    <h1 class="text-3xl font-black text-slate-800 mb-2 tracking-tight">Mi Despensa</h1>
    <p class="text-slate-500 text-sm md:text-base leading-relaxed">Aquí puedes ver todos los ingredientes que tienes actualmente en casa.</p>
</div>

@if ($misIngredientes->isEmpty())
    <div class="text-center py-20 bg-white rounded-3xl border border-slate-100 shadow-sm">
        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
        </div>
        <h3 class="text-xl font-bold text-slate-800 mb-2">Tu despensa está vacía</h3>
        <p class="text-slate-500 mb-8 max-w-xs mx-auto">Comienza a añadir los ingredientes que tienes para recibir recomendaciones.</p>
        <a href="{{ route('ingredientes.index') }}" class="text-emerald-600 font-bold hover:underline">Añadir ingredientes</a>
    </div>
@else
    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
        <ul class="divide-y divide-slate-50">

    @foreach ($misIngredientes as $ing)

    @php

    // Nombre original en español
    $nombreEs = strtolower(trim($ing->nombre));

    // Convertir español → inglés para la API
    $nombreEn = $traducciones['es_to_en'][$nombreEs] ?? $ing->nombre;

    // Para la URL de TheMealDB (primera letra mayúscula)
    $nombreApi = ucfirst($nombreEn);

    // Buscar ingrediente global
    $ingredienteGlobal = DB::table('ingredientes')->where('nombre', $ing->nombre)->first();

    // Imagen: BD → API
    $img = $ingredienteGlobal && $ingredienteGlobal->imagen
    ? $ingredienteGlobal->imagen
    : "https://www.themealdb.com/images/ingredients/{$nombreApi}.png";

    // Nombre mostrado (inglés → español) — ¡AQUÍ ESTABA EL FALLO!
    $nombre = ucfirst($traducciones['en_to_es'][strtolower($nombreEn)] ?? $ing->nombre);
    @endphp





            <li class="flex items-center justify-between p-4 md:p-6 hover:bg-slate-50 transition-colors group">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-slate-50 rounded-2xl overflow-hidden flex items-center justify-center p-1 border border-slate-100 group-hover:bg-white group-hover:shadow-md transition-all">
                        <img src="{{ $img }}" class="w-full h-full object-contain">
                    </div>
                    <span class="font-bold text-slate-700 md:text-lg">{{ $nombre }}</span>
                </div>

                <form action="{{ route('ingredientes.eliminar') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_lista" value="{{ $ing->id_lista }}">
                    <button class="px-5 py-2.5 bg-rose-50 text-rose-600 font-bold rounded-xl hover:bg-rose-600 hover:text-white transition-all text-xs border border-rose-100 active:scale-95">
                        Eliminar
                    </button>
                </form>
            </li>
        @endforeach
    </ul>
</div>

@endif

@endsection
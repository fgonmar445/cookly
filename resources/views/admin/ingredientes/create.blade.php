@extends('layouts.app')

@section('header_title', 'Añadir Ingrediente')

@section('content')
<div class="max-w-2xl mx-auto space-y-6 animate-fade-in">

    <!-- Header Bar -->
    <div class="flex flex-col md:flex-row items-start md:items-center gap-4 justify-between bg-white p-6 rounded-3xl border border-slate-100 shadow-sm mb-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.ingredientes.index') }}" class="w-10 h-10 bg-slate-50 rounded-full flex items-center justify-center text-slate-400 hover:bg-emerald-50 hover:text-emerald-600 transition-colors shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Añadir Nuevo Ingrediente</h2>
                <p class="text-slate-500 text-sm mt-1">Completa los datos para registrarlo en la base.</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
        <form action="{{ route('admin.ingredientes.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Nombre -->
            <div class="space-y-2">
                <label for="nombre" class="block text-sm font-semibold text-slate-700 ml-1">Nombre del Ingrediente</label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required
                    class="w-full px-4 py-3 bg-slate-50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none text-slate-700 font-medium">
                @error('nombre')
                    <p class="text-sm text-rose-500 mt-1 ml-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Categoría -->
            <div class="space-y-2">
                <label for="categoria" class="block text-sm font-semibold text-slate-700 ml-1">Categoría</label>
                <select name="categoria" id="categoria" required
                    class="w-full px-4 py-3 bg-slate-50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none text-slate-700 font-medium appearance-none">
                    <option value="" disabled selected>Selecciona una categoría</option>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat }}" {{ old('categoria') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
                @error('categoria')
                    <p class="text-sm text-rose-500 mt-1 ml-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Es Base -->
            <div class="flex items-center ml-1 pt-2">
                <input type="checkbox" name="es_base" id="es_base" value="1" {{ old('es_base') ? 'checked' : '' }}
                    class="w-5 h-5 rounded-lg border-2 border-slate-200 text-emerald-600 focus:ring-emerald-500 transition-all cursor-pointer">
                <label for="es_base" class="ml-3 text-sm font-medium text-slate-600 cursor-pointer select-none">
                    Es ingrediente base (recomendado para filtros)
                </label>
            </div>

            <!-- Acciones -->
            <div class="pt-6 border-t border-slate-100 flex justify-end">
                <button type="submit" class="px-8 py-3.5 bg-emerald-600 text-white font-bold rounded-2xl shadow-lg shadow-emerald-200 hover:bg-emerald-700 hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200">
                    Guardar Ingrediente
                </button>
            </div>
        </form>
    </div>

</div>
@endsection

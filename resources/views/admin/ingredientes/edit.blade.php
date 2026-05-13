@extends('layouts.app')

@section('header_title', 'Editar Ingrediente')

@section('content')
<div class="max-w-2xl mx-auto space-y-6 animate-fade-in">

    <div class="flex items-center gap-4">
        <a href="{{ route('admin.ingredientes.index') }}" class="text-slate-400 hover:text-emerald-600 transition-colors">
            &larr; Volver
        </a>
        <h2 class="text-2xl font-bold text-slate-800">Editar Ingrediente: {{ $ingrediente->nombre }}</h2>
    </div>

    <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
        <form action="{{ route('admin.ingredientes.update', $ingrediente->id_ingrediente) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Nombre -->
            <div class="space-y-2">
                <label for="nombre" class="block text-sm font-semibold text-slate-700 ml-1">Nombre del Ingrediente</label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $ingrediente->nombre) }}" required
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
                    <option value="" disabled>Selecciona una categoría</option>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat }}" {{ old('categoria', $ingrediente->categoria) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
                @error('categoria')
                    <p class="text-sm text-rose-500 mt-1 ml-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Es Base -->
            <div class="flex items-center ml-1 pt-2">
                <input type="checkbox" name="es_base" id="es_base" value="1" {{ old('es_base', $ingrediente->es_base) ? 'checked' : '' }}
                    class="w-5 h-5 rounded-lg border-2 border-slate-200 text-emerald-600 focus:ring-emerald-500 transition-all cursor-pointer">
                <label for="es_base" class="ml-3 text-sm font-medium text-slate-600 cursor-pointer select-none">
                    Es ingrediente base (recomendado para filtros)
                </label>
            </div>

            <!-- Acciones -->
            <div class="pt-6 border-t border-slate-100 flex justify-end">
                <button type="submit" class="px-8 py-3.5 bg-emerald-600 text-white font-bold rounded-2xl shadow-lg shadow-emerald-200 hover:bg-emerald-700 hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200">
                    Actualizar Ingrediente
                </button>
            </div>
        </form>
    </div>

</div>
@endsection

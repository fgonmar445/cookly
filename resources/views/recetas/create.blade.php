@extends('layouts.app')

@section('header_title', 'Crear Nueva Receta')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex flex-col md:flex-row gap-12">
        <!-- Sidebar within content for context (optional, but let's keep it simple) -->
        <div class="flex-1">
            <form action="{{ route('recetas.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- Nombre -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Nombre de la receta</label>
                            <input type="text" name="nombre" required
                                class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-slate-700 
                                      focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none"
                                placeholder="Ej: Pasta carbonara tradicional">
                        </div>

                        <!-- Categoría -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Categoría</label>
                            <select name="categoria"
                                class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-slate-700 
                                       focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none appearance-none">
                                <option value="">Selecciona una categoría</option>
                                @php
                                $categorias = ["Entrantes", "Sopas y cremas", "Ensaladas", "Pastas", "Arroces", "Carnes", "Aves", "Pescados", "Mariscos", "Verduras", "Legumbres", "Salsas", "Panes y masas", "Postres", "Bebidas"];
                                @endphp
                                @foreach($categorias as $cat)
                                <option value="{{ $cat }}">{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Cocina -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Tipo de Cocina</label>
                            <select name="area"
                                class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-slate-700 
                                       focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none appearance-none">
                                <option value="">Selecciona un tipo de cocina</option>
                                @php
                                $cocinas = ["Española", "Italiana", "Mexicana", "Japonesa", "China", "India", "Mediterránea", "Americana", "Francesa", "Griega", "Tailandesa", "Coreana", "Árabe", "Turca", "Marroquí"];
                                @endphp
                                @foreach($cocinas as $cocina)
                                <option value="{{ $cocina }}">Cocina {{ $cocina }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Imagen -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Fotografía del plato</label>
                            <div class="relative group">
                                <input type="file" name="imagen" accept="image/*"
                                    class="w-full rounded-xl border border-dashed border-slate-300 bg-slate-50/50 px-4 py-8 text-slate-500 
                                          text-center cursor-pointer hover:border-emerald-400 hover:bg-emerald-50/30 transition-all">
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Descripción -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Instrucciones y descripción</label>
                            <textarea name="descripcion" rows="12" required
                                class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-slate-700 
                                             focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none resize-none"
                                placeholder="Describe el paso a paso detallado de tu receta..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex items-center justify-end gap-4 pt-8 border-t border-slate-100">
                    <a href="{{ route('recetas.mias') }}"
                        class="px-6 py-3 bg-white border border-slate-200 text-slate-600 font-bold rounded-2xl hover:bg-slate-50 hover:border-slate-300 transition-all active:scale-95">
                        Descartar
                    </a>
                    <button type="submit"
                        class="px-10 py-3 bg-emerald-600 text-white font-bold rounded-2xl hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 transition-all active:scale-95 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Publicar Receta
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
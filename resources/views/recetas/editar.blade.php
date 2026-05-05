@extends('layouts.app')

@section('header_title', 'Editar Receta')

@section('content')
<div class="max-w-4xl mx-auto">
    <form action="{{ route('recetas.update', $receta->id_receta) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Left Column -->
            <div class="space-y-6">
                <!-- Nombre -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nombre de la receta</label>
                    <input type="text" name="nombre" value="{{ $receta->nombre }}" required
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-slate-700 
                              focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none">
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
                        <option value="{{ $cat }}" {{ $receta->categoria == $cat ? 'selected' : '' }}>{{ $cat }}</option>
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
                        <option value="{{ $cocina }}" {{ $receta->area == $cocina ? 'selected' : '' }}>Cocina {{ $cocina }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Imagen -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Cambiar fotografía</label>
                    <div class="relative group">
                        <input type="file" name="imagen" accept="image/*"
                            class="w-full rounded-xl border border-dashed border-slate-300 bg-slate-50/50 px-4 py-8 text-slate-500 
                                  text-center cursor-pointer hover:border-emerald-400 hover:bg-emerald-50/30 transition-all">
                    </div>
                    @if($receta->imagen)
                        <p class="mt-2 text-xs text-slate-400 italic">Dejar vacío para mantener la imagen actual.</p>
                    @endif
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-6">
                <!-- Ingredientes -->
                <div class="bg-slate-50 p-6 rounded-3xl border border-slate-100">
                    <div class="flex items-center justify-between mb-4">
                        <label class="text-sm font-bold text-slate-700">Ingredientes necesarios</label>
                        <button type="button" onclick="addIngrediente()" 
                            class="text-[10px] font-black uppercase tracking-widest text-emerald-600 hover:text-emerald-700 transition-colors flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                            </svg>
                            Añadir otro
                        </button>
                    </div>
                    
                    <div id="contenedor-ingredientes" class="space-y-3">
                        @forelse($receta->ingredientes as $ingRel)
                        <div class="flex gap-2 items-center fila-ingrediente animate-fade-in">
                            <select name="ingredientes_ids[]" required
                                class="flex-1 rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs text-slate-700 focus:border-emerald-500 outline-none">
                                <option value="">Selecciona ingrediente</option>
                                @foreach($ingredientes as $ing)
                                    <option value="{{ $ing->id_ingrediente }}" {{ $ingRel->id_ingrediente == $ing->id_ingrediente ? 'selected' : '' }}>
                                        {{ $ing->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="text" name="cantidades[]" value="{{ $ingRel->pivot->cantidad }}" placeholder="Cant." required
                                class="w-32 rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs text-slate-700 focus:border-emerald-500 outline-none">
                            <button type="button" onclick="this.closest('.fila-ingrediente').remove()" class="p-2 text-slate-300 hover:text-rose-500 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                        @empty
                        <div class="flex gap-2 items-center fila-ingrediente animate-fade-in">
                            <select name="ingredientes_ids[]" required
                                class="flex-1 rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs text-slate-700 focus:border-emerald-500 outline-none">
                                <option value="">Selecciona ingrediente</option>
                                @foreach($ingredientes as $ing)
                                    <option value="{{ $ing->id_ingrediente }}">{{ $ing->nombre }}</option>
                                @endforeach
                            </select>
                            <input type="text" name="cantidades[]" placeholder="Cant." required
                                class="w-32 rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs text-slate-700 focus:border-emerald-500 outline-none">
                            <button type="button" onclick="this.closest('.fila-ingrediente').remove()" class="p-2 text-slate-300 hover:text-rose-500 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                        @endforelse
                    </div>
                </div>

                <script>
                    function addIngrediente() {
                        const contenedor = document.getElementById('contenedor-ingredientes');
                        const filas = contenedor.querySelectorAll('.fila-ingrediente');
                        const nuevaFila = filas[0].cloneNode(true);
                        
                        // Limpiar valores
                        nuevaFila.querySelectorAll('input, select').forEach(el => el.value = '');
                        
                        contenedor.appendChild(nuevaFila);
                    }
                </script>

                <!-- Descripción -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Instrucciones detalladas</label>
                    <textarea name="descripcion" rows="8" required
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-slate-700 
                                     focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none resize-none"
                        placeholder="Describe el paso a paso detallado de tu receta...">{{ $receta->descripcion }}</textarea>
                </div>
            </div>
        </div>

        <!-- Botones -->
        <div class="flex items-center justify-end gap-4 pt-8 border-t border-slate-100">
            <a href="{{ route('recetas.mias') }}"
                class="px-6 py-3 bg-white border border-slate-200 text-slate-600 font-bold rounded-2xl hover:bg-slate-50 hover:border-slate-300 transition-all active:scale-95">
                Cancelar
            </a>
            <button type="submit"
                class="px-10 py-3 bg-emerald-600 text-white font-bold rounded-2xl hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 transition-all active:scale-95 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Guardar Cambios
            </button>
        </div>
    </form>
</div>
@endsection
@extends('layouts.app')

@section('header_title', 'Crear Nueva Receta')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex flex-col md:flex-row gap-12">
        <!-- Sidebar within content for context (optional, but let's keep it simple) -->
        <div class="flex-1">
            @if ($errors->any())
                <div class="mb-6 p-4 bg-rose-50 border border-rose-100 rounded-2xl text-rose-600 text-sm font-medium">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

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
                            <select name="cocina"
                                class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-slate-700 
                                       focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none appearance-none">
                                <option value="">Selecciona un tipo de cocina</option>
                                @foreach(config('ingredients.cocinas') as $cocina)
                                <option value="{{ ucfirst($cocina) }}">Cocina {{ ucfirst($cocina) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Imagen -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Fotografía del plato</label>
                            <div class="relative group">
                                <input type="file" name="imagen" id="imagen-input" accept="image/*"
                                    class="w-full rounded-xl border border-dashed border-slate-300 bg-slate-50/50 px-4 py-8 text-slate-500 
                                          text-center cursor-pointer hover:border-emerald-400 hover:bg-emerald-50/30 transition-all">
                                
                                <!-- Preview Container -->
                                <div id="preview-container" class="hidden mt-4 relative rounded-2xl overflow-hidden border border-slate-200">
                                    <img id="image-preview" src="#" alt="Vista previa" class="w-full h-48 object-cover">
                                    <button type="button" onclick="removeImage()" 
                                        class="absolute top-2 right-2 bg-rose-500 text-white p-1.5 rounded-full shadow-lg hover:bg-rose-600 transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
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
                                <!-- Fila de ingrediente base -->
                                <div class="flex gap-2 items-center fila-ingrediente animate-fade-in">
                                    <select name="ingredientes_ids[]" required
                                        class="flex-1 rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs text-slate-700 focus:border-emerald-500 outline-none">
                                        <option value="">Selecciona ingrediente</option>
                                        @foreach($ingredientes as $ing)
                                            <option value="{{ $ing->id_ingrediente }}">{{ $ing->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <input type="text" name="cantidades[]" placeholder="Cant. (ej: 200g)" required
                                        class="w-32 rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs text-slate-700 focus:border-emerald-500 outline-none">
                                    <button type="button" onclick="this.closest('.fila-ingrediente').remove()" class="p-2 text-slate-300 hover:text-rose-500 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Template para JS -->
                        <template id="ingrediente-template">
                            <div class="flex gap-2 items-center fila-ingrediente animate-fade-in">
                                <select name="ingredientes_ids[]" required
                                    class="flex-1 rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs text-slate-700 focus:border-emerald-500 outline-none">
                                    <option value="">Selecciona ingrediente</option>
                                    @foreach($ingredientes as $ing)
                                        <option value="{{ $ing->id_ingrediente }}">{{ $ing->nombre }}</option>
                                    @endforeach
                                </select>
                                <input type="text" name="cantidades[]" placeholder="Cant. (ej: 200g)" required
                                    class="w-32 rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs text-slate-700 focus:border-emerald-500 outline-none">
                                <button type="button" onclick="this.closest('.fila-ingrediente').remove()" class="p-2 text-slate-300 hover:text-rose-500 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </template>

                        <!-- Descripción -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Instrucciones detalladas</label>
                            <textarea name="descripcion" rows="8" required
                                class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-slate-700 
                                             focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none resize-none"
                                placeholder="Describe el paso a paso detallado de tu receta..."></textarea>
                        </div>
                    </div>
                </div>

                <script>
                    function addIngrediente() {
                        const contenedor = document.getElementById('contenedor-ingredientes');
                        const template = document.getElementById('ingrediente-template');
                        const clone = template.content.cloneNode(true);
                        contenedor.appendChild(clone);
                    }

                    // Image Preview Logic
                    const input = document.getElementById('imagen-input');
                    const preview = document.getElementById('image-preview');
                    const previewContainer = document.getElementById('preview-container');

                    input.addEventListener('change', function() {
                        const file = this.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                preview.src = e.target.result;
                                previewContainer.classList.remove('hidden');
                            }
                            reader.readAsDataURL(file);
                        }
                    });

                    function removeImage() {
                        input.value = '';
                        preview.src = '#';
                        previewContainer.classList.add('hidden');
                    }
                </script>

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
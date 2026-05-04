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
                <!-- Descripción -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Instrucciones y descripción</label>
                    <textarea name="descripcion" rows="12" required
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-slate-700 
                                     focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none resize-none"
                        placeholder="Describe el paso a paso detallado de tu receta...">{{ $receta->descripcion }}</textarea>
                </div>
            </div>
        </div>

        <!-- Botones -->
        <div class="flex items-center justify-end gap-4 pt-8 border-t border-slate-200">
            <a href="{{ route('recetas.mias') }}"
                class="px-6 py-3 rounded-xl font-semibold text-slate-600 hover:bg-slate-100 transition-all">
                Cancelar
            </a>
            <button type="submit"
                class="px-8 py-3 rounded-xl bg-emerald-600 text-white font-bold hover:bg-emerald-700 hover:shadow-lg hover:shadow-emerald-200 transition-all">
                Guardar Cambios
            </button>
        </div>
    </form>
</div>
@endsection
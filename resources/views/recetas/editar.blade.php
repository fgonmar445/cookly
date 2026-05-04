@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow">

    <h2 class="text-3xl font-bold mb-6 text-gray-800">Editar receta</h2>

    <form action="{{ route('recetas.update', $receta->id_receta) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Nombre -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-1">Nombre</label>
            <input type="text" name="nombre" value="{{ $receta->nombre }}"
                class="w-full rounded-lg border border-emerald-500 px-4 py-2 text-gray-700 
                          focus:border-emerald-600 focus:ring-emerald-600 shadow-sm transition">
        </div>

        <!-- Descripción -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-1">Descripción</label>
            <textarea name="descripcion" rows="4"
                class="w-full rounded-lg border border-emerald-500 px-4 py-2 text-gray-700 
                             focus:border-emerald-600 focus:ring-emerald-600 shadow-sm transition">{{ $receta->descripcion }}</textarea>
        </div>

        <!-- Categoría -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-1">Categoría</label>
            <select name="categoria"
                class="w-full rounded-lg border border-emerald-500 px-4 py-2 text-gray-700 
                       focus:border-emerald-600 focus:ring-emerald-600 shadow-sm transition">

                <option value="">Selecciona una categoría</option>

                @php
                $categorias = [
                "Entrantes", "Sopas y cremas", "Ensaladas", "Pastas", "Arroces",
                "Carnes", "Aves", "Pescados", "Mariscos", "Verduras",
                "Legumbres", "Salsas", "Panes y masas", "Postres", "Bebidas"
                ];
                @endphp

                @foreach($categorias as $cat)
                <option value="{{ $cat }}" {{ $receta->categoria == $cat ? 'selected' : '' }}>
                    {{ $cat }}
                </option>
                @endforeach

            </select>
        </div>

        <!-- Cocina -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-1">Cocina</label>
            <select name="area"
                class="w-full rounded-lg border border-emerald-500 px-4 py-2 text-gray-700 
                       focus:border-emerald-600 focus:ring-emerald-600 shadow-sm transition">

                <option value="">Selecciona un tipo de cocina</option>

                @php
                $cocinas = [
                "Española", "Italiana", "Mexicana", "Japonesa", "China",
                "India", "Mediterránea", "Americana", "Francesa", "Griega",
                "Tailandesa", "Coreana", "Árabe", "Turca", "Marroquí"
                ];
                @endphp

                @foreach($cocinas as $cocina)
                <option value="{{ $cocina }}" {{ $receta->area == $cocina ? 'selected' : '' }}>
                    Cocina {{ strtolower($cocina) }}
                </option>
                @endforeach

            </select>
        </div>

        <!-- Botones -->
        <div class="flex justify-between mt-6">

            <!-- Guardar (izquierda) -->
            <button type="submit"
                class="px-4 py-2 rounded-lg bg-emerald-600 text-white hover:bg-emerald-700 transition">
                Guardar cambios
            </button>

            <!-- Cancelar (derecha) -->
            <a href="{{ route('recetas.mias') }}"
                class="px-4 py-2 rounded-lg border border-gray-400 text-gray-600 hover:bg-gray-100 transition">
                Cancelar
            </a>

        </div>

    </form>

</div>
@endsection
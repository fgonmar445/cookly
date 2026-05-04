@extends('layouts.app')

@section('content')

<h2 class="text-2xl font-bold mb-6 text-gray-800">Crear nueva receta</h2>

<div class="bg-white p-6 rounded-xl shadow max-w-3xl">

    <form action="{{ route('recetas.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- NOMBRE --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-1">Nombre de la receta</label>
            <input
                type="text"
                name="nombre"
                required
                class="w-full rounded-lg border border-gray-300 px-4 py-2 text-gray-700 
                       focus:border-emerald-500 focus:ring-emerald-500 shadow-sm transition">
        </div>

        {{-- CATEGORÍA --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-1">Categoría</label>
            <input
                type="text"
                name="categoria"
                placeholder="Ej: Pasta, Carne, Postre..."
                class="w-full rounded-lg border border-gray-300 px-4 py-2 text-gray-700 
                       focus:border-emerald-500 focus:ring-emerald-500 shadow-sm transition">
        </div>

        {{-- INGREDIENTES --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-1">Ingredientes</label>
            <textarea
                name="ingredientes"
                rows="4"
                placeholder="Ej: 200g de pasta, 1 tomate, aceite..."
                class="w-full rounded-lg border border-gray-300 px-4 py-2 text-gray-700 
                       focus:border-emerald-500 focus:ring-emerald-500 shadow-sm transition"></textarea>
        </div>

        {{-- INSTRUCCIONES --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-1">Instrucciones</label>
            <textarea
                name="instrucciones"
                rows="6"
                placeholder="Describe paso a paso cómo preparar la receta..."
                class="w-full rounded-lg border border-gray-300 px-4 py-2 text-gray-700 
                       focus:border-emerald-500 focus:ring-emerald-500 shadow-sm transition"></textarea>
        </div>

        {{-- IMAGEN --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-1">Imagen (opcional)</label>
            <input
                type="file"
                name="imagen"
                accept="image/*"
                class="w-full rounded-lg border border-gray-300 px-4 py-2 text-gray-700 
                       focus:border-emerald-500 focus:ring-emerald-500 shadow-sm transition bg-white">
        </div>

        {{-- BOTÓN --}}
        <button
            type="submit"
            class="bg-emerald-600 text-white px-5 py-2 rounded-lg font-semibold 
                   hover:bg-emerald-700 transition shadow">
            Crear receta
        </button>

    </form>

</div>

@endsection
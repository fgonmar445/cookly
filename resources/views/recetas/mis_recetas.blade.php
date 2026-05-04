@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">

    <h2 class="text-3xl font-bold mb-6 text-gray-800">Mis recetas</h2>

    @if($recetas->isEmpty())
    <p class="text-gray-600">Todavía no has creado ninguna receta.</p>
    @else

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        @foreach($recetas as $receta)

        <div class="relative bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden">

            <!-- TARJETA CLICABLE -->
            <a href="{{ route('recetas.show', $receta->id_receta) }}" class="block">

                <img src="{{ $receta->imagen ? asset('storage/'.$receta->imagen) : '/img/no-image.png' }}"
                    class="w-full h-40 object-cover">

                <div class="p-4 pb-12"> <!-- pb-10 para que los botones no tapen el texto -->

                    <h3 class="font-semibold text-lg text-gray-800">{{ $receta->nombre }}</h3>

                    <!-- Categoría y Cocina mejoradas -->
                    <p class="text-sm text-gray-600 mt-2 font-medium">
                        <span class="text-emerald-600">{{ $receta->categoria ?? 'Sin categoría' }}</span>
                        ·
                        <span class="text-gray-700">{{ $receta->area ?? 'Sin cocina' }}</span>
                    </p>

                </div>

            </a>

            <!-- BOTÓN EDITAR (ESQUINA IZQUIERDA) -->
            <div class="absolute bottom-3 left-3">
                <a href="{{ route('recetas.edit', $receta->id_receta) }}"
                    class="px-3 py-1 rounded-md border border-emerald-500 text-emerald-600 
                              bg-white/90 backdrop-blur hover:bg-emerald-50 transition text-sm shadow-sm"
                    onclick="event.stopPropagation()">
                    Editar
                </a>
            </div>

            <!-- BOTÓN BORRAR (ESQUINA DERECHA) -->
            <div class="absolute bottom-3 right-3">
                <form action="{{ route('recetas.destroy', $receta->id_receta) }}" method="POST"
                    onsubmit="return confirm('¿Seguro que quieres borrar esta receta?')"
                    onclick="event.stopPropagation()">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-3 py-1 rounded-md bg-red-600 text-white hover:bg-red-700 
                                   transition text-sm shadow-sm">
                        Borrar
                    </button>
                </form>
            </div>

        </div>

        @endforeach

    </div>

    @endif

</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">

    <h2 class="text-3xl font-bold mb-6 text-gray-800">Mis recetas</h2>

    @if($recetas->isEmpty())
    <p class="text-gray-600">Todavía no has creado ninguna receta.</p>
    @else

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        @foreach($recetas as $receta)

        <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden">

            <img src="{{ $receta->imagen ? asset('storage/'.$receta->imagen) : '/img/no-image.png' }}"
                class="w-full h-40 object-cover">

            <div class="p-4">
                <h3 class="font-semibold text-lg text-gray-800">{{ $receta->nombre }}</h3>

                <p class="text-sm text-gray-500 mt-1">
                    {{ $receta->categoria ?? 'Sin categoría' }} ·
                    {{ $receta->area ?? 'Sin cocina' }}
                </p>

                <!-- Botón Ver receta -->
                <a href="{{ route('recetas.show', $receta->id_receta) }}"
                    class="mt-3 inline-block px-3 py-1 rounded-lg bg-emerald-600 text-white 
                              hover:bg-emerald-700 transition text-sm">
                    Ver receta
                </a>

                <!-- Botones Editar / Borrar -->
                <div class="flex gap-2 mt-4">

                    <!-- Editar -->
                    <a href="{{ route('recetas.edit', $receta->id_receta) }}"
                        class="px-3 py-1 rounded-lg border border-emerald-500 text-emerald-600 
                                  hover:bg-emerald-50 transition text-sm">
                        Editar
                    </a>

                    <!-- Borrar -->
                    <form action="{{ route('recetas.destroy', $receta->id_receta) }}" method="POST"
                        onsubmit="return confirm('¿Seguro que quieres borrar esta receta?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-3 py-1 rounded-lg bg-red-600 text-white hover:bg-red-700 
                                       transition text-sm">
                            Borrar
                        </button>
                    </form>

                </div>
            </div>
        </div>

        @endforeach

    </div>

    @endif

</div>
@endsection
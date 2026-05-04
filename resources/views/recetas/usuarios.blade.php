@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">

    <h2 class="text-3xl font-bold mb-6 text-gray-800">Últimas recetas creadas por usuarios</h2>

    @if($recetas->isEmpty())
    <p class="text-gray-600">Todavía no hay recetas creadas por usuarios.</p>
    @else

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        @foreach($recetas as $receta)

        <a href="{{ route('recetas.show', $receta->id_receta) }}"
            class="block bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden">

            <img src="{{ $receta->imagen ? asset('storage/'.$receta->imagen) : '/img/no-image.png' }}"
                class="w-full h-40 object-cover">

            <div class="p-4">
                <h3 class="font-semibold text-lg text-gray-800">{{ $receta->nombre }}</h3>

                <p class="text-sm text-gray-500 mt-1">
                    {{ $receta->categoria ?? 'Sin categoría' }} ·
                    {{ $receta->area ?? 'Sin cocina' }}
                </p>
            </div>

        </a>

        @endforeach

    </div>

    {{-- Paginación opcional --}}
    <div class="mt-6">
        {{ $recetas->links() }}
    </div>

    @endif

</div>
@endsection
@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto">

    <h1 class="text-3xl font-bold text-gray-800 mb-6">
        Categorías de ingredientes
    </h1>

    <p class="text-gray-600 mb-6">
        Selecciona una categoría para ver sus ingredientes.
    </p>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

        @foreach ($categorias as $en => $es)
        <a href="{{ route('ingredientes.index', $es) }}"
            class="bg-white border border-gray-200 p-4 rounded-xl shadow-sm hover:shadow transition text-center">
            <span class="font-semibold text-emerald-700">{{ $es }}</span>
        </a>
        @endforeach

    </div>

</div>

@endsection
@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-4">Dashboard</h1>

<p class="text-gray-600 mb-6">
    Bienvenido a Cookly — tu sistema de recetas e ingredientes.
</p>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4">

    <div class="bg-green-100 p-4 rounded-xl shadow">
        <h2 class="font-bold">Ingredientes</h2>
        <p class="text-sm text-gray-600">Gestiona tus ingredientes</p>
    </div>

    <div class="bg-blue-100 p-4 rounded-xl shadow">
        <h2 class="font-bold">Recetas</h2>
        <p class="text-sm text-gray-600">Explora recetas</p>
    </div>

    <div class="bg-yellow-100 p-4 rounded-xl shadow">
        <h2 class="font-bold">Favoritos</h2>
        <p class="text-sm text-gray-600">Tus recetas guardadas</p>
    </div>

</div>

@endsection
@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-4">Mis favoritos</h1>

<div id="lista" class="grid grid-cols-1 md:grid-cols-3 gap-4"></div>

{{-- PLANTILLA PARA JS --}}
<template id="tarjeta-template">
    @include('components.tarjeta-receta', ['r' => null])
</template>

{{-- MENSAJE SI NO HAY FAVORITOS --}}
<p id="vacio" class="text-gray-500 text-center mt-10 hidden">
    No tienes recetas en favoritos todavía.
</p>

<script>
    async function cargar() {
        let res = await fetch('/favoritos-json');
        let data = await res.json();
        console.log("DATA:", data);

        let cont = document.getElementById('lista');
        let vacio = document.getElementById('vacio');
        let template = document.getElementById('tarjeta-template').innerHTML;

        cont.innerHTML = '';

        if (data.length === 0) {
            vacio.classList.remove('hidden');
            return;
        }

        vacio.classList.add('hidden');

        data.forEach(f => {
            // Mapeamos los datos de la BD a la estructura que espera el componente (estilo API)
            let html = template
                .replace(/STR_MEAL_THUMB/g, f.imagen)
                .replace(/STR_MEAL/g, f.nombre)
                .replace(/ID_MEAL/g, f.id_receta_api)
                .replace('Añadir', 'Eliminar'); // En favoritos siempre es para eliminar

            cont.innerHTML += html;
        });
    }

    // Definimos toggleFavorito para que sea compatible con el componente
    async function toggleFavorito(id, btn) {
        await fetch('/favoritos/toggle/' + id, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        // Recargar la lista para que desaparezca la tarjeta eliminada
        cargar();
    }

    cargar();
</script>

@endsection
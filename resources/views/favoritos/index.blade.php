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
    const currentUserId = {{ Auth::id() }};

    async function cargar() {
        let res = await fetch('/favoritos-json');
        let data = await res.json();
        
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
            let div = document.createElement('div');
            div.innerHTML = template
                .replace(/STR_MEAL_THUMB/g, f.imagen)
                .replace(/STR_MEAL/g, f.nombre)
                .replace(/ID_MEAL/g, f.id_receta_api)
                .replace(/ID_RECETA_VAL/g, f.id_receta)
                .replace('Añadir', 'Eliminar');

            let card = div.firstElementChild;
            
            // Si la receta es del usuario, mostrar botones de gestión
            if (f.id_usuario && f.id_usuario == currentUserId) {
                let buttons = card.querySelector('.management-buttons');
                if (buttons) {
                    buttons.classList.remove('hidden');
                    buttons.classList.remove('opacity-0');
                    buttons.classList.add('opacity-100');
                }
            }

            cont.appendChild(card);
        });
    }

    cargar();
</script>

@endsection
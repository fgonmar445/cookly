@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-4">Favoritos</h1>

<div id="lista" class="space-y-3"></div>

<script>
    async function cargar() {
        let res = await fetch('/api/favoritos');
        let data = await res.json();

        let cont = document.getElementById('lista');
        cont.innerHTML = '';

        data.forEach(f => {
            cont.innerHTML += `
            <div class="bg-white p-3 rounded shadow flex justify-between">
                <span>Receta: ${f.id_receta_api}</span>

                <button onclick="eliminar(${f.id_favorito})"
                    class="bg-red-500 text-white px-2 py-1 rounded text-sm">
                    Eliminar
                </button>
            </div>
        `;
        });
    }

    async function eliminar(id) {
        await fetch('/api/favoritos/' + id, {
            method: 'DELETE'
        });

        cargar();
    }

    cargar();
</script>

@endsection
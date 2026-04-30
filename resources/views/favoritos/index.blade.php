@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-4">Mis favoritos</h1>

<div id="lista" class="grid grid-cols-1 md:grid-cols-3 gap-4"></div>

{{-- MENSAJE SI NO HAY FAVORITOS --}}
<p id="vacio" class="text-gray-500 text-center mt-10 hidden">
    No tienes recetas en favoritos todavía.
</p>

<script>
    async function cargar() {
        let res = await fetch('/favoritos-json');
        let data = await res.json();
        console.log("DATA:", data); // <-- para verificar

        let cont = document.getElementById('lista');
        let vacio = document.getElementById('vacio');

        cont.innerHTML = '';

        if (data.length === 0) {
            vacio.classList.remove('hidden');
            return;
        }

        vacio.classList.add('hidden');

        data.forEach(f => {
            cont.innerHTML += `
            <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-3">
                <img src="${f.imagen}" class="rounded mb-3">

                <h3 class="font-bold text-lg mb-1">${f.nombre}</h3>
            
                <p class="text-sm text-gray-600 mb-2">
                    ${f.categoria ?? ''} • ${f.area ?? ''}
                </p>

                <div class="flex justify-between items-center">
                    <a href="/receta/${f.id_receta_api}"
                        class="bg-emerald-600 text-white px-3 py-1 rounded inline-block text-sm"> 
                        Ver receta
                    </a>

                    <button onclick="eliminar(${f.id_favorito})"
                        class="inline-flex items-center justify-center 
           bg-white border border-emerald-600 text-emerald-600 
           hover:bg-emerald-50 
           px-3 py-1 rounded text-sm font-semibold transition-colors">
                        Eliminar
                    </button>
                </div>
            </div>
        `;
        });
    }


    async function eliminar(id) {
        await fetch('/favoritos/toggle/' + id, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });


        cargar();
    }

    cargar();
</script>

@endsection
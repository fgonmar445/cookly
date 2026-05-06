@php
    // Detectar si es un objeto (Eloquent) o un array (API)
    $isObject = is_object($r);
    $isNull = is_null($r) || (is_array($r) && empty($r));
    
    // Extraer datos básicos unificados
    $id = $isObject ? ($r->id_receta_api ?? $r->id_receta) : ($r['idMeal'] ?? 'ID_MEAL');
    $nombre = $isObject ? $r->nombre : ($r['strMeal'] ?? 'STR_MEAL');
    $imagen = $isObject ? ($r->imagen ? (str_starts_with($r->imagen, 'http') ? $r->imagen : (str_starts_with($r->imagen, '/storage/') ? asset($r->imagen) : asset('storage/'.$r->imagen))) : asset('img/no-image.png')) : ($r['strMealThumb'] ?? 'STR_MEAL_THUMB');
    $categoria = $isObject ? $r->categoria : ($r['strCategory'] ?? null);
    
    // Comprobar propiedad del usuario para mostrar botones de edición/borrado
    $esMia = false;
    $currentUserId = Auth::id();
    if (Auth::check() && !$isNull) {
        $ownerId = $isObject ? $r->id_usuario : ($r['id_usuario'] ?? null);
        $esMia = $ownerId == $currentUserId;
    }

    $esFavorita = $isObject ? false : ($r['esFavorita'] ?? false);
@endphp

<div class="group bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-emerald-100/50 transition-all duration-300 overflow-hidden flex flex-col h-full relative" 
     data-owner-id="{{ $isObject ? $r->id_usuario : ($r['id_usuario'] ?? '') }}">
    
    <!-- Botones de Gestión (Solo si es mía o es plantilla JS) -->
    <div class="absolute top-3 left-3 z-10 flex gap-2 {{ $esMia ? 'opacity-100' : ($isNull ? 'opacity-0 group-hover:opacity-100 is-template hidden' : 'hidden') }} management-buttons">
        <a href="{{ route('recetas.edit', 'ID_RECETA_VAL') }}" 
           class="w-8 h-8 flex items-center justify-center bg-white/90 backdrop-blur rounded-lg text-emerald-600 shadow-sm hover:bg-emerald-500 hover:text-white transition-all edit-link">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
        </a>
        <form action="{{ route('recetas.destroy', 'ID_RECETA_VAL') }}" method="POST" onsubmit="return confirm('¿Borrar esta receta?')" class="delete-form">
            @csrf
            @method('DELETE')
            <button type="submit" class="w-8 h-8 flex items-center justify-center bg-white/90 backdrop-blur rounded-lg text-red-600 shadow-sm hover:bg-red-500 hover:text-white transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </button>
        </form>
    </div>

    @if($esMia && !$isNull)
    <script>
        // Actualizar los enlaces para recetas reales en el servidor
        (function() {
            const card = document.currentScript.parentElement;
            const id = "{{ $isObject ? $r->id_receta : ($r['id_receta'] ?? '') }}";
            card.querySelector('.edit-link').href = card.querySelector('.edit-link').href.replace('ID_RECETA_VAL', id);
            card.querySelector('.delete-form').action = card.querySelector('.delete-form').action.replace('ID_RECETA_VAL', id);
        })();
    </script>
    @endif

    <!-- Image Wrapper -->
    <div class="relative h-48 overflow-hidden">
        <img src="{{ $imagen }}" 
             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-5">
            <a href="/receta/{{ $id }}" class="text-white font-bold text-xs uppercase tracking-widest underline underline-offset-4">
                Ver Receta
            </a>
        </div>
        
        @if($categoria)
        <div class="absolute top-3 right-3 px-2 py-1 bg-black/40 backdrop-blur-md rounded-lg text-[10px] font-bold text-white uppercase tracking-wider">
            {{ $categoria }}
        </div>
        @endif
    </div>


    <!-- Content -->
    <div class="p-5 flex-1 flex flex-col">
        <div class="flex-1">
            <h3 class="text-base font-bold text-slate-800 mb-2 group-hover:text-emerald-600 transition-colors line-clamp-1">
                {{ $nombre }}
            </h3>
            
            @if(!$isObject && isset($r['extraHtml']))
                <div class="mb-4">
                    {!! $r['extraHtml'] !!}
                </div>
            @endif

            @if($isObject && $r->descripcion)
                <p class="text-slate-500 text-xs line-clamp-2 mb-4">{{ $r->descripcion }}</p>
            @endif
        </div>

        <!-- Footer Actions -->
        <div class="flex items-center justify-between pt-4 border-t border-slate-50 mt-auto">
            <div class="flex items-center gap-2">
                @if(!$isObject || ($isObject && $r->id_receta_api))
                <button onclick="toggleFavorito('{{ $id }}', this)"
                    class="favorito-btn h-10 px-4 flex items-center justify-center rounded-xl font-bold text-xs transition-all shadow-sm {{ ($esFavorita) ? 'bg-red-50 text-red-600' : 'bg-emerald-50 text-emerald-600 hover:bg-emerald-100' }}">
                    {{ ($esFavorita) ? 'Quitar' : 'Añadir' }}
                </button>
                @else
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Receta Local</span>
                @endif
            </div>
            
            <a href="/receta/{{ $id }}" class="w-10 h-10 flex items-center justify-center bg-slate-50 rounded-xl text-slate-400 hover:bg-emerald-500 hover:text-white transition-all shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>
        </div>
    </div>
</div>


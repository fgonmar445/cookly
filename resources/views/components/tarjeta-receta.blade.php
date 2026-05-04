@php
    $r = $r ?? [];
@endphp

<div class="group bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-emerald-100/50 transition-all duration-300 overflow-hidden flex flex-col h-full">
    <!-- Image Wrapper -->
    <div class="relative h-48 overflow-hidden">
        <img src="{{ $r['strMealThumb'] ?? 'STR_MEAL_THUMB' }}" 
             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-5">
            <a href="/receta/{{ $r['idMeal'] ?? 'ID_MEAL' }}" class="text-white font-bold text-xs uppercase tracking-widest underline underline-offset-4">
                Ver Receta
            </a>
        </div>
    </div>

    <!-- Content -->
    <div class="p-5 flex-1 flex flex-col">
        <div class="flex-1">
            <h3 class="text-base font-bold text-slate-800 mb-2 group-hover:text-emerald-600 transition-colors line-clamp-1">
                {{ $r['strMeal'] ?? 'Nombre de Receta' }}
            </h3>
            
            @if(isset($r['extraHtml']))
                <div class="mb-4">
                    {!! $r['extraHtml'] !!}
                </div>
            @endif
        </div>

        <!-- Footer Actions -->
        <div class="flex items-center justify-between pt-4 border-t border-slate-50 mt-auto">
            <div class="flex items-center gap-2">
                <button onclick="toggleFavorito('{{ $r['idMeal'] ?? 'ID_MEAL' }}', this)"
                    class="favorito-btn h-10 px-4 flex items-center justify-center rounded-xl font-bold text-xs transition-all shadow-sm {{ ($r['esFavorita'] ?? false) ? 'bg-red-50 text-red-600' : 'bg-emerald-50 text-emerald-600 hover:bg-emerald-100' }}">
                    {{ ($r['esFavorita'] ?? false) ? 'Quitar' : 'Añadir' }}
                </button>
            </div>
            
            <a href="/receta/{{ $r['idMeal'] ?? 'ID_MEAL' }}" class="w-10 h-10 flex items-center justify-center bg-slate-50 rounded-xl text-slate-400 hover:bg-emerald-500 hover:text-white transition-all shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>
        </div>
    </div>
</div>
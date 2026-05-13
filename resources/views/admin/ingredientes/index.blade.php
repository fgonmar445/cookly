@extends('layouts.app')

@section('header_title', 'Gestionar Ingredientes')

@section('content')
<div class="space-y-6 animate-fade-in">

    <!-- Header Bar -->
    <div class="flex flex-col md:flex-row gap-4 justify-between items-center bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Directorio de Ingredientes</h2>
            <p class="text-slate-500 text-sm mt-1">Administra la base de alimentos del sistema.</p>
        </div>
        <a href="{{ route('admin.ingredientes.create') }}" class="w-full md:w-auto px-6 py-3 bg-emerald-600 text-white font-bold rounded-2xl shadow-lg shadow-emerald-200 hover:bg-emerald-700 hover:shadow-xl hover:-translate-y-0.5 transition-all text-center">
            + Nuevo Ingrediente
        </a>
    </div>

    @if(session('success'))
    <div class="p-4 bg-emerald-50 border border-emerald-100 text-emerald-600 rounded-2xl font-medium shadow-sm">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Categoría</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($ingredientes as $ing)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 font-medium text-slate-500 text-sm">#{{ $ing->id_ingrediente }}</td>
                        <td class="px-6 py-4 font-bold text-slate-800">{{ $ing->nombre }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide bg-emerald-100 text-emerald-700">
                                {{ $ing->categoria ?? 'Sin categorizar' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                @if($ing->es_base)
                                <a href="{{ route('admin.ingredientes.edit', $ing->id_ingrediente) }}" class="p-2 text-emerald-600 hover:bg-emerald-50 rounded-xl transition-colors" title="Editar Ingrediente">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                @endif
                                <form action="{{ route('admin.ingredientes.destroy', $ing->id_ingrediente) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este ingrediente?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-orange-600 hover:bg-orange-50 rounded-xl transition-colors" title="Eliminar Ingrediente">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500 font-medium">No hay ingredientes registrados.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($ingredientes->hasPages())
        <div class="p-6 border-t border-slate-50">
            {{ $ingredientes->links() }}
        </div>
        @endif
    </div>

</div>
@endsection

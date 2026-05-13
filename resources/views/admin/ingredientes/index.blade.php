@extends('layouts.app')

@section('header_title', 'Gestionar Ingredientes')

@section('content')
<div class="space-y-6 animate-fade-in">

    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-slate-800">Directorio de Ingredientes</h2>
        <a href="{{ route('admin.ingredientes.create') }}" class="px-4 py-2 bg-emerald-600 text-white font-semibold rounded-xl shadow-sm hover:bg-emerald-700 transition-colors">
            + Nuevo Ingrediente
        </a>
    </div>

    @if(session('success'))
    <div class="p-4 bg-emerald-50 border border-emerald-100 text-emerald-600 rounded-xl font-medium">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">Nombre</th>
                        <th class="px-6 py-4">Categoría</th>
                        <th class="px-6 py-4">Base</th>
                        <th class="px-6 py-4 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($ingredientes as $ing)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 font-medium text-slate-900">#{{ $ing->id_ingrediente }}</td>
                        <td class="px-6 py-4 font-semibold text-slate-800">{{ $ing->nombre }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800">
                                {{ $ing->categoria ?? 'Sin categorizar' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($ing->es_base)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">Sí</span>
                            @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">No</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('admin.ingredientes.edit', $ing->id_ingrediente) }}" class="text-blue-600 hover:text-blue-800 font-medium">Editar</a>
                            <form action="{{ route('admin.ingredientes.destroy', $ing->id_ingrediente) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Seguro que deseas eliminar este ingrediente?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-600 hover:text-rose-800 font-medium">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-500">No hay ingredientes registrados.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($ingredientes->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $ingredientes->links() }}
        </div>
        @endif
    </div>

</div>
@endsection

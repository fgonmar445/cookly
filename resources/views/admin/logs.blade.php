@extends('layouts.app')

@section('header_title', 'Logs de Actividad Admin')

@section('content')
<div class="space-y-6 animate-fade-in">

    <!-- Logs List -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-50">
            <h3 class="font-bold text-slate-800">Historial de acciones</h3>
            <p class="text-xs text-slate-500 mt-1">Registro de todas las eliminaciones y acciones críticas realizadas por administradores.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Acción</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Descripción</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Administrador</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Fecha</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($logs as $log)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-lg text-[10px] font-bold uppercase 
                                {{ $log->accion === 'delete_user' ? 'bg-orange-50 text-orange-600' : 'bg-amber-50 text-amber-600' }}">
                                {{ str_replace('_', ' ', $log->accion) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-slate-700 font-medium">{{ $log->descripcion }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-slate-100 flex items-center justify-center text-[10px] font-bold">
                                    {{ strtoupper(substr($log->admin->name ?? 'A', 0, 1)) }}
                                </div>
                                <span class="text-xs text-slate-600">{{ $log->admin->name ?? 'Sistema' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-xs text-slate-500">{{ $log->fecha_creacion->format('d/m/Y H:i') }}</p>
                            <p class="text-[10px] text-slate-400">{{ $log->fecha_creacion->diffForHumans() }}</p>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                            No hay actividad registrada aún.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
        <div class="p-6 border-t border-slate-50">
            {{ $logs->links() }}
        </div>
        @endif
    </div>

</div>
@endsection

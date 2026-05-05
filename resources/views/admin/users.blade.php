@extends('layouts.app')

@section('header_title', 'Gestión de Usuarios')

@section('content')
<div class="space-y-6 animate-fade-in">

    <!-- Search & Filter Bar -->
    <div class="flex flex-col md:flex-row gap-4 justify-between items-center bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <form action="{{ route('admin.users') }}" method="GET" class="relative w-full md:w-96">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nombre o email..." 
                class="w-full pl-12 pr-4 py-3 bg-slate-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500 transition-all">
            <svg class="w-5 h-5 absolute left-4 top-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </form>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Usuario</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Info Básica</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Actividad</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Registro</th>
                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($users as $user)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold text-sm">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-800">{{ $user->name }}</p>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $user->rol === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-slate-100 text-slate-600' }}">
                                        {{ $user->rol }}
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-slate-600">{{ $user->email }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col gap-1">
                                <span class="text-xs font-medium text-slate-500">
                                    <strong class="text-slate-800">{{ $user->recetas_count }}</strong> recetas creadas
                                </span>
                                <span class="text-xs font-medium text-slate-500">
                                    <strong class="text-slate-800">{{ $user->favoritos_count }}</strong> favoritos
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-xs text-slate-500">{{ $user->created_at->format('d M, Y') }}</p>
                            <p class="text-[10px] text-slate-400">{{ $user->created_at->diffForHumans() }}</p>
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.delete', $user) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar a este usuario? Esta acción no se puede deshacer.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-rose-500 hover:bg-rose-50 rounded-xl transition-colors" title="Eliminar Usuario">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                            @else
                            <span class="text-xs text-slate-400 italic">Eres tú</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div class="p-6 border-t border-slate-50">
            {{ $users->links() }}
        </div>
        @endif
    </div>

</div>
@endsection

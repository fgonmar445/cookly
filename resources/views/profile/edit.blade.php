@extends('layouts.app')

@section('content')

<div class="mb-12">
    <h1 class="text-3xl font-black text-slate-800 mb-2 tracking-tight">Gestión del perfil</h1>
    <p class="text-slate-500">Actualiza tu información personal y configura la seguridad de tu cuenta.</p>
</div>

<div class="space-y-8">

    {{-- INFORMACIÓN DEL USUARIO --}}
    <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
        <div class="flex items-center gap-3 mb-8">
            <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800">Información del usuario</h3>
        </div>

        <div class="max-w-2xl">
            <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- NOMBRE --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nombre completo</label>
                        <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
                            class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-slate-700 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none">
                    </div>

                    {{-- EMAIL --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Correo electrónico</label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                            class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-slate-700 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none">
                    </div>
                </div>

                <button class="px-8 py-3 bg-emerald-600 text-white font-bold rounded-2xl hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 transition-all active:scale-95">
                    Guardar cambios
                </button>
            </form>
        </div>
    </div>

    {{-- CAMBIAR CONTRASEÑA --}}
    <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
        <div class="flex items-center gap-3 mb-8">
            <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002-2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800">Seguridad</h3>
        </div>

        <div class="max-w-2xl">
            <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Contraseña actual</label>
                    <input type="password" name="current_password"
                        class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-slate-700 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nueva contraseña</label>
                        <input type="password" name="password"
                            class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-slate-700 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Confirmar nueva contraseña</label>
                        <input type="password" name="password_confirmation"
                            class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-slate-700 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none">
                    </div>
                </div>

                <button class="px-8 py-3 bg-emerald-600 text-white font-bold rounded-2xl hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 transition-all active:scale-95">
                    Actualizar contraseña
                </button>
            </form>
        </div>
    </div>

    {{-- ELIMINAR CUENTA --}}
    <div class="bg-red-50/50 p-8 rounded-3xl border border-red-100">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center text-red-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-red-800">Zona de peligro</h3>
        </div>

        <div class="max-w-2xl">
            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('DELETE')

                <p class="text-red-700/70 text-sm mb-6 leading-relaxed">
                    Una vez que elimines tu cuenta, todos tus recursos y datos se borrarán de forma permanente. Por favor, descarga cualquier dato o información que desees conservar antes de proceder.
                </p>

                <button class="px-8 py-3 bg-red-600 text-white font-bold rounded-2xl hover:bg-red-700 shadow-lg shadow-red-600/20 transition-all active:scale-95">
                    Eliminar cuenta permanentemente
                </button>
            </form>
        </div>
    </div>

</div>

@endsection
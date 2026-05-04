@extends('layouts.app')

@section('content')

<h2 class="text-2xl font-bold mb-6 text-gray-800">Gestión del perfil</h2>

<div class="space-y-10">

    {{-- INFORMACIÓN DEL USUARIO --}}
    <div class="bg-white p-6 rounded-xl shadow">
        <h3 class="text-xl font-semibold mb-4 text-gray-800">Información del usuario</h3>

        <div class="max-w-xl space-y-6">

            {{-- FORMULARIO DE ACTUALIZAR INFORMACIÓN --}}
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PATCH')

                {{-- NOMBRE --}}
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-1">Nombre</label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', auth()->user()->name) }}"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 text-gray-700 
                               focus:border-emerald-500 focus:ring-emerald-500 shadow-sm transition">
                </div>

                {{-- EMAIL --}}
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-1">Email</label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', auth()->user()->email) }}"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 text-gray-700 
                               focus:border-emerald-500 focus:ring-emerald-500 shadow-sm transition">
                </div>

                <button
                    class="bg-emerald-600 text-white px-5 py-2 rounded-lg font-semibold 
                           hover:bg-emerald-700 transition shadow">
                    Guardar cambios
                </button>
            </form>

        </div>
    </div>

    {{-- CAMBIAR CONTRASEÑA --}}
    <div class="bg-white p-6 rounded-xl shadow">
        <h3 class="text-xl font-semibold mb-4 text-gray-800">Cambiar contraseña</h3>

        <div class="max-w-xl space-y-6">

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                {{-- CONTRASEÑA ACTUAL --}}
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-1">Contraseña actual</label>
                    <input
                        type="password"
                        name="current_password"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 text-gray-700 
                               focus:border-emerald-500 focus:ring-emerald-500 shadow-sm transition">
                </div>

                {{-- NUEVA CONTRASEÑA --}}
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-1">Nueva contraseña</label>
                    <input
                        type="password"
                        name="password"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 text-gray-700 
                               focus:border-emerald-500 focus:ring-emerald-500 shadow-sm transition">
                </div>

                {{-- CONFIRMAR --}}
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-1">Confirmar contraseña</label>
                    <input
                        type="password"
                        name="password_confirmation"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 text-gray-700 
                               focus:border-emerald-500 focus:ring-emerald-500 shadow-sm transition">
                </div>

                <button
                    class="bg-emerald-600 text-white px-5 py-2 rounded-lg font-semibold 
                           hover:bg-emerald-700 transition shadow">
                    Actualizar contraseña
                </button>
            </form>

        </div>
    </div>

    {{-- ELIMINAR CUENTA --}}
    <div class="bg-white p-6 rounded-xl shadow">
        <h3 class="text-xl font-semibold mb-4 text-red-600">Eliminar cuenta</h3>

        <div class="max-w-xl space-y-6">

            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('DELETE')

                <p class="text-gray-600 mb-4">
                    Esta acción no se puede deshacer. Tu cuenta y todos tus datos serán eliminados permanentemente.
                </p>

                <button
                    class="bg-red-600 text-white px-5 py-2 rounded-lg font-semibold 
                           hover:bg-red-700 transition shadow">
                    Eliminar cuenta
                </button>
            </form>

        </div>
    </div>

</div>

@endsection
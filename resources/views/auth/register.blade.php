<x-guest-layout>

    <!-- TÍTULO -->
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-slate-800 tracking-tight">
            Únete a Cookly
        </h2>
        <p class="text-slate-500 mt-2 font-medium">
            Empieza a cocinar de forma inteligente hoy
        </p>
    </div>

    <!-- FORMULARIO -->
    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- NOMBRE -->
        <div class="space-y-2">
            <label for="name" class="block text-sm font-semibold text-slate-700 ml-1">
                Tu nombre
            </label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    placeholder="Ej. Juan Pérez"
                    class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none text-slate-700 font-medium placeholder:text-slate-300">
            </div>
            @error('name')
                <p class="text-xs text-rose-500 font-bold ml-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- EMAIL -->
        <div class="space-y-2">
            <label for="email" class="block text-sm font-semibold text-slate-700 ml-1">
                Correo electrónico
            </label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" />
                    </svg>
                </div>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    placeholder="nombre@email.com"
                    class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none text-slate-700 font-medium placeholder:text-slate-300">
            </div>
            @error('email')
                <p class="text-xs text-rose-500 font-bold ml-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- PASSWORD -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="space-y-2">
                <label for="password" class="block text-sm font-semibold text-slate-700 ml-1">
                    Contraseña
                </label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    placeholder="••••••••"
                    class="w-full px-4 py-3.5 bg-slate-50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none text-slate-700 font-medium placeholder:text-slate-300">
            </div>
            <div class="space-y-2">
                <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 ml-1">
                    Confirmar
                </label>
                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    required
                    placeholder="••••••••"
                    class="w-full px-4 py-3.5 bg-slate-50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none text-slate-700 font-medium placeholder:text-slate-300">
            </div>
        </div>
        @error('password')
            <p class="text-xs text-rose-500 font-bold ml-1">{{ $message }}</p>
        @enderror

        <!-- ACCIONES -->
        <div class="flex flex-col gap-4 pt-4">
            <button
                type="submit"
                class="w-full bg-emerald-600 text-white font-bold py-4 rounded-2xl shadow-lg shadow-emerald-200 hover:bg-emerald-700 hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200">
                Crear mi cuenta
            </button>

            <p class="text-center text-sm font-medium text-slate-500">
                ¿Ya tienes una cuenta? 
                <a href="{{ route('login') }}" class="text-emerald-600 font-bold hover:text-emerald-700 transition-colors">
                    Inicia sesión aquí
                </a>
            </p>
        </div>

    </form>

</x-guest-layout>
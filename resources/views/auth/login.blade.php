<x-guest-layout>

    <!-- TÍTULO -->
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-slate-800 tracking-tight">
            Bienvenido de nuevo
        </h2>
        <p class="text-slate-500 mt-2 font-medium">
            Entra para gestionar tu cocina inteligente
        </p>
    </div>

    <!-- ERRORES DE VALIDACIÓN -->
    @if ($errors->any())
    <div class="mb-6 p-4 bg-orange-50 border border-orange-100 rounded-2xl text-orange-600 text-sm font-medium animate-fade-in">
        @foreach ($errors->all() as $error)
        <p>{{ $error }}</p>
        @endforeach
    </div>
    @endif

    <!-- FORMULARIO -->
    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

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
                    autofocus
                    placeholder="nombre@email.com"
                    class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none text-slate-700 font-medium placeholder:text-slate-300">
            </div>
        </div>

        <!-- PASSWORD -->
        <div class="space-y-2">
            <div class="flex items-center justify-between ml-1">
                <label for="password" class="block text-sm font-semibold text-slate-700">
                    Contraseña
                </label>
                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 transition-colors">
                    ¿Olvidaste tu contraseña?
                </a>
                @endif
            </div>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    placeholder="••••••••"
                    class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none text-slate-700 font-medium placeholder:text-slate-300">
            </div>
        </div>

        <!-- RECORDAR -->
        <div class="flex items-center ml-1">
            <input
                id="remember_me"
                type="checkbox"
                name="remember"
                class="w-5 h-5 rounded-lg border-2 border-slate-200 text-emerald-600 focus:ring-emerald-500 transition-all cursor-pointer">
            <label for="remember_me" class="ml-3 text-sm font-medium text-slate-600 cursor-pointer select-none">
                Mantener sesión iniciada
            </label>
        </div>

        <!-- ACCIONES -->
        <div class="flex flex-col gap-4 pt-2">
            <button
                type="submit"
                class="w-full bg-emerald-600 text-white font-bold py-4 rounded-2xl shadow-lg shadow-emerald-200 hover:bg-emerald-700 hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200">
                Iniciar Sesión
            </button>

            <div class="relative flex items-center py-2">
                <div class="flex-grow border-t border-slate-100"></div>
                <span class="flex-shrink mx-4 text-xs font-bold text-slate-300 uppercase tracking-widest">O también</span>
                <div class="flex-grow border-t border-slate-100"></div>
            </div>

            <a
                href="{{ route('register') }}"
                class="w-full border-2 border-emerald-500 text-emerald-600 font-bold py-4 rounded-2xl text-center hover:bg-emerald-50 transition-all duration-200">
                Crear una cuenta nueva
            </a>
        </div>

    </form>

</x-guest-layout>
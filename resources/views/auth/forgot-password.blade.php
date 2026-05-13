<x-guest-layout>

    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-slate-800 tracking-tight">
            Recuperar contraseña
        </h2>
        <p class="text-slate-500 mt-2 font-medium text-sm">
            Te enviaremos un enlace para que elijas una nueva.
        </p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl text-emerald-600 text-sm font-medium animate-fade-in">
            {{ session('status') }}
        </div>
    @endif

    <!-- ERRORES DE VALIDACIÓN -->
    @if ($errors->any())
    <div class="mb-6 p-4 bg-orange-50 border border-orange-100 rounded-2xl text-orange-600 text-sm font-medium animate-fade-in">
        @foreach ($errors->all() as $error)
        <p>{{ $error }}</p>
        @endforeach
    </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
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

        <div class="flex flex-col gap-4 pt-2">
            <button
                type="submit"
                class="w-full bg-emerald-600 text-white font-bold py-4 rounded-2xl shadow-lg shadow-emerald-200 hover:bg-emerald-700 hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200">
                Enviar enlace de recuperación
            </button>

            <div class="relative flex items-center py-2">
                <div class="flex-grow border-t border-slate-100"></div>
                <span class="flex-shrink mx-4 text-xs font-bold text-slate-300 uppercase tracking-widest">O</span>
                <div class="flex-grow border-t border-slate-100"></div>
            </div>

            <a
                href="{{ route('login') }}"
                class="w-full border-2 border-emerald-500 text-emerald-600 font-bold py-4 rounded-2xl text-center hover:bg-emerald-50 transition-all duration-200">
                Volver al inicio de sesión
            </a>
        </div>
    </form>
</x-guest-layout>

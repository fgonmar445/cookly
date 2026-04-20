<x-guest-layout>

    <!-- TÍTULO -->
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-emerald-600">
            Iniciar sesión
        </h2>
        <p class="text-sm text-gray-500">
            Accede a tu cuenta de Cookly
        </p>
    </div>

    <!-- FORMULARIO -->
    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- EMAIL -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">
                Email
            </label>

            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                class="mt-1 w-full border border-gray-300 rounded-md p-2
                       focus:border-emerald-500 focus:ring-emerald-500">
        </div>

        <!-- PASSWORD -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">
                Contraseña
            </label>

            <input
                id="password"
                type="password"
                name="password"
                required
                class="mt-1 w-full border border-gray-300 rounded-md p-2
                       focus:border-emerald-500 focus:ring-emerald-500">
        </div>

        <!-- RECORDAR -->
        <div class="flex items-center">
            <input
                id="remember_me"
                type="checkbox"
                name="remember"
                class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
            <label for="remember_me" class="ml-2 text-sm text-gray-600">
                Recuérdame
            </label>
        </div>

        <!-- BOTONES EN DOS COLUMNAS -->
        <div class="grid grid-cols-2 gap-3 pt-2">

            <!-- LOGIN -->
            <button
                type="submit"
                class="bg-emerald-600 text-white font-semibold py-2 rounded-md
                       hover:bg-emerald-700 transition">
                Entrar
            </button>

            <!-- REGISTRO -->
            <a
                href="{{ route('register') }}"
                class="border border-emerald-600 text-emerald-600 font-semibold py-2 rounded-md
                       text-center hover:bg-emerald-50 transition">
                Regístrate
            </a>

        </div>

    </form>

</x-guest-layout>
<x-guest-layout>

    <!-- TÍTULO -->
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-emerald-600">
            Crear cuenta
        </h2>
        <p class="text-sm text-gray-500">
            Regístrate para empezar a usar Cookly
        </p>
    </div>

    <!-- FORMULARIO -->
    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- NOMBRE -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">
                Nombre
            </label>

            <input
                id="name"
                type="text"
                name="name"
                value="{{ old('name') }}"
                required
                autofocus
                class="mt-1 w-full border border-gray-300 rounded-md p-2
                       focus:border-emerald-500 focus:ring-emerald-500">

            @error('name')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

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
                class="mt-1 w-full border border-gray-300 rounded-md p-2
                       focus:border-emerald-500 focus:ring-emerald-500">

            @error('email')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
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

            @error('password')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- CONFIRM PASSWORD -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                Confirmar contraseña
            </label>

            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                required
                class="mt-1 w-full border border-gray-300 rounded-md p-2
                       focus:border-emerald-500 focus:ring-emerald-500">
        </div>

        <!-- BOTONES EN DOS COLUMNAS -->
        <div class="grid grid-cols-2 gap-3 pt-2">

            <!-- REGISTRARSE -->
            <button
                type="submit"
                class="bg-emerald-600 text-white font-semibold py-2 rounded-md
                       hover:bg-emerald-700 transition">
                Crear cuenta
            </button>

            <!-- VOLVER A LOGIN -->
            <a
                href="{{ route('login') }}"
                class="border border-emerald-600 text-emerald-600 font-semibold py-2 rounded-md
                       text-center hover:bg-emerald-50 transition">
                Iniciar sesión
            </a>

        </div>

    </form>

</x-guest-layout>
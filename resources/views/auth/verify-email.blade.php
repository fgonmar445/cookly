<x-guest-layout>
    <!-- TÍTULO -->
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-slate-800 tracking-tight">
            Verifica tu correo
        </h2>
        <p class="text-slate-500 mt-2 font-medium text-sm">
            ¡Gracias por registrarte! Antes de comenzar, por favor verifica tu dirección de correo electrónico haciendo clic en el enlace que te acabamos de enviar. Si no recibiste el correo, con gusto te enviaremos otro.
        </p>
    </div>

    <!-- ESTADO -->
    @if (session('status') == 'verification-link-sent')
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl text-emerald-600 text-sm font-medium animate-fade-in text-center">
        Se ha enviado un nuevo enlace de verificación a la dirección de correo electrónico que proporcionaste durante el registro.
    </div>
    @endif

    <!-- ACCIONES -->
    <div class="flex flex-col gap-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button
                type="submit"
                class="w-full bg-emerald-600 text-white font-bold py-4 rounded-2xl shadow-lg shadow-emerald-200 hover:bg-emerald-700 hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200">
                Reenviar correo de verificación
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button
                type="submit"
                class="w-full border-2 border-emerald-500 text-emerald-600 font-bold py-4 rounded-2xl text-center hover:bg-emerald-50 transition-all duration-200">
                Cerrar sesión
            </button>
        </form>
    </div>
</x-guest-layout>
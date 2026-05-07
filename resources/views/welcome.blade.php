<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cookly | Tu Asistente de Cocina Inteligente</title>
    
    <!-- Google Fonts: Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        emerald: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            200: '#a7f3d0',
                            300: '#6ee7b7',
                            400: '#34d399',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065f46',
                            900: '#064e3b',
                            950: '#022c22',
                        },
                    },
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            -webkit-font-smoothing: antialiased;
        }
    </style>
</head>

<body class="bg-white text-slate-900 overflow-x-hidden">

    <div class="min-h-screen flex flex-col relative">
        <!-- Background Elements -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10">
            <div class="absolute top-[-10%] right-[-10%] w-[80%] md:w-[50%] h-[50%] bg-emerald-50 rounded-full blur-3xl opacity-60"></div>
            <div class="absolute bottom-[-10%] left-[-10%] w-[70%] md:w-[40%] h-[40%] bg-slate-50 rounded-full blur-3xl opacity-60"></div>
        </div>

        <!-- NAV -->
        <header class="flex justify-between items-center px-6 md:px-8 py-6 max-w-7xl mx-auto w-full">
            <div class="flex items-center gap-2">
                <x-application-logo class="w-10 h-10 bg-white rounded-xl shadow-lg shadow-emerald-100 p-1.5 border border-emerald-50" />
                <h1 class="text-2xl font-black text-slate-800 tracking-tight">Cookly</h1>
            </div>

            <div class="flex items-center gap-2 md:gap-4">
                @auth
                <a href="{{ Auth::user()->rol === 'admin' ? route('admin.dashboard') : route('dashboard') }}" class="hidden sm:block text-slate-600 font-bold hover:text-emerald-600 transition-colors text-sm">
                    Panel
                </a>
                <a href="{{ route('profile.edit') }}" class="bg-emerald-600 text-white px-4 md:px-6 py-2 md:py-3 font-bold rounded-2xl hover:bg-emerald-700 transition-all shadow-xl shadow-emerald-600/20 active:scale-95 text-xs md:text-sm">
                    Mi Perfil
                </a>
                @else
                <a href="{{ route('login') }}" class="text-slate-600 font-bold hover:text-emerald-600 transition-colors text-xs md:text-sm">
                    Entrar
                </a>
                <a href="{{ route('register') }}" class="bg-emerald-600 text-white px-4 md:px-6 py-2 md:py-3 font-bold rounded-2xl hover:bg-emerald-700 transition-all shadow-xl shadow-emerald-600/20 active:scale-95 text-xs md:text-sm">
                    Registro
                </a>
                @endauth
            </div>
        </header>

        <!-- HERO -->
        <main class="flex-1 flex flex-col items-center justify-center px-6 text-center py-12 md:py-20">
            <span class="px-4 py-2 bg-orange-50 text-orange-700 rounded-full text-[10px] md:text-xs font-black uppercase tracking-widest mb-6 animate-bounce ring-1 ring-orange-100 shadow-sm shadow-orange-100">
                Nueva versión 2.0 disponible
            </span>

            <h2 class="text-4xl md:text-7xl font-black leading-tight md:leading-[1.1] text-slate-900 tracking-tight max-w-4xl">
                Domina tu cocina con lo que <span class="text-emerald-600">ya tienes.</span>
            </h2>

            <p class="mt-6 md:mt-8 text-slate-500 text-base md:text-xl max-w-2xl leading-relaxed px-4">
                Cookly es el asistente inteligente que transforma tus ingredientes en platos espectaculares. Gestiona tu despensa, descubre recetas y ahorra tiempo cada día.
            </p>

            <div class="mt-10 md:mt-12 flex flex-col sm:flex-row justify-center gap-4 md:gap-6 w-full max-w-md mx-auto">
                <a href="{{ Auth::check() ? (Auth::user()->rol === 'admin' ? route('admin.dashboard') : route('dashboard')) : route('register') }}"
                    class="px-8 md:px-10 py-4 md:py-5 bg-emerald-600 text-white font-black rounded-2xl hover:bg-emerald-700 transition-all shadow-2xl shadow-emerald-600/30 active:scale-95 text-base md:text-lg">
                    {{ Auth::check() ? 'Ir a mi cocina' : 'Empezar ahora' }}
                </a>

                <a href="#features"
                    class="px-8 md:px-10 py-4 md:py-5 bg-white border border-slate-200 text-slate-700 font-bold rounded-2xl hover:bg-slate-50 hover:border-slate-300 transition-all active:scale-95 text-base md:text-lg shadow-sm">
                    Saber más
                </a>
            </div>

            <!-- Dashboard Preview Placeholder -->
            <div class="mt-16 md:mt-20 w-full max-w-5xl rounded-[2rem] md:rounded-[3rem] overflow-hidden shadow-2xl border border-white p-2 bg-white/50 backdrop-blur-sm">
                <div class="w-full aspect-[16/9] bg-slate-100 rounded-[1.8rem] md:rounded-[2.5rem] flex items-center justify-center border border-slate-200">
                    <div class="flex flex-col items-center p-6">
                        <svg class="w-12 h-12 md:w-20 md:h-20 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002-2z" />
                        </svg>
                        <p class="text-slate-400 font-medium text-sm md:text-base">Vista previa del panel de control</p>
                    </div>
                </div>
            </div>
        </main>

        <!-- FEATURES -->
        <section id="features" class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-12 px-6 md:px-8 py-16 md:py-24 max-w-6xl mx-auto w-full border-t border-slate-50">
            <div class="flex flex-col items-center text-center group">
                <div class="w-14 h-14 md:w-16 md:h-16 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 mb-4 md:mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <h3 class="font-black text-lg md:text-xl text-slate-800 mb-2 md:mb-3 tracking-tight">Despensa Inteligente</h3>
                <p class="text-slate-500 text-sm md:text-base leading-relaxed">Mantén un inventario detallado de lo que tienes en casa y deja de comprar por duplicado.</p>
            </div>

            <div class="flex flex-col items-center text-center group">
                <div class="w-14 h-14 md:w-16 md:h-16 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 mb-4 md:mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <h3 class="font-black text-lg md:text-xl text-slate-800 mb-2 md:mb-3 tracking-tight">Búsqueda Avanzada</h3>
                <p class="text-slate-500 text-sm md:text-base leading-relaxed">Explora miles de recetas internacionales filtrando por ingredientes, categorías o regiones.</p>
            </div>

            <div class="flex flex-col items-center text-center group">
                <div class="w-14 h-14 md:w-16 md:h-16 bg-orange-50 rounded-2xl flex items-center justify-center text-orange-600 mb-4 md:mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </div>
                <h3 class="font-black text-lg md:text-xl text-slate-800 mb-2 md:mb-3 tracking-tight">Libro de Favoritos</h3>
                <p class="text-slate-500 text-sm md:text-base leading-relaxed">Crea tu colección personal de platos favoritos para tenerlos siempre a mano.</p>
            </div>
        </section>

        <!-- FOOTER -->
        <footer class="py-12 border-t border-slate-50 text-center px-6">
            <p class="text-slate-400 text-xs md:text-sm font-medium">
                © {{ date('Y') }} <span class="text-emerald-600 font-bold">Cookly</span> • Proyecto DAW • Diseñado para amantes de la cocina
            </p>
        </footer>
    </div>
</body>

</html>
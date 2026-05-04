<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cookly | Tu Asistente de Cocina Inteligente</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>

<body class="bg-white text-slate-900 overflow-x-hidden">

    <div class="min-h-screen flex flex-col relative">
        <!-- Background Elements -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10">
            <div class="absolute top-[-10%] right-[-10%] w-[50%] h-[50%] bg-emerald-50 rounded-full blur-3xl opacity-60"></div>
            <div class="absolute bottom-[-10%] left-[-10%] w-[40%] h-[40%] bg-slate-50 rounded-full blur-3xl opacity-60"></div>
        </div>

        <!-- NAV -->
        <header class="flex justify-between items-center px-8 py-6 max-w-7xl mx-auto w-full">
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 bg-emerald-600 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-600/20">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <h1 class="text-2xl font-black text-slate-800 tracking-tight">Cookly</h1>
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ route('login') }}" class="text-slate-600 font-bold hover:text-emerald-600 transition-colors text-sm">
                    Iniciar sesión
                </a>
                <a href="{{ route('register') }}" class="bg-slate-900 text-white px-6 py-3 font-bold rounded-2xl hover:bg-slate-800 transition-all shadow-xl shadow-slate-900/10 active:scale-95 text-sm">
                    Unirse gratis
                </a>
            </div>
        </header>

        <!-- HERO -->
        <main class="flex-1 flex flex-col items-center justify-center px-6 text-center py-20">
            <span class="px-4 py-2 bg-emerald-50 text-emerald-700 rounded-full text-xs font-black uppercase tracking-widest mb-6 animate-bounce">
                🚀 Nueva versión 2.0 disponible
            </span>
            
            <h2 class="text-5xl md:text-7xl font-black leading-[1.1] text-slate-900 tracking-tight max-w-4xl">
                Domina tu cocina con lo que <span class="text-emerald-600">ya tienes.</span>
            </h2>

            <p class="mt-8 text-slate-500 text-lg md:text-xl max-w-2xl leading-relaxed">
                Cookly es el asistente inteligente que transforma tus ingredientes en platos espectaculares. Gestiona tu despensa, descubre recetas y ahorra tiempo cada día.
            </p>

            <div class="mt-12 flex flex-col sm:flex-row justify-center gap-6 w-full">
                <a href="{{ route('register') }}"
                    class="px-10 py-5 bg-emerald-600 text-white font-black rounded-2xl hover:bg-emerald-700 transition-all shadow-2xl shadow-emerald-600/30 active:scale-95 text-lg">
                    Empezar a cocinar
                </a>

                <a href="#features"
                    class="px-10 py-5 bg-white border border-slate-200 text-slate-700 font-bold rounded-2xl hover:bg-slate-50 hover:border-slate-300 transition-all active:scale-95 text-lg shadow-sm">
                    Saber más
                </a>
            </div>

            <!-- Dashboard Preview Placeholder or Image -->
            <div class="mt-20 w-full max-w-5xl rounded-[3rem] overflow-hidden shadow-2xl border border-white p-2 bg-white/50 backdrop-blur-sm">
                <div class="w-full aspect-[16/9] bg-slate-100 rounded-[2.5rem] flex items-center justify-center border border-slate-200">
                    <div class="flex flex-col items-center">
                        <svg class="w-20 h-20 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002-2z" />
                        </svg>
                        <p class="text-slate-400 font-medium">Dashboard Preview</p>
                    </div>
                </div>
            </div>
        </main>

        <!-- FEATURES -->
        <section id="features" class="grid md:grid-cols-3 gap-12 px-8 py-24 max-w-6xl mx-auto w-full border-t border-slate-50">
            <div class="flex flex-col items-center text-center group">
                <div class="w-16 h-16 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <h3 class="font-black text-xl text-slate-800 mb-3 tracking-tight">Despensa Inteligente</h3>
                <p class="text-slate-500 leading-relaxed">Mantén un inventario detallado de lo que tienes en casa y deja de comprar por duplicado.</p>
            </div>

            <div class="flex flex-col items-center text-center group">
                <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <h3 class="font-black text-xl text-slate-800 mb-3 tracking-tight">Búsqueda Avanzada</h3>
                <p class="text-slate-500 leading-relaxed">Explora miles de recetas internacionales filtrando por ingredientes, categorías o regiones.</p>
            </div>

            <div class="flex flex-col items-center text-center group">
                <div class="w-16 h-16 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-600 mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </div>
                <h3 class="font-black text-xl text-slate-800 mb-3 tracking-tight">Libro de Favoritos</h3>
                <p class="text-slate-500 leading-relaxed">Crea tu colección personal de platos favoritos para tenerlos siempre a mano.</p>
            </div>
        </section>

        <!-- FOOTER -->
        <footer class="py-12 border-t border-slate-50 text-center">
            <p class="text-slate-400 text-sm font-medium">
                © {{ date('Y') }} <span class="text-emerald-600 font-bold">Cookly</span> • Proyecto DAW • Diseñado para amantes de la cocina
            </p>
        </footer>
    </div>
</body>

</html>
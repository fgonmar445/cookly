<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Cookly') }} — Acceso</title>

    <!-- Google Fonts: Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
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

<body class="bg-slate-50 h-full text-slate-900">

    <div class="min-h-screen flex flex-col items-center justify-center p-6 bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-emerald-50 via-slate-50 to-emerald-50/30">

        <!-- Logo -->
        <div class="mb-10 text-center">
            <div class="inline-flex items-center gap-3">
                <x-application-logo class="w-14 h-14 bg-white rounded-2xl shadow-xl shadow-emerald-100 p-2 border border-emerald-50" />
                <span class="text-3xl font-bold tracking-tight text-slate-800">Cookly</span>
            </div>
        </div>

        <div class="w-full max-w-md">
            <!-- CARD -->
            <div class="bg-white shadow-2xl shadow-emerald-100/50 rounded-[2.5rem] p-8 md:p-10 border border-emerald-50/50 relative overflow-hidden">
                <!-- Subtle decorative element -->
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-emerald-50 rounded-full blur-3xl opacity-50"></div>
                
                <div class="relative">
                    {{ $slot }}
                </div>
            </div>

            <!-- FOOTER -->
            <p class="text-center text-sm text-slate-400 mt-8 font-medium">
                © {{ date('Y') }} Cookly — Inteligencia en tu cocina
            </p>
        </div>

    </div>

</body>

</html>
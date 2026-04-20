<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Cookly') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased bg-gradient-to-br from-gray-50 to-gray-100">

    <div class="min-h-screen flex items-center justify-center px-4">

        <div class="w-full max-w-md">



            <!-- CARD -->
            <div class="bg-white/90 backdrop-blur-sm shadow-xl rounded-2xl p-8 border border-gray-200">
                {{ $slot }}
            </div>

            <!-- FOOTER -->
            <p class="text-center text-xs text-gray-400 mt-6">
                © {{ date('Y') }} Cookly — Todos los derechos reservados
            </p>

        </div>

    </div>

</body>

</html>
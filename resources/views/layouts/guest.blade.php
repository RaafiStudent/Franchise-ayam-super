<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Ayam Super') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-red-700 via-red-600 to-red-900">
            
            <div class="mb-6 transform hover:scale-105 transition duration-300">
                <a href="/">
                    <img src="{{ asset('images/logo.png') }}" 
                         alt="Logo Ayam Super" 
                         class="w-32 h-auto drop-shadow-2xl filter brightness-110"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                    
                    <h1 class="hidden text-4xl font-black text-yellow-400 tracking-tighter drop-shadow-md border-b-4 border-yellow-400 pb-1" style="font-family: 'Figtree', sans-serif;">
                        AYAM SUPER
                    </h1>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-4 px-8 py-8 bg-white shadow-2xl overflow-hidden sm:rounded-2xl border-4 border-yellow-400 relative">
                
                <div class="absolute top-0 left-0 w-full h-2 bg-yellow-400"></div>

                {{ $slot }}
            </div>

            <div class="mt-8 text-white/80 text-sm font-semibold">
                &copy; {{ date('Y') }} Ayam Super Group
            </div>
        </div>
    </body>
</html>
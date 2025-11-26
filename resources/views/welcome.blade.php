<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Ayam Super - Super Rasanya, Super Kriuknya</title>
        
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600,700,800&display=swap" rel="stylesheet" />
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased font-sans text-gray-900 bg-white">
        
        @include('landing.navbar')

        @include('landing.hero')

        @include('landing.menu')

        @include('landing.features')

        @include('landing.contact')

        @include('landing.footer')

    </body>
</html>
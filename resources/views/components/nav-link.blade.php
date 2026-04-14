@props(['active'])

@php
$classes = ($active ?? false)
            // === JIKA MENU AKTIF (Sedang Dibuka) ===
            // Kita kasih Background Merah Gelap (bg-red-900), Teks Kuning, dan Shadow
            ? 'inline-flex items-center px-4 py-2 bg-red-900 border border-transparent rounded-md font-bold text-sm text-yellow-300 shadow-md transition duration-150 ease-in-out transform scale-105'
            
            // === JIKA MENU TIDAK AKTIF ===
            // Teks Putih polos, pas di-hover baru muncul background tipis
            : 'inline-flex items-center px-4 py-2 border border-transparent rounded-md font-medium text-sm text-white hover:text-yellow-300 hover:bg-red-800 focus:outline-none transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
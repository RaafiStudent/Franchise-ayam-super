@props(['active'])

@php
$classes = ($active ?? false)
            // === JIKA AKTIF (Versi HP) ===
            // Block penuh warna merah gelap, teks kuning, border kiri kuning tebal
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-yellow-300 text-start text-base font-bold text-yellow-300 bg-red-900 transition duration-150 ease-in-out'
            
            // === TIDAK AKTIF (Versi HP) ===
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 hover:text-red-800 hover:bg-red-50 hover:border-red-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
<nav x-data="{ mobileMenuOpen: false }" class="bg-white shadow-md sticky top-0 z-50 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
            
            {{-- 1. BAGIAN KIRI: LOGO --}}
            <div class="flex-shrink-0 flex items-center gap-2 cursor-pointer" onclick="window.scrollTo(0,0)">
                <img class="h-10 md:h-12 w-auto" src="{{ asset('images/logo.png') }}" alt="Logo Ayam Super">
                <span class="font-bold text-xl md:text-2xl text-red-600 tracking-tighter hidden sm:block">AYAM SUPER</span>
            </div>

            {{-- 2. BAGIAN TENGAH: MENU DESKTOP (Hilang di HP) --}}
            <div class="hidden md:flex space-x-8">
                <a href="#beranda" class="text-gray-700 hover:text-red-600 font-medium transition duration-300">Beranda</a>
                <a href="#menu" class="text-gray-700 hover:text-red-600 font-medium transition duration-300">Menu</a>
                <a href="#kemitraan" class="text-gray-700 hover:text-red-600 font-medium transition duration-300">Info Kemitraan</a>
                <a href="#kontak" class="text-gray-700 hover:text-red-600 font-medium transition duration-300">Kontak</a>
            </div>

            {{-- 3. BAGIAN KANAN: TOMBOL AUTH & HAMBURGER --}}
            <div class="flex items-center gap-3">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-white bg-red-600 hover:bg-red-700 px-4 py-2 md:px-5 md:py-2 rounded-full transition font-medium text-sm md:text-base shadow-sm">
                            Dashboard
                        </a>
                    @else
                        {{-- Tulisan 'Masuk' hanya tampil di Laptop --}}
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-red-600 font-medium transition hidden md:block">
                            Masuk
                        </a>
                        
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-white bg-yellow-500 hover:bg-yellow-600 px-4 py-2 md:px-5 md:py-2 rounded-full transition shadow-md font-bold text-sm md:text-base flex items-center gap-1">
                                <span>Gabung Mitra</span>
                                <svg class="w-4 h-4 hidden md:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </a>
                        @endif
                    @endauth
                @endif

                {{-- TOMBOL HAMBURGER (Hanya muncul di HP) --}}
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-red-600 hover:bg-gray-100 focus:outline-none transition">
                    {{-- Ikon Garis Tiga (Buka) --}}
                    <svg x-show="!mobileMenuOpen" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    {{-- Ikon Silang (Tutup) --}}
                    <svg x-show="mobileMenuOpen" x-cloak class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- 4. DROPDOWN MENU KHUSUS HP (Muncul saat tombol Hamburger diklik) --}}
    <div x-show="mobileMenuOpen" x-transition x-cloak class="md:hidden bg-white border-t border-gray-100 shadow-2xl absolute w-full left-0 z-40">
        <div class="px-5 pt-3 pb-6 space-y-1">
            <a href="#beranda" @click="mobileMenuOpen = false" class="block px-3 py-3.5 rounded-xl text-base font-bold text-gray-700 hover:text-red-600 hover:bg-red-50 border-b border-gray-50 transition">Beranda</a>
            <a href="#menu" @click="mobileMenuOpen = false" class="block px-3 py-3.5 rounded-xl text-base font-bold text-gray-700 hover:text-red-600 hover:bg-red-50 border-b border-gray-50 transition">Menu</a>
            <a href="#kemitraan" @click="mobileMenuOpen = false" class="block px-3 py-3.5 rounded-xl text-base font-bold text-gray-700 hover:text-red-600 hover:bg-red-50 border-b border-gray-50 transition">Info Kemitraan</a>
            <a href="#kontak" @click="mobileMenuOpen = false" class="block px-3 py-3.5 rounded-xl text-base font-bold text-gray-700 hover:text-red-600 hover:bg-red-50 mb-5 transition">Kontak</a>
            
            {{-- Tombol Login di menu HP --}}
            @if (Route::has('login') && !Auth::check())
                <div class="pt-2">
                    <a href="{{ route('login') }}" class="block w-full text-center text-white bg-red-600 hover:bg-red-700 px-4 py-3.5 rounded-xl font-bold transition shadow-md">
                        Masuk / Login
                    </a>
                </div>
            @endif
        </div>
    </div>
</nav>
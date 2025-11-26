<nav class="bg-white shadow-md sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20 items-center">
                    
                    <div class="flex-shrink-0 flex items-center gap-2 cursor-pointer" onclick="window.scrollTo(0,0)">
                        <img class="h-10 md:h-12 w-auto" src="{{ asset('images/logo.png') }}" alt="Logo Ayam Super">
                        <span class="font-bold text-xl md:text-2xl text-red-600 tracking-tighter hidden md:block">AYAM SUPER</span>
                    </div>

                    <div class="hidden md:flex space-x-8">
                        <a href="#beranda" class="text-gray-700 hover:text-red-600 font-medium transition duration-300">Beranda</a>
                        <a href="#menu" class="text-gray-700 hover:text-red-600 font-medium transition duration-300">Menu</a>
                        <a href="#kemitraan" class="text-gray-700 hover:text-red-600 font-medium transition duration-300">Info Kemitraan</a>
                        <a href="#kontak" class="text-gray-700 hover:text-red-600 font-medium transition duration-300">Kontak</a>
                    </div>

                    <div class="flex items-center gap-3">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-white bg-red-600 hover:bg-red-700 px-4 py-2 md:px-5 md:py-2 rounded-full transition font-medium text-sm md:text-base">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="text-gray-600 hover:text-red-600 font-medium transition hidden sm:block">
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
                    </div>
                </div>
            </div>
        </nav>
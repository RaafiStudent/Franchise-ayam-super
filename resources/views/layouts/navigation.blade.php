<nav x-data="{ open: false }" class="bg-red-700 border-b border-red-800 shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                {{-- 1. LOGO & NAMA BRAND (BAGIAN KIRI) --}}
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-12 w-auto" />
                    </a>
                </div>

                {{-- 2. MENU NAVIGASI (TENGAH) --}}
                <div class="hidden space-x-4 sm:-my-px sm:ms-10 sm:flex items-center">
                    
                    {{-- Dashboard (Beranda & Belanja) --}}
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        <i class="fas fa-store mr-2"></i> {{ __('Belanja Stok') }} 
                        {{-- Boss bisa ubah nama 'Dashboard' jadi 'Belanja Stok' biar lebih jelas --}}
                    </x-nav-link>

                    {{-- Riwayat Pesanan (Pesanan Saya) --}}
                    @if(Auth::user()->role === 'mitra')
                        <x-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.*')">
                            <i class="fas fa-history mr-2"></i> {{ __('Riwayat Pesanan') }}
                        </x-nav-link>
                    @endif

                    {{-- MENU KHUSUS ADMIN (Tetap Disini) --}}
                    @if(Auth::user()->role === 'admin')
                        <x-nav-link :href="route('admin.reports.index')" :active="request()->routeIs('admin.reports.index')"><i class="fas fa-chart-line mr-2"></i> {{ __('Laporan Keuangan') }}</x-nav-link>
                        <x-nav-link :href="route('admin.reports.menus')" :active="request()->routeIs('admin.reports.menus')"><i class="fas fa-utensils mr-2"></i> {{ __('Laporan Menu') }}</x-nav-link>
                        <x-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')"><i class="fas fa-box mr-2"></i> {{ __('Produk') }}</x-nav-link>
                        <x-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')"><i class="fas fa-shopping-cart mr-2"></i> {{ __('Kelola Pesanan') }}</x-nav-link>
                        <x-nav-link :href="route('admin.messages.index')" :active="request()->routeIs('admin.messages.*')"><i class="fas fa-envelope mr-2"></i> {{ __('Kotak Masuk') }}</x-nav-link>
                    @endif
                </div>
            </div>

            {{-- 3. BAGIAN UJUNG KANAN (AKSI & AKUN) --}}
            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-3">
                
                {{-- === ICON KERANJANG (HANYA UNTUK MITRA) === --}}
                @if(Auth::user()->role === 'mitra')
                    @php
                        // Hitung jumlah keranjang (Logic sederhana, bisa dioptimalkan lewat Controller)
                        $cartCount = \App\Models\Cart::where('user_id', Auth::id())->sum('quantity'); 
                    @endphp
                    
                    <a href="{{ route('checkout.show', Auth::id()) }}" class="relative p-2 text-red-100 hover:text-yellow-300 transition group">
                        <i class="fas fa-shopping-cart text-2xl"></i>
                        
                        {{-- Badge Angka Merah --}}
                        @if($cartCount > 0)
                            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/4 -translate-y-1/4 bg-red-600 rounded-full border-2 border-red-700">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>
                @endif

                {{-- DROPDOWN PROFIL --}}
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-800 hover:bg-red-900 hover:text-yellow-300 focus:outline-none transition ease-in-out duration-150 shadow-sm">
                            <div class="mr-2 text-right">
                                <div class="font-bold">{{ Auth::user()->name }}</div>
                                <div class="text-[10px] uppercase tracking-wider text-red-200">{{ Auth::user()->role }}</div>
                            </div>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="hover:bg-red-50 hover:text-red-700">
                            <i class="fas fa-user-circle mr-2"></i> {{ __('Edit Profil') }}
                        </x-dropdown-link>
                        
                        {{-- Pemisah --}}
                        <div class="border-t border-gray-100"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" class="hover:bg-red-50 hover:text-red-700"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="fas fa-sign-out-alt mr-2"></i> {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- TOMBOL HAMBURGER MOBILE --}}
            <div class="-me-2 flex items-center sm:hidden">
                {{-- Icon Keranjang Mobile (Agar tetap terlihat sebelum klik menu) --}}
                @if(Auth::user()->role === 'mitra')
                    <a href="{{ route('checkout.show', Auth::id()) }}" class="mr-4 text-white relative">
                        <i class="fas fa-shopping-cart"></i>
                        @if($cartCount > 0)
                            <span class="absolute -top-2 -right-2 bg-yellow-400 text-red-800 text-[10px] font-bold px-1.5 py-0.5 rounded-full">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>
                @endif

                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-red-100 hover:text-white hover:bg-red-600 focus:outline-none focus:bg-red-600 focus:text-white transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- MENU MOBILE (RESPONSIVE) --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-red-700 border-b border-red-800 shadow-xl">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Belanja Stok') }}
            </x-responsive-nav-link>

            @if(Auth::user()->role === 'mitra')
                <x-responsive-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.*')">
                    {{ __('Riwayat Pesanan') }}
                </x-responsive-nav-link>
            @endif

            @if(Auth::user()->role === 'admin')
                {{-- Menu Admin Mobile sama seperti sebelumnya... --}}
                <x-responsive-nav-link :href="route('admin.reports.index')" :active="request()->routeIs('admin.reports.index')">{{ __('Laporan Keuangan') }}</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.reports.menus')" :active="request()->routeIs('admin.reports.menus')">{{ __('Laporan Menu') }}</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')">{{ __('Manajemen Produk') }}</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')">{{ __('Kelola Pesanan') }}</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.messages.index')" :active="request()->routeIs('admin.messages.*')">{{ __('Kotak Masuk') }}</x-responsive-nav-link>
            @endif
        </div>

        {{-- USER INFO MOBILE --}}
        <div class="pt-4 pb-1 border-t border-red-600 bg-red-800">
            <div class="px-4 flex items-center justify-between">
                <div>
                    <div class="font-medium text-base text-yellow-300">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-red-200">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="!text-red-100 hover:!text-white hover:!bg-red-600">
                    {{ __('Edit Profil') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" class="!text-red-100 hover:!text-white hover:!bg-red-600"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
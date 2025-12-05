<nav x-data="{ open: false }" class="bg-red-700 border-b border-red-800 shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                {{-- LOGO --}}
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-12 w-auto" />
                    </a>
                </div>

                {{-- MENU DESKTOP --}}
                <div class="hidden space-x-4 sm:-my-px sm:ms-10 sm:flex items-center">
                    
                    {{-- 
                        PERHATIKAN: Saya sudah MENGHAPUS class manual (!text-white dst).
                        Sekarang tampilannya diatur otomatis oleh nav-link.blade.php
                    --}}

                    {{-- 1. Dashboard --}}
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        <i class="fas fa-home mr-2"></i> {{ __('Dashboard') }}
                    </x-nav-link>

                    {{-- 2. Riwayat Pesanan (MITRA) --}}
                    @if(Auth::user()->role === 'mitra')
                        <x-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.*')">
                            <i class="fas fa-history mr-2"></i> {{ __('Riwayat') }}
                        </x-nav-link>
                    @endif

                    {{-- 3. Menu Admin --}}
                    @if(Auth::user()->role === 'admin')
                        
                        <x-nav-link :href="route('admin.reports.index')" :active="request()->routeIs('admin.reports.index')">
                            <i class="fas fa-chart-line mr-2"></i> {{ __('Keuangan') }}
                        </x-nav-link>

                        <x-nav-link :href="route('admin.reports.menus')" :active="request()->routeIs('admin.reports.menus')">
                            <i class="fas fa-utensils mr-2"></i> {{ __('Menu') }}
                        </x-nav-link>

                        <x-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')">
                            <i class="fas fa-box mr-2"></i> {{ __('Produk') }}
                        </x-nav-link>

                        <x-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')">
                            <i class="fas fa-shopping-cart mr-2"></i> {{ __('Pesanan') }}
                        </x-nav-link>

                        <x-nav-link :href="route('admin.messages.index')" :active="request()->routeIs('admin.messages.*')">
                            <i class="fas fa-envelope mr-2"></i> {{ __('Pesan') }}
                        </x-nav-link>

                    @endif
                    
                </div>
            </div>

            {{-- DROPDOWN USER (Kanan Atas) --}}
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-800 hover:bg-red-900 hover:text-yellow-300 focus:outline-none transition ease-in-out duration-150 shadow-sm">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- TOMBOL HAMBURGER MOBILE --}}
            <div class="-me-2 flex items-center sm:hidden">
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
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-b border-gray-200 shadow-xl">
        <div class="pt-2 pb-3 space-y-1">
            
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @if(Auth::user()->role === 'mitra')
                <x-responsive-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.*')">
                    {{ __('Riwayat Pesanan') }}
                </x-responsive-nav-link>
            @endif

            @if(Auth::user()->role === 'admin')
                <x-responsive-nav-link :href="route('admin.reports.index')" :active="request()->routeIs('admin.reports.index')">
                    {{ __('Laporan Keuangan') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.reports.menus')" :active="request()->routeIs('admin.reports.menus')">
                    {{ __('Laporan Menu') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')">
                    {{ __('Manajemen Produk') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')">
                    {{ __('Kelola Pesanan') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.messages.index')" :active="request()->routeIs('admin.messages.*')">
                    {{ __('Kotak Masuk') }}
                </x-responsive-nav-link>
            @endif
        </div>

        {{-- USER INFO MOBILE --}}
        <div class="pt-4 pb-1 border-t border-gray-200 bg-gray-50">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
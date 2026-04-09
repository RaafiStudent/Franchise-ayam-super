<nav x-data="{ open: false }" class="bg-red-700 border-b border-red-800 shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-12 w-auto" />
                    </a>
                </div>

                <div class="hidden space-x-4 sm:-my-px sm:ms-10 sm:flex items-center">
                    
                    {{-- MENU MITRA --}}
                    @if(Auth::user()->role === 'mitra')
                        <x-nav-link :href="route('mitra.shop')" :active="request()->routeIs('mitra.shop')">
                            <i class="fas fa-store mr-2"></i> {{ __('Belanja Stok') }}
                        </x-nav-link>
                        <x-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.*')">
                            <i class="fas fa-history mr-2"></i> {{ __('Riwayat Pesanan') }}
                        </x-nav-link>
                    @endif

                    {{-- MENU OWNER --}}
                    @if(Auth::user()->role === 'owner')
                        <x-nav-link :href="route('owner.dashboard')" :active="request()->routeIs('owner.dashboard')">
                            <i class="fas fa-chart-pie mr-2"></i> {{ __('Monitoring') }}
                        </x-nav-link>
                        <x-nav-link :href="route('owner.reports.index')" :active="request()->routeIs('owner.reports.index')">
                            <i class="fas fa-file-invoice-dollar mr-2"></i> {{ __('Laporan Keuangan') }}
                        </x-nav-link>
                        <x-nav-link :href="route('owner.reports.menus')" :active="request()->routeIs('owner.reports.menus')">
                            <i class="fas fa-utensils mr-2"></i> {{ __('Laporan Menu') }}
                        </x-nav-link>
                    @endif

                    {{-- MENU ADMIN --}}
                    @if(Auth::user()->role === 'admin')
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            <i class="fas fa-user-shield mr-2"></i> {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                            <i class="fas fa-users-cog mr-2"></i> {{ __('Manajemen User') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')">
                            <i class="fas fa-box mr-2"></i> {{ __('Produk') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')">
                            <i class="fas fa-shopping-cart mr-2"></i> {{ __('Pesanan') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.reports.index')" :active="request()->routeIs('admin.reports.index')">
                            <i class="fas fa-chart-line mr-2"></i> {{ __('Laporan') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-3">
                
                {{-- Keranjang Belanja (Hanya Mitra) --}}
                @if(Auth::user()->role === 'mitra')
                    @php $cartCount = \App\Models\Cart::where('user_id', Auth::id())->sum('quantity'); @endphp
                    <a href="{{ route('checkout.show', Auth::id()) }}" class="relative p-2 text-white hover:text-yellow-300 transition">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        @if($cartCount > 0)
                            <span class="absolute top-0 right-0 bg-yellow-400 text-red-800 text-[10px] font-bold px-1.5 py-0.5 rounded-full border border-red-700">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>
                @endif

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-800 hover:bg-red-900 focus:outline-none transition">
                            <div class="mr-2 text-right">
                                <div class="font-bold">{{ Auth::user()->name }}</div>
                                <div class="text-[10px] uppercase tracking-wider text-red-200">{{ Auth::user()->role }}</div>
                            </div>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            <i class="fas fa-user-edit mr-2"></i> {{ __('Edit Profil') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="fas fa-sign-out-alt mr-2 text-red-600"></i> {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-red-100 hover:bg-red-600 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>
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
                    {{-- MENU MITRA (Akses Operasional Cabang) --}}
                    @if(Auth::user()->role === 'mitra')
                        <x-nav-link :href="route('mitra.shop')" :active="request()->routeIs('mitra.shop')">
                            <i class="fas fa-store mr-2"></i> {{ __('Belanja Stok') }}
                        </x-nav-link>
                        <x-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.*')">
                            <i class="fas fa-history mr-2"></i> {{ __('Riwayat Pesanan') }}
                        </x-nav-link>
                    @endif

                    {{-- MENU OWNER (Akses Read-Only Monitoring) --}}
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
                        <x-nav-link :href="route('owner.logs')" :active="request()->routeIs('owner.logs')">
                            <i class="fas fa-history mr-2"></i> {{ __('Audit Log') }}
                        </x-nav-link>
                    @endif

                    {{-- MENU ADMIN (Akses Full Management) --}}
                    @if(Auth::user()->role === 'admin')
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            <i class="fas fa-user-shield mr-2"></i> {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                            <i class="fas fa-users-cog mr-2"></i> {{ __('Manajemen User') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.logs')" :active="request()->routeIs('admin.logs')">
                            <i class="fas fa-history mr-2"></i> {{ __('Audit Log') }}
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
                        <x-nav-link :href="route('admin.messages.index')" :active="request()->routeIs('admin.messages.*')">
                            <i class="fas fa-envelope mr-2"></i> {{ __('Kotak Masuk') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-3">
                
                {{-- Icon Keranjang Belanja (Hanya untuk Mitra) --}}
                @if(Auth::user()->role === 'mitra')
                    @php
                        $cartCount = \App\Models\Cart::where('user_id', Auth::id())->sum('quantity');
                    @endphp
                    <a href="{{ route('checkout.show', Auth::id()) }}" class="relative p-2 text-white hover:text-yellow-300 transition">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        @if($cartCount > 0)
                            <span class="absolute top-0 right-0 bg-yellow-400 text-red-800 text-[10px] font-bold px-1.5 py-0.5 rounded-full border border-red-700 shadow-sm">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>
                @endif

                {{-- ============================================== --}}
                {{-- FITUR LONCENG NOTIFIKASI REAL-TIME (SEMUA ROLE)--}}
                {{-- ============================================== --}}
                <div class="relative" x-data="{ openNotif: false }" @click.outside="openNotif = false">
                    <button @click="openNotif = !openNotif" class="relative p-2 text-red-200 hover:text-white focus:outline-none transition-colors">
                        <i class="fas fa-bell text-xl"></i>
                        
                        {{-- Titik Merah (Jika ada notif belum dibaca) --}}
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="absolute top-1 right-1 flex h-3 w-3">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-yellow-500 text-[8px] font-bold text-red-900 items-center justify-center">
                                    {{ auth()->user()->unreadNotifications->count() }}
                                </span>
                            </span>
                        @endif
                    </button>

                    <div x-show="openNotif" style="display: none;" class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-2xl border border-gray-100 z-50 overflow-hidden"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95">
                        
                        <div class="bg-slate-50 px-4 py-3 border-b border-gray-100 flex justify-between items-center">
                            <h3 class="text-sm font-bold text-gray-800">Notifikasi Sistem</h3>
                            <span class="bg-red-100 text-red-600 text-[10px] font-black px-2 py-1 rounded-full uppercase">
                                {{ auth()->user()->unreadNotifications->count() }} Baru
                            </span>
                        </div>

                        <div class="max-h-72 overflow-y-auto">
                            @forelse(auth()->user()->unreadNotifications as $notification)
                                <a href="{{ route('notification.read', $notification->id) }}" class="block px-4 py-3 border-b border-gray-50 hover:bg-slate-50 transition-colors">
                                    <div class="flex items-start gap-3">
                                        <div class="mt-1 bg-red-100 p-2 rounded-full text-red-600 shrink-0">
                                            <i class="fas fa-info-circle"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-gray-800">{{ $notification->data['title'] }}</p>
                                            <p class="text-[10px] text-gray-500 mt-0.5 leading-tight">{{ $notification->data['message'] }}</p>
                                            <p class="text-[9px] text-gray-400 mt-1 font-medium"><i class="far fa-clock mr-1"></i>{{ $notification->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="px-4 py-6 text-center">
                                    <div class="text-gray-300 text-3xl mb-2"><i class="fas fa-bell-slash"></i></div>
                                    <p class="text-xs text-gray-500 font-medium">Belum ada notifikasi baru.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- User Profile Dropdown --}}
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-800 hover:bg-red-900 focus:outline-none transition shadow-sm">
                            <div class="mr-2 text-right">
                                <div class="font-bold">{{ Auth::user()->name }}</div>
                                <div class="text-[10px] uppercase tracking-wider text-red-200">{{ Auth::user()->role }}</div>
                            </div>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="hover:bg-red-50 hover:text-red-700">
                            <i class="fas fa-user-edit mr-2 text-gray-400"></i> {{ __('Edit Profil') }}
                        </x-dropdown-link>
                        <div class="border-t border-gray-100"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" class="hover:bg-red-50 text-red-600 font-semibold" onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="fas fa-sign-out-alt mr-2"></i> {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-red-100 hover:bg-red-600 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-red-800">
        <div class="pt-2 pb-3 space-y-1">
            @if(Auth::user()->role === 'mitra')
                <x-responsive-nav-link :href="route('mitra.shop')" :active="request()->routeIs('mitra.shop')"> {{ __('Belanja Stok') }} </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.*')"> {{ __('Riwayat Pesanan') }} </x-responsive-nav-link>
            @endif

            @if(Auth::user()->role === 'owner')
                <x-responsive-nav-link :href="route('owner.dashboard')"> {{ __('Monitoring') }} </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('owner.reports.index')"> {{ __('Laporan Keuangan') }} </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('owner.reports.menus')"> {{ __('Laporan Menu') }} </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('owner.logs')"> {{ __('Audit Log') }} </x-responsive-nav-link>
            @endif

            @if(Auth::user()->role === 'admin')
                <x-responsive-nav-link :href="route('admin.dashboard')"> {{ __('Dashboard') }} </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.users.index')"> {{ __('Manajemen User') }} </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.logs')"> {{ __('Audit Log') }} </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.products.index')"> {{ __('Produk') }} </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.orders.index')"> {{ __('Pesanan') }} </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.reports.index')"> {{ __('Laporan') }} </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.messages.index')"> {{ __('Kotak Masuk') }} </x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-1 border-t border-red-600">
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Edit Profil') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
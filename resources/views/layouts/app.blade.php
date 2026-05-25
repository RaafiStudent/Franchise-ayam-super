<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Ayam Super') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        .glass-nav { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f8fafc; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="font-sans antialiased text-slate-900 bg-slate-50 overflow-hidden selection:bg-red-500 selection:text-white relative" x-data="{ openSidebar: false }">
    
    <div class="flex h-screen w-full">
        
        {{-- OVERLAY GELAP UNTUK SIDEBAR DI HP --}}
        <div x-show="openSidebar" x-cloak @click="openSidebar = false" class="fixed inset-0 bg-black/50 z-[50] md:hidden transition-opacity"></div>

        {{-- SIDEBAR UTAMA --}}
        <aside :class="openSidebar ? 'translate-x-0' : '-translate-x-full'" class="fixed md:relative transform md:translate-x-0 transition-transform duration-300 w-64 bg-[#a51a1a] text-white h-full flex flex-col shadow-[4px_0_24px_rgba(0,0,0,0.05)] z-[55]">
            
            <button @click="openSidebar = false" class="md:hidden absolute top-4 right-4 text-white/80 hover:text-white text-2xl">
                <i class="fas fa-times"></i>
            </button>

            <div class="h-[88px] flex items-center px-6 border-b border-red-900/30 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-sm">
                        <i class="fas fa-drumstick-bite text-red-600 text-xl transform -rotate-12"></i>
                    </div>
                    <span class="font-black text-xl tracking-tight text-white">Ayam <span class="text-yellow-400">Super</span></span>
                </div>
            </div>

            <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1.5 custom-scrollbar">
                @if(Auth::user()->role == 'admin')
                    <p class="px-3 text-[10px] font-black text-red-200 uppercase tracking-widest mb-3 mt-2">Menu Utama Admin</p>
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.dashboard') ? 'bg-white text-red-800 shadow-sm font-bold' : 'text-red-100 hover:bg-red-800/50 hover:text-white font-medium group' }}">
                        <i class="fas fa-layer-group w-5 text-center {{ request()->routeIs('admin.dashboard') ? 'text-red-700' : 'text-red-300 group-hover:text-white' }} transition-colors"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.users.*') ? 'bg-white text-red-800 shadow-sm font-bold' : 'text-red-100 hover:bg-red-800/50 hover:text-white font-medium group' }}">
                        <i class="fas fa-users-cog w-5 text-center {{ request()->routeIs('admin.users.*') ? 'text-red-700' : 'text-red-300 group-hover:text-white' }} transition-colors"></i>
                        Manajemen User
                    </a>
                    <a href="{{ route('admin.logs') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.logs') ? 'bg-white text-red-800 shadow-sm font-bold' : 'text-red-100 hover:bg-red-800/50 hover:text-white font-medium group' }}">
                        <i class="fas fa-history w-5 text-center {{ request()->routeIs('admin.logs') ? 'text-red-700' : 'text-red-300 group-hover:text-white' }} transition-colors"></i>
                        Audit Log
                    </a>
                    
                    <p class="px-3 text-[10px] font-black text-red-200 uppercase tracking-widest mb-3 mt-6">Bisnis & Operasional</p>
                    
                    <a href="{{ route('admin.menus.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.menus.*') ? 'bg-white text-red-800 shadow-sm font-bold' : 'text-red-100 hover:bg-red-800/50 hover:text-white font-medium group' }}">
                        <i class="fas fa-utensils w-5 text-center {{ request()->routeIs('admin.menus.*') ? 'text-red-700' : 'text-red-300 group-hover:text-white' }} transition-colors"></i>
                        Katalog Menu
                    </a>

                    <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.products.*') ? 'bg-white text-red-800 shadow-sm font-bold' : 'text-red-100 hover:bg-red-800/50 hover:text-white font-medium group' }}">
                        <i class="fas fa-box-open w-5 text-center {{ request()->routeIs('admin.products.*') ? 'text-red-700' : 'text-red-300 group-hover:text-white' }} transition-colors"></i>
                        Produk
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.orders.*') ? 'bg-white text-red-800 shadow-sm font-bold' : 'text-red-100 hover:bg-red-800/50 hover:text-white font-medium group' }}">
                        <i class="fas fa-shopping-cart w-5 text-center {{ request()->routeIs('admin.orders.*') ? 'text-red-700' : 'text-red-300 group-hover:text-white' }} transition-colors"></i>
                        Pesanan
                    </a>
                    
                    <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.reports.*') ? 'bg-white text-red-800 shadow-sm font-bold' : 'text-red-100 hover:bg-red-800/50 hover:text-white font-medium group' }}">
                        <i class="fas fa-chart-pie w-5 text-center {{ request()->routeIs('admin.reports.*') ? 'text-red-700' : 'text-red-300 group-hover:text-white' }} transition-colors"></i>
                        Laporan Keuangan
                    </a>

                    <a href="{{ route('admin.messages.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.messages.*') ? 'bg-white text-red-800 shadow-sm font-bold' : 'text-red-100 hover:bg-red-800/50 hover:text-white font-medium group' }} mt-2">
                        <i class="fas fa-inbox w-5 text-center {{ request()->routeIs('admin.messages.*') ? 'text-red-700' : 'text-red-300 group-hover:text-white' }} transition-colors"></i>
                         Kotak Masuk
                    </a>
                @endif

                @if(Auth::user()->role == 'owner')
                    <p class="px-3 text-[10px] font-black text-red-200 uppercase tracking-widest mb-3 mt-2">Monitoring Eksekutif</p>
                    <a href="{{ route('owner.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('owner.dashboard') ? 'bg-white text-red-800 shadow-sm font-bold' : 'text-red-100 hover:bg-red-800/50 hover:text-white font-medium group' }}">
                        <i class="fas fa-chart-line w-5 text-center {{ request()->routeIs('owner.dashboard') ? 'text-red-700' : 'text-red-300 group-hover:text-white' }} transition-colors"></i>
                        Monitoring
                    </a>
                    <a href="{{ route('owner.reports.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('owner.reports.index') ? 'bg-white text-red-800 shadow-sm font-bold' : 'text-red-100 hover:bg-red-800/50 hover:text-white font-medium group' }}">
                        <i class="fas fa-file-invoice-dollar w-5 text-center {{ request()->routeIs('owner.reports.index') ? 'text-red-700' : 'text-red-300 group-hover:text-white' }} transition-colors"></i>
                        Laporan Keuangan
                    </a>
                    <a href="{{ route('owner.reports.menus') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('owner.reports.menus') ? 'bg-white text-red-800 shadow-sm font-bold' : 'text-red-100 hover:bg-red-800/50 hover:text-white font-medium group' }}">
                        <i class="fas fa-utensils w-5 text-center {{ request()->routeIs('owner.reports.menus') ? 'text-red-700' : 'text-red-300 group-hover:text-white' }} transition-colors"></i>
                        Laporan Menu
                    </a>
                    <a href="{{ route('owner.logs') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('owner.logs') ? 'bg-white text-red-800 shadow-sm font-bold' : 'text-red-100 hover:bg-red-800/50 hover:text-white font-medium group' }}">
                        <i class="fas fa-shield-alt w-5 text-center {{ request()->routeIs('owner.logs') ? 'text-red-700' : 'text-red-300 group-hover:text-white' }} transition-colors"></i>
                        Audit Log
                    </a>
                @endif

                @if(Auth::user()->role == 'mitra')
                    <p class="px-3 text-[10px] font-black text-red-200 uppercase tracking-widest mb-3 mt-2">Menu Mitra</p>
                    <a href="{{ route('mitra.shop') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('mitra.shop') ? 'bg-white text-red-800 shadow-sm font-bold' : 'text-red-100 hover:bg-red-800/50 hover:text-white font-medium group' }}">
                        <i class="fas fa-store w-5 text-center {{ request()->routeIs('mitra.shop') ? 'text-red-700' : 'text-red-300 group-hover:text-white' }} transition-colors"></i>
                        Belanja Stok
                    </a>
                    <a href="{{ route('orders.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('orders.*') ? 'bg-white text-red-800 shadow-sm font-bold' : 'text-red-100 hover:bg-red-800/50 hover:text-white font-medium group' }}">
                        <i class="fas fa-clipboard-list w-5 text-center {{ request()->routeIs('orders.*') ? 'text-red-700' : 'text-red-300 group-hover:text-white' }} transition-colors"></i>
                        Riwayat Pesanan
                    </a>
                @endif

                <p class="px-3 text-[10px] font-black text-red-200 uppercase tracking-widest mb-3 mt-8">Akun & Bantuan</p>
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('profile.*') ? 'bg-white text-red-800 shadow-sm font-bold' : 'text-red-100 hover:bg-red-800/50 hover:text-white font-medium group' }}">
                    <i class="fas fa-user-cog w-5 text-center {{ request()->routeIs('profile.*') ? 'text-red-700' : 'text-red-300 group-hover:text-white' }} transition-colors"></i>
                    Edit Profil
                </a>

                {{-- TOMBOL LOGOUT DI SIDEBAR (KHUSUS HP) --}}
                <form method="POST" action="{{ route('logout') }}" class="mt-2 md:hidden">
                    @csrf
                    <button type="submit" onclick="sessionStorage.clear()" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-300 text-red-100 hover:bg-red-800/50 hover:text-white font-bold group">
                        <i class="fas fa-sign-out-alt w-5 text-center text-red-300 group-hover:text-white transition-colors"></i>
                        Keluar / Logout
                    </button>
                </form>

            </nav>

            <div class="p-5 bg-red-900/50 border-t border-red-900/50 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-yellow-400 text-yellow-900 flex items-center justify-center font-bold shadow-sm">
                        {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-white truncate">{{ Auth::user()->name ?? 'Pengguna' }}</p>
                        <p class="text-[10px] text-red-200 font-bold tracking-widest uppercase">{{ Auth::user()->role ?? 'Guest' }}</p>
                    </div>
                </div>
            </div>
        </aside>

        {{-- AREA UTAMA --}}
        <div class="flex-1 flex flex-col overflow-hidden bg-slate-50 relative w-full">
            
            {{-- HEADER PUTIH (SEKARANG MUNCUL DI HP & LAPTOP) --}}
            <header class="min-h-[70px] md:h-[88px] glass-nav border-b border-slate-200/60 flex items-center justify-between px-4 md:px-8 z-10 sticky top-0 w-full py-2 md:py-0">
                
                {{-- BAGIAN KIRI: Hamburger & Tombol Tambah ($header) --}}
                <div class="flex items-center gap-3 md:gap-4 flex-1 min-w-0">
                    <button @click="openSidebar = true" class="md:hidden text-slate-500 hover:text-red-600 transition-colors p-1">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    
                    {{-- INI KUNCI AGAR TOMBOL TAMBAH MUNCUL KEMBALI DI HP --}}
                    <div class="flex-1 min-w-0 w-full text-slate-800 font-bold overflow-hidden">
                        {{ $header ?? 'Panel Kendali' }}
                    </div>
                </div>

                {{-- BAGIAN KANAN: Keranjang, Lonceng, Logout --}}
                <div class="flex items-center gap-3 md:gap-5 ml-2 shrink-0">
                    @if(Auth::user()->role == 'mitra')
                        <button onclick="toggleOffcanvasCart()" class="w-9 h-9 md:w-10 md:h-10 rounded-full bg-white text-slate-500 hover:bg-slate-100 hover:text-red-600 flex items-center justify-center transition-all border border-slate-200 relative shadow-sm group">
                            <i class="fas fa-shopping-cart group-hover:scale-110 transition-transform text-sm md:text-base"></i>
                            @php
                                $cartCount = \App\Models\Cart::where('user_id', Auth::user()->id)->sum('quantity') ?? 0;
                            @endphp
                            @if($cartCount > 0)
                                <span id="header-qty-badge" class="absolute -top-1 -right-1 bg-red-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full ring-2 ring-white">{{ $cartCount }}</span>
                            @endif
                        </button>
                    @endif

                    <div class="relative" x-data="{ openNotif: false }" @click.outside="openNotif = false">
                        <button @click="openNotif = !openNotif" class="w-9 h-9 md:w-10 md:h-10 rounded-full bg-white text-slate-500 hover:bg-slate-100 hover:text-slate-700 flex items-center justify-center transition-all border border-slate-200 relative shadow-sm">
                            <i class="fas fa-bell text-sm md:text-base"></i>
                            @if(auth()->user()->unreadNotifications->count() > 0)
                                <span class="absolute top-2 right-2 w-2 h-2 bg-red-600 rounded-full ring-2 ring-white animate-pulse"></span>
                            @endif
                        </button>

                        <div x-show="openNotif" x-cloak x-transition style="display: none;" class="absolute right-0 mt-3 w-[300px] md:w-[420px] bg-white rounded-3xl shadow-2xl border border-slate-200 z-50 overflow-hidden">
                            <div class="bg-slate-50 px-4 md:px-7 py-4 md:py-5 border-b border-slate-200 flex justify-between items-center">
                                <h3 class="text-sm md:text-base font-black text-slate-900 uppercase tracking-widest">Notifikasi</h3>
                                <span class="bg-red-100 text-red-700 text-[10px] md:text-xs font-black px-2 md:px-3 py-1 rounded-lg uppercase shadow-sm">
                                    {{ auth()->user()->unreadNotifications->count() }} Baru
                                </span>
                            </div>
                            
                            <div class="max-h-80 overflow-y-auto custom-scrollbar">
                                @forelse(auth()->user()->unreadNotifications as $notification)
                                    <a href="{{ route('notification.read', $notification->id) }}" class="flex items-start gap-4 px-4 md:px-7 py-4 border-b border-slate-50 hover:bg-red-50/50 transition-colors group">
                                        <div class="w-10 h-10 md:w-12 md:h-12 rounded-2xl bg-red-100 text-red-600 flex items-center justify-center shrink-0 mt-0.5 group-hover:scale-110 transition-transform shadow-sm">
                                            <i class="fas fa-info-circle text-lg md:text-xl"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-black text-slate-900 leading-tight mb-1">{{ $notification->data['title'] ?? 'Informasi Sistem' }}</p>
                                            <p class="text-[11px] md:text-xs font-bold text-slate-700 leading-relaxed">{{ $notification->data['message'] ?? 'Tidak ada pesan.' }}</p>
                                            <p class="text-[9px] md:text-[10px] text-slate-400 mt-2 font-bold tracking-widest uppercase"><i class="far fa-clock mr-1"></i> {{ $notification->created_at->diffForHumans() }}</p>
                                        </div>
                                    </a>
                                @empty
                                    <div class="py-12 text-center px-4">
                                        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300 shadow-inner">
                                            <i class="fas fa-bell-slash text-2xl"></i>
                                        </div>
                                        <p class="text-sm font-black text-slate-900 mb-1 uppercase tracking-wide">Kosong</p>
                                        <p class="text-xs font-bold text-slate-500">Belum ada notifikasi baru.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    
                    <div class="h-6 md:h-8 w-px bg-slate-200 hidden sm:block"></div>

                    {{-- TOMBOL LOGOUT (Hanya Tampil di Laptop, HP dari Sidebar) --}}
                    <form method="POST" action="{{ route('logout') }}" class="hidden sm:block">
                        @csrf
                        <button type="submit" onclick="sessionStorage.clear()" class="group flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-100 hover:text-red-600 transition-all">
                            Keluar
                            <i class="fas fa-sign-out-alt text-slate-400 group-hover:text-red-600 transition-colors"></i>
                        </button>
                    </form>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-transparent relative">
                {{ $slot }}
            </main>
        </div>
    </div>

    {{-- LACI KERANJANG & WELCOME GUIDE --}}
    @if(Auth::check() && Auth::user()->role == 'mitra')
        @php
            $cartSidebar = \App\Models\Cart::with('product')->where('user_id', Auth::id())->get();
            $totalSidebar = 0;
            foreach($cartSidebar as $c) {
                $totalSidebar += $c->product->price * $c->quantity;
            }
        @endphp

        <div id="cartBackdrop" onclick="toggleOffcanvasCart()" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[60] opacity-0 pointer-events-none transition-opacity duration-300"></div>
        <div id="cartOffcanvas" class="fixed top-0 right-0 h-full w-full sm:w-[420px] bg-white shadow-2xl z-[70] transform translate-x-full transition-transform duration-300 ease-in-out flex flex-col">
            
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-white sticky top-0 z-10">
                <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <i class="fas fa-shopping-basket text-red-600"></i> Keranjang Anda
                </h2>
                <button onclick="toggleOffcanvasCart()" class="w-8 h-8 rounded-full bg-slate-50 text-slate-400 hover:bg-slate-100 hover:text-red-600 flex items-center justify-center transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div id="cart-items-container" class="flex-1 overflow-y-auto p-6 bg-slate-50 pb-32 custom-scrollbar">
                @if($cartSidebar->count() > 0)
                    @foreach($cartSidebar as $item)
                        <div id="sidebar-item-{{ $item->product_id }}" class="flex gap-4 bg-white p-4 rounded-2xl border border-slate-100 shadow-sm mb-4 relative hover:border-slate-200 transition-colors">
                            <div class="w-16 h-16 md:w-20 md:h-20 rounded-xl bg-slate-50 overflow-hidden shrink-0 flex items-center justify-center text-slate-400">
                                <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1 flex flex-col justify-center">
                                <h4 class="text-sm font-bold text-slate-800 mb-1 leading-tight line-clamp-2">{{ $item->product->name }}</h4>
                                <p class="text-xs font-black text-red-600 mb-3">Rp {{ number_format($item->product->price, 0, ',', '.') }} <span class="text-slate-400 font-normal">/ Pack</span></p>
                                <div class="flex items-center gap-3 w-fit bg-slate-50 rounded-lg p-1 border border-slate-100">
                                    <button type="button" onclick="instantCartAction(event, 'decrease', {{ $item->product_id }})" class="w-7 h-7 rounded bg-white border border-slate-200 text-slate-500 hover:text-red-600 flex items-center justify-center text-xs">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    
                                    <span class="sidebar-qty-text text-xs font-bold text-slate-800 w-4 text-center">{{ $item->quantity }}</span>
                                    
                                    <button type="button" onclick="instantCartAction(event, 'add', {{ $item->product_id }})" class="w-7 h-7 rounded bg-white border border-slate-200 text-slate-500 hover:text-red-600 flex items-center justify-center text-xs">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <button type="button" onclick="instantCartAction(event, 'remove', {{ $item->product_id }}, {{ $item->id }})" class="absolute top-4 right-4 text-slate-300 hover:text-red-600 transition-colors">
                                <i class="fas fa-trash-alt text-sm"></i>
                            </button>
                        </div>
                    @endforeach
                @else
                    <div class="text-center mt-20">
                        <i class="fas fa-shopping-cart text-5xl text-slate-200 mb-4"></i>
                        <p class="text-slate-400 font-bold">Keranjang Anda masih kosong</p>
                        <p class="text-xs text-slate-400 mt-1">Silakan belanja stok bahan baku di katalog.</p>
                    </div>
                @endif
            </div>

            <div id="cart-sidebar-footer" class="p-6 bg-white border-t border-slate-100 shadow-[0_-10px_20px_rgba(0,0,0,0.02)] absolute bottom-0 left-0 w-full">
                <div class="flex items-center justify-between mb-5">
                    <span class="text-sm font-semibold text-slate-500">Estimasi Total</span>
                    <span class="estimasi-total-text text-xl md:text-2xl font-black text-slate-900 tracking-tight">Rp {{ number_format($totalSidebar, 0, ',', '.') }}</span>
                </div>
                
                <form action="{{ route('checkout.process') }}" method="POST">
                    @csrf
                    <button type="submit" id="btn-lanjutkan-sidebar" class="w-full py-3.5 bg-[#b91c1c] hover:bg-[#991b1b] text-white rounded-xl font-bold text-sm flex items-center justify-center gap-2 shadow-md transition-all {{ $cartSidebar->count() == 0 ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $cartSidebar->count() == 0 ? 'disabled' : '' }}>
                        Lanjutkan Pembayaran <i class="fas fa-arrow-right ml-1"></i>
                    </button>
                </form>
            </div>
        </div>

        {{-- SUNTIKAN SCRIPT SMART CART REAL-TIME --}}
        <script>
            function toggleOffcanvasCart() {
                const offcanvas = document.getElementById('cartOffcanvas');
                const backdrop = document.getElementById('cartBackdrop');
                if (offcanvas.classList.contains('translate-x-full')) {
                    offcanvas.classList.remove('translate-x-full');
                    backdrop.classList.remove('opacity-0', 'pointer-events-none');
                } else {
                    offcanvas.classList.add('translate-x-full');
                    backdrop.classList.add('opacity-0', 'pointer-events-none');
                }
            }

            let typingTimer;
            function handleTyping(inputElement, productId) {
                inputElement.value = inputElement.value.replace(/[^0-9]/g, '');
                clearTimeout(typingTimer);
                
                typingTimer = setTimeout(() => {
                    let qty = parseInt(inputElement.value) || 0;
                    instantCartAction(null, 'update', productId, null, qty);
                }, 500); 
            }

            async function instantCartAction(event, action, productId, cartId = null, manualQty = null) {
                if (event && event.preventDefault) event.preventDefault(); 

                let url = '';
                let method = 'POST';
                if (action === 'add') { url = '/cart/add/' + productId; }
                else if (action === 'decrease') { url = '/cart/decrease/' + productId; }
                else if (action === 'remove') { url = '/cart/remove/' + cartId; method = 'DELETE'; }
                else if (action === 'update') { url = '/cart/update/' + productId + '?quantity=' + manualQty; }

                try {
                    let response = await fetch(url, {
                        method: method,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        }
                    });

                    let data = await response.json();

                    if (data.status === 'success') {
                        let formattedPrice = 'Rp ' + data.total_price;
                        document.querySelectorAll('.estimasi-total-text').forEach(el => el.innerText = formattedPrice);
                        
                        let headerBadge = document.getElementById('header-qty-badge');
                        let stickyBadge = document.getElementById('total-qty-badge');
                        if(headerBadge) headerBadge.innerText = data.total_qty;
                        if(stickyBadge) stickyBadge.innerText = data.total_qty;

                        let serverQty = data.cart_items[productId] || 0;
                        
                        let gridContainer = document.querySelector(`.product-action-container[data-id="${productId}"]`);
                        if (gridContainer) {
                            let btnAdd = gridContainer.querySelector('.btn-add');
                            let btnCounter = gridContainer.querySelector('.btn-counter');
                            let qtyDisplayGrid = gridContainer.querySelector('.qty-text');
                            
                            if (serverQty > 0) {
                                if (btnAdd) btnAdd.classList.add('hidden');
                                if (btnCounter) { btnCounter.classList.remove('hidden'); btnCounter.classList.add('flex'); }
                                if (qtyDisplayGrid) {
                                    qtyDisplayGrid.value = serverQty;
                                }
                            } else {
                                if (btnAdd) btnAdd.classList.remove('hidden');
                                if (btnCounter) { btnCounter.classList.add('hidden'); btnCounter.classList.remove('flex'); }
                            }
                        }

                        let sidebarItem = document.getElementById('sidebar-item-' + productId);
                        if (sidebarItem) {
                            if (serverQty > 0) {
                                let qtySidebar = sidebarItem.querySelector('.sidebar-qty-text');
                                if (qtySidebar) qtySidebar.innerText = serverQty;
                            } else {
                                sidebarItem.remove(); 
                            }
                        } else if (serverQty > 0 && action === 'add') {
                            let pageResponse = await fetch(window.location.href);
                            let pageHtml = await pageResponse.text();
                            let doc = new DOMParser().parseFromString(pageHtml, 'text/html');
                            let oldCartItems = document.getElementById('cart-items-container');
                            let newCartItems = doc.getElementById('cart-items-container');
                            if (oldCartItems && newCartItems) oldCartItems.innerHTML = newCartItems.innerHTML;
                        }

                        let container = document.getElementById('cart-items-container');
                        let stickyFooter = document.getElementById('cart-footer');
                        let btnSidebar = document.getElementById('btn-lanjutkan-sidebar');
                        let btnUtama = document.getElementById('btn-lanjutkan');

                        if (data.total_qty === 0) {
                            if(container) container.innerHTML = `<div class="text-center mt-20"><i class="fas fa-shopping-cart text-5xl text-slate-200 mb-4"></i><p class="text-slate-400 font-bold">Keranjang Anda masih kosong</p><p class="text-xs text-slate-400 mt-1">Silakan belanja stok bahan baku di katalog.</p></div>`;
                            if(stickyFooter) stickyFooter.classList.add('hidden');
                            if(btnUtama) { btnUtama.disabled = true; btnUtama.classList.add('opacity-50', 'cursor-not-allowed'); }
                            if(btnSidebar) { btnSidebar.disabled = true; btnSidebar.classList.add('opacity-50', 'cursor-not-allowed'); }
                        } else {
                            if(stickyFooter) stickyFooter.classList.remove('hidden');
                            if(btnUtama) { btnUtama.disabled = false; btnUtama.classList.remove('opacity-50', 'cursor-not-allowed'); }
                            if(btnSidebar) { btnSidebar.disabled = false; btnSidebar.classList.remove('opacity-50', 'cursor-not-allowed'); }
                        }
                    }
                } catch (error) {
                    console.error('Koneksi terputus:', error);
                }
            }
        </script>
    @endif

    @if(Auth::check() && !session()->has('welcome_guide_shown'))
    @php session()->put('welcome_guide_shown', true); @endphp
    <div x-data="{
            showGuide: false,
            init() {
                setTimeout(() => { this.showGuide = true; }, 400); 
            },
            closeGuide() {
                this.showGuide = false;
            }
        }"
        x-show="showGuide"
        x-cloak
        class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6"
    >
        <div x-show="showGuide" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm"
             @click="closeGuide()">
        </div>

        <div x-show="showGuide"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 translate-y-8 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-8 scale-95"
             class="relative bg-white rounded-[2rem] shadow-2xl w-full max-w-4xl overflow-hidden flex flex-col max-h-[90vh]"
        >
            <div class="px-5 md:px-8 py-5 md:py-6 border-b border-slate-100 flex items-center justify-between bg-slate-50 relative overflow-hidden shrink-0">
                <div class="absolute top-0 left-0 w-full h-1 {{ Auth::user()->role == 'owner' ? 'bg-yellow-400' : (Auth::user()->role == 'admin' ? 'bg-red-600' : 'bg-blue-600') }}"></div>
                <div class="flex items-center gap-3 md:gap-4">
                    <div class="w-10 h-10 md:w-12 md:h-12 rounded-2xl flex items-center justify-center text-lg md:text-xl text-white shadow-md {{ Auth::user()->role == 'owner' ? 'bg-gradient-to-br from-yellow-400 to-yellow-600' : (Auth::user()->role == 'admin' ? 'bg-gradient-to-br from-red-500 to-red-700' : 'bg-gradient-to-br from-blue-500 to-blue-700') }}">
                        <i class="fas fa-hands-helping"></i>
                    </div>
                    <div>
                        <h3 class="text-lg md:text-xl font-extrabold text-slate-800 tracking-tight">Selamat Datang, {{ explode(' ', Auth::user()->name)[0] }}! 👋</h3>
                        <p class="text-[10px] md:text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Panduan Cepat Dashboard {{ ucfirst(Auth::user()->role) }}</p>
                    </div>
                </div>
                <button @click="closeGuide()" class="w-8 h-8 rounded-full bg-slate-200 text-slate-500 hover:bg-red-100 hover:text-red-600 flex items-center justify-center transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="p-5 md:p-8 overflow-y-auto custom-scrollbar bg-white">
                <p class="text-xs md:text-sm font-medium text-slate-500 mb-6 leading-relaxed">
                    Agar Anda dapat menggunakan sistem ini dengan maksimal, berikut adalah penjelasan singkat mengenai <span class="font-bold text-slate-800">seluruh fungsi menu</span> yang ada di sebelah kiri layar Anda:
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-4">
                    @if(Auth::user()->role == 'admin')
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 hover:border-red-200 transition-colors group">
                            <h4 class="font-bold text-slate-800 flex items-center gap-3 mb-1.5">
                                <div class="w-7 h-7 rounded-lg bg-red-100 text-red-600 flex items-center justify-center group-hover:scale-110 transition-transform"><i class="fas fa-layer-group text-sm"></i></div>
                                Dashboard
                            </h4>
                            <p class="text-[11px] text-slate-500 leading-relaxed">Melihat ringkasan statistik harian, omset masuk, dan peringatan stok bahan baku.</p>
                        </div>
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 hover:border-red-200 transition-colors group">
                            <h4 class="font-bold text-slate-800 flex items-center gap-3 mb-1.5">
                                <div class="w-7 h-7 rounded-lg bg-red-100 text-red-600 flex items-center justify-center group-hover:scale-110 transition-transform"><i class="fas fa-users-cog text-sm"></i></div>
                                Manajemen User
                            </h4>
                            <p class="text-[11px] text-slate-500 leading-relaxed">Mendaftarkan Mitra baru, mengaktifkan akun, atau memblokir pengguna bermasalah.</p>
                        </div>
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 hover:border-red-200 transition-colors group">
                            <h4 class="font-bold text-slate-800 flex items-center gap-3 mb-1.5">
                                <div class="w-7 h-7 rounded-lg bg-red-100 text-red-600 flex items-center justify-center group-hover:scale-110 transition-transform"><i class="fas fa-history text-sm"></i></div>
                                Audit Log
                            </h4>
                            <p class="text-[11px] text-slate-500 leading-relaxed">Merekam semua rekam jejak aktivitas Admin demi memastikan keamanan sistem.</p>
                        </div>
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 hover:border-red-200 transition-colors group">
                            <h4 class="font-bold text-slate-800 flex items-center gap-3 mb-1.5">
                                <div class="w-7 h-7 rounded-lg bg-red-100 text-red-600 flex items-center justify-center group-hover:scale-110 transition-transform"><i class="fas fa-utensils text-sm"></i></div>
                                Katalog Menu
                            </h4>
                            <p class="text-[11px] text-slate-500 leading-relaxed">Mengelola foto dan deskripsi menu ayam untuk ditampilkan secara langsung di halaman publik.</p>
                        </div>
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 hover:border-red-200 transition-colors group">
                            <h4 class="font-bold text-slate-800 flex items-center gap-3 mb-1.5">
                                <div class="w-7 h-7 rounded-lg bg-red-100 text-red-600 flex items-center justify-center group-hover:scale-110 transition-transform"><i class="fas fa-box-open text-sm"></i></div>
                                Produk Bahan Baku
                            </h4>
                            <p class="text-[11px] text-slate-500 leading-relaxed">Menambah atau memperbarui harga dan stok bumbu marinasi/packaging untuk Mitra.</p>
                        </div>
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 hover:border-red-200 transition-colors group">
                            <h4 class="font-bold text-slate-800 flex items-center gap-3 mb-1.5">
                                <div class="w-7 h-7 rounded-lg bg-red-100 text-red-600 flex items-center justify-center group-hover:scale-110 transition-transform"><i class="fas fa-shopping-cart text-sm"></i></div>
                                Pesanan Mitra
                            </h4>
                            <p class="text-[11px] text-slate-500 leading-relaxed">Memproses orderan masuk dari Mitra dan memasukkan Nomor Resi kurir pengiriman.</p>
                        </div>
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 hover:border-red-200 transition-colors group">
                            <h4 class="font-bold text-slate-800 flex items-center gap-3 mb-1.5">
                                <div class="w-7 h-7 rounded-lg bg-red-100 text-red-600 flex items-center justify-center group-hover:scale-110 transition-transform"><i class="fas fa-chart-pie text-sm"></i></div>
                                Laporan Penjualan
                            </h4>
                            <p class="text-[11px] text-slate-500 leading-relaxed">Mencetak rekap laporan pemasukan transaksi berformat PDF untuk arsip bulanan.</p>
                        </div>
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 hover:border-red-200 transition-colors group">
                            <h4 class="font-bold text-slate-800 flex items-center gap-3 mb-1.5">
                                <div class="w-7 h-7 rounded-lg bg-red-100 text-red-600 flex items-center justify-center group-hover:scale-110 transition-transform"><i class="fas fa-inbox text-sm"></i></div>
                                Kotak Masuk
                            </h4>
                            <p class="text-[11px] text-slate-500 leading-relaxed">Membaca pesan atau kritik saran yang dikirim dari pengunjung di halaman Kontak website.</p>
                        </div>
                    @endif

                    @if(Auth::user()->role == 'owner')
                        <div class="bg-slate-50 p-4 md:p-5 rounded-2xl border border-slate-100 hover:border-yellow-200 transition-colors group">
                            <h4 class="font-bold text-slate-800 flex items-center gap-3 mb-2">
                                <div class="w-8 h-8 rounded-lg bg-yellow-100 text-yellow-600 flex items-center justify-center group-hover:scale-110 transition-transform"><i class="fas fa-chart-line"></i></div>
                                Monitoring Utama
                            </h4>
                            <p class="text-[11px] md:text-xs text-slate-500 leading-relaxed">Memantau kesehatan bisnis secara keseluruhan melalui grafik penjualan bulanan dan total omset real-time.</p>
                        </div>
                        <div class="bg-slate-50 p-4 md:p-5 rounded-2xl border border-slate-100 hover:border-yellow-200 transition-colors group">
                            <h4 class="font-bold text-slate-800 flex items-center gap-3 mb-2">
                                <div class="w-8 h-8 rounded-lg bg-yellow-100 text-yellow-600 flex items-center justify-center group-hover:scale-110 transition-transform"><i class="fas fa-file-invoice-dollar"></i></div>
                                Laporan Keuangan
                            </h4>
                            <p class="text-[11px] md:text-xs text-slate-500 leading-relaxed">Melihat daftar detail transaksi yang masuk, mengecek status pembayaran, dan mengunduh laporan PDF bulanan.</p>
                        </div>
                        <div class="bg-slate-50 p-4 md:p-5 rounded-2xl border border-slate-100 hover:border-yellow-200 transition-colors group">
                            <h4 class="font-bold text-slate-800 flex items-center gap-3 mb-2">
                                <div class="w-8 h-8 rounded-lg bg-yellow-100 text-yellow-600 flex items-center justify-center group-hover:scale-110 transition-transform"><i class="fas fa-utensils"></i></div>
                                Laporan Menu (Rating)
                            </h4>
                            <p class="text-[11px] md:text-xs text-slate-500 leading-relaxed">Menganalisis performa setiap menu hidangan berdasarkan respon Suka/Tidak Suka dari pelanggan di halaman depan.</p>
                        </div>
                        <div class="bg-slate-50 p-4 md:p-5 rounded-2xl border border-slate-100 hover:border-yellow-200 transition-colors group">
                            <h4 class="font-bold text-slate-800 flex items-center gap-3 mb-2">
                                <div class="w-8 h-8 rounded-lg bg-yellow-100 text-yellow-600 flex items-center justify-center group-hover:scale-110 transition-transform"><i class="fas fa-shield-alt"></i></div>
                                Audit Log Keamanan
                            </h4>
                            <p class="text-[11px] md:text-xs text-slate-500 leading-relaxed">Melacak seluruh tindakan yang dilakukan oleh Admin (siapa mengubah, menambah, atau menghapus data apa).</p>
                        </div>
                    @endif

                    @if(Auth::user()->role == 'mitra')
                        <div class="bg-slate-50 p-4 md:p-5 rounded-2xl border border-slate-100 hover:border-blue-200 transition-colors group">
                            <h4 class="font-bold text-slate-800 flex items-center gap-3 mb-2">
                                <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center group-hover:scale-110 transition-transform"><i class="fas fa-store"></i></div>
                                Belanja Stok Bahan
                            </h4>
                            <p class="text-[11px] md:text-xs text-slate-500 leading-relaxed">Katalog online untuk Anda membeli stok ayam marinasi, tepung bumbu, kemasan box, dan keperluan outlet lainnya.</p>
                        </div>
                        <div class="bg-slate-50 p-4 md:p-5 rounded-2xl border border-slate-100 hover:border-blue-200 transition-colors group">
                            <h4 class="font-bold text-slate-800 flex items-center gap-3 mb-2">
                                <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center group-hover:scale-110 transition-transform"><i class="fas fa-shopping-basket"></i></div>
                                Fitur Keranjang
                            </h4>
                            <p class="text-[11px] md:text-xs text-slate-500 leading-relaxed">Klik ikon keranjang di pojok kanan atas layar setiap saat untuk melihat rincian belanja dan melanjutkan pembayaran.</p>
                        </div>
                        <div class="bg-slate-50 p-4 md:p-5 rounded-2xl border border-slate-100 hover:border-blue-200 transition-colors group md:col-span-2">
                            <h4 class="font-bold text-slate-800 flex items-center gap-3 mb-2">
                                <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center group-hover:scale-110 transition-transform"><i class="fas fa-clipboard-list"></i></div>
                                Riwayat & Lacak Pesanan
                            </h4>
                            <p class="text-[11px] md:text-xs text-slate-500 leading-relaxed">Memantau status pengiriman belanjaan Anda dari pusat secara real-time. Anda juga dapat melihat nomor resi kurir dan mengunduh struk pembayaran (Invoice) di dalam menu ini.</p>
                        </div>
                    @endif

                </div>
            </div>

            <div class="px-5 md:px-8 py-4 md:py-5 border-t border-slate-100 bg-slate-50 flex flex-col sm:flex-row items-center justify-between shrink-0 gap-3">
                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest"><i class="fas fa-info-circle mr-1"></i> Sistem Manajemen v1.0</span>
                <button @click="closeGuide()" class="w-full sm:w-auto bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs uppercase tracking-widest py-3 px-7 rounded-xl shadow-md transition-all active:scale-95 flex items-center justify-center gap-2">
                    Siap, Saya Mengerti! <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </div>
    </div>
    @endif

    @stack('scripts')
</body>
</html>
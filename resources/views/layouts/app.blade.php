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

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        .glass-nav { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
    </style>
</head>
<body class="font-sans antialiased text-slate-900 bg-slate-50 overflow-hidden selection:bg-red-500 selection:text-white relative">
    
    <div class="flex h-screen w-full">

        <aside class="w-64 bg-[#a51a1a] text-white flex-shrink-0 hidden md:flex flex-col shadow-[4px_0_24px_rgba(0,0,0,0.05)] z-20">
            
            <div class="h-[88px] flex items-center px-6 border-b border-red-900/30">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-sm">
                        <i class="fas fa-drumstick-bite text-red-600 text-xl transform -rotate-12"></i>
                    </div>
                    <span class="font-black text-xl tracking-tight text-white">Ayam <span class="text-yellow-400">Super</span></span>
                </div>
            </div>

            <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1.5">
                
                {{-- MENU KHUSUS ADMIN --}}
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
                        Laporan
                    </a>

                    <a href="{{ route('admin.messages.index') }}" class="flex items-center justify-between px-4 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.messages.*') ? 'bg-white text-red-800 shadow-sm font-bold' : 'text-red-100 hover:bg-red-800/50 hover:text-white font-medium group' }} mt-2">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-inbox w-5 text-center {{ request()->routeIs('admin.messages.*') ? 'text-red-700' : 'text-red-300 group-hover:text-white' }} transition-colors"></i>
                            Kotak Masuk
                        </div>
                        <span class="bg-yellow-400 text-yellow-950 text-[10px] font-black px-2 py-0.5 rounded-full shadow-sm">3</span>
                    </a>
                @endif

                {{-- MENU KHUSUS OWNER --}}
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

                {{-- MENU KHUSUS MITRA --}}
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

            </nav>

            <div class="p-5 bg-red-900/50 border-t border-red-900/50">
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

        <div class="flex-1 flex flex-col overflow-hidden bg-slate-50 relative">
            
            <header class="h-[88px] glass-nav border-b border-slate-200/60 flex items-center justify-between px-8 z-10 sticky top-0">
                <div class="flex items-center gap-4">
                    <button class="md:hidden text-slate-500 hover:text-slate-800 transition-colors">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <h1 class="text-xl font-bold text-slate-800 tracking-tight hidden sm:block">
                        {{ $header ?? 'Panel Kendali' }}
                    </h1>
                </div>

                <div class="flex items-center gap-5">
                    
                    {{-- LOGIKA IKON TOPBAR: KERANJANG (TOMBOL SLIDE) vs LONCENG --}}
                    @if(Auth::user()->role == 'mitra')
                        <button onclick="toggleOffcanvasCart()" class="w-10 h-10 rounded-full bg-white text-slate-500 hover:bg-slate-100 hover:text-red-600 flex items-center justify-center transition-all border border-slate-200 relative shadow-sm group">
                            <i class="fas fa-shopping-cart group-hover:scale-110 transition-transform"></i>
                            @php
                                $cartCount = \App\Models\Cart::where('user_id', Auth::user()->id)->sum('quantity') ?? 0;
                            @endphp
                            @if($cartCount > 0)
                                <span class="absolute -top-1 -right-1 bg-red-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full ring-2 ring-white">{{ $cartCount }}</span>
                            @endif
                        </button>
                    @else
                        <button class="w-10 h-10 rounded-full bg-white text-slate-500 hover:bg-slate-100 hover:text-slate-700 flex items-center justify-center transition-all border border-slate-200 relative shadow-sm">
                            <i class="fas fa-bell"></i>
                            <span class="absolute top-2.5 right-2.5 w-2 h-2 bg-red-600 rounded-full ring-2 ring-white"></span>
                        </button>
                    @endif
                    
                    <div class="h-8 w-px bg-slate-200 hidden sm:block"></div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="group flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-100 hover:text-red-600 transition-all">
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

    @if(Auth::user()->role == 'mitra')
        
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

            <div class="flex-1 overflow-y-auto p-6 bg-white">
                
                {{-- Mockup Item 1 --}}
                <div class="flex gap-4 bg-white p-4 rounded-2xl border border-slate-100 shadow-sm mb-4 relative group hover:border-slate-200 transition-colors">
                    <div class="w-20 h-20 rounded-xl bg-slate-50 overflow-hidden shrink-0 flex items-center justify-center text-slate-400">
                        <i class="fas fa-drumstick-bite text-2xl"></i>
                    </div>
                    <div class="flex-1 flex flex-col justify-center">
                        <h4 class="text-sm font-bold text-slate-800 mb-1 leading-tight">Ayam Marinasi (Pre-Cut)</h4>
                        <p class="text-xs font-black text-red-600 mb-3">Rp 45.000 <span class="text-slate-400 font-medium font-normal">/ Pack</span></p>
                        
                        <div class="flex items-center gap-3 w-fit">
                            <button class="w-7 h-7 rounded-lg bg-white border border-slate-200 text-slate-500 shadow-sm hover:text-red-600 flex items-center justify-center text-xs"><i class="fas fa-minus"></i></button>
                            <span class="text-xs font-bold text-slate-800 w-4 text-center">10</span>
                            <button class="w-7 h-7 rounded-lg bg-white border border-slate-200 text-slate-500 shadow-sm hover:text-red-600 flex items-center justify-center text-xs"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                    <button class="absolute top-4 right-4 text-slate-300 hover:text-red-600 transition-colors"><i class="fas fa-trash-alt text-sm"></i></button>
                </div>

                {{-- Mockup Item 2 --}}
                <div class="flex gap-4 bg-white p-4 rounded-2xl border border-slate-100 shadow-sm mb-4 relative group hover:border-slate-200 transition-colors">
                    <div class="w-20 h-20 rounded-xl bg-slate-50 overflow-hidden shrink-0 flex items-center justify-center text-slate-400">
                        <i class="fas fa-box-open text-2xl"></i>
                    </div>
                    <div class="flex-1 flex flex-col justify-center">
                        <h4 class="text-sm font-bold text-slate-800 mb-1 leading-tight">Tepung Biang Premium</h4>
                        <p class="text-xs font-black text-red-600 mb-3">Rp 28.000 <span class="text-slate-400 font-medium font-normal">/ Pack</span></p>
                        
                        <div class="flex items-center gap-3 w-fit">
                            <button class="w-7 h-7 rounded-lg bg-white border border-slate-200 text-slate-500 shadow-sm hover:text-red-600 flex items-center justify-center text-xs"><i class="fas fa-minus"></i></button>
                            <span class="text-xs font-bold text-slate-800 w-4 text-center">5</span>
                            <button class="w-7 h-7 rounded-lg bg-white border border-slate-200 text-slate-500 shadow-sm hover:text-red-600 flex items-center justify-center text-xs"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                    <button class="absolute top-4 right-4 text-slate-300 hover:text-red-600 transition-colors"><i class="fas fa-trash-alt text-sm"></i></button>
                </div>

            </div>

            <div class="p-6 bg-white border-t border-slate-100 shadow-[0_-10px_20px_rgba(0,0,0,0.02)]">
                <div class="flex items-center justify-between mb-5">
                    <span class="text-sm font-semibold text-slate-500">Estimasi Total</span>
                    <span class="text-2xl font-black text-slate-900 tracking-tight">Rp 590.000</span>
                </div>
                <a href="{{ route('checkout.show', Auth::user()->id) ?? '#' }}" class="w-full py-3.5 bg-[#b91c1c] hover:bg-[#991b1b] text-white rounded-xl font-bold text-sm flex items-center justify-center gap-2 shadow-md transition-all">
                    Lanjutkan Pembayaran <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>

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
        </script>
    @endif

    @stack('scripts')
    
</body>
</html>
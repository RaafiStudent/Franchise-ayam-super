<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Mitra') }}
        </h2>
    </x-slot>

    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <meta name="csrf-token" content="{{ csrf_token() }}"> 
    </head>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative shadow-md">
                <strong class="font-bold"><i class="fas fa-exclamation-triangle"></i> Gagal!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif
    </div>

    <div class="py-6 pb-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="bg-gradient-to-r from-red-700 to-red-500 rounded-2xl p-6 md:p-10 text-white shadow-lg mb-8 relative overflow-hidden">
                <div class="relative z-10">
                    <h1 class="text-3xl md:text-4xl font-bold mb-2">Halo, {{ Auth::user()->name }}! 👋</h1>
                    <p class="text-red-100 text-lg max-w-xl">Stok menipis? Pesan sekarang, proses cepat tanpa ribet.</p>
                </div>
                <i class="fas fa-shopping-basket absolute -bottom-4 -right-4 text-9xl text-white opacity-10 transform -rotate-12"></i>
            </div>

            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-800 border-l-4 border-red-600 pl-3">Katalog Bahan Baku</h3>
            </div>

            {{-- Diberi ID 'product-grid' agar mudah diperbarui JS --}}
            <div id="product-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                
                @php
                    $inCart = $cartItems->where('product_id', $product->id)->first();
                    $qty = $inCart ? $inCart->quantity : 0;
                @endphp

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col h-full relative group hover:shadow-lg transition duration-300">
                    
                    @if($product->stock <= 0)
                    <div class="absolute inset-0 bg-white/60 z-10 flex items-center justify-center">
                        <span class="bg-gray-800 text-white px-3 py-1 rounded-full text-sm font-bold shadow-md">Stok Habis</span>
                    </div>
                    @endif

                    <div class="aspect-square bg-gray-100 relative">
                        <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                        <div class="absolute top-2 right-2 bg-white/90 backdrop-blur px-2 py-1 rounded-lg text-xs font-bold text-gray-600 shadow-sm">
                            Stok: {{ $product->stock }}
                        </div>
                    </div>

                    <div class="p-4 flex-grow flex flex-col justify-between">
                        <div>
                            <h3 class="font-bold text-gray-800 line-clamp-2 leading-tight mb-1 text-base">{{ $product->name }}</h3>
                            <p class="text-xs text-gray-500 line-clamp-2 mb-3">{{ $product->description }}</p>
                        </div>
                        
                        <div class="flex items-center justify-between mt-2 pt-3 border-t border-dashed border-gray-200">
                            <div class="flex flex-col">
                                <span class="text-[10px] text-gray-400 font-semibold uppercase">Harga</span>
                                <span class="text-red-600 font-extrabold text-lg">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                            </div>
                            
                            <div class="product-action-container" data-id="{{ $product->id }}">
                                <button type="button" onclick="executeCartAction('/cart/add/{{ $product->id }}', 'POST')" 
                                        class="btn-add {{ $qty > 0 ? 'hidden' : '' }} bg-red-600 text-white border border-red-600 px-4 py-2 rounded-full text-xs font-bold hover:bg-red-700 hover:shadow-md transition flex items-center gap-1">
                                    <i class="fas fa-plus"></i> Pesan
                                </button>

                                <div class="btn-counter {{ $qty > 0 ? 'flex' : 'hidden' }} items-center bg-red-50 rounded-full px-1 border border-red-100 shadow-sm">
                                    <button type="button" onclick="executeCartAction('/cart/decrease/{{ $product->id }}', 'POST')" 
                                            class="w-8 h-8 flex items-center justify-center text-red-600 font-bold hover:bg-red-200 rounded-full transition">
                                        -
                                    </button>
                                    
                                    <span id="qty-{{ $product->id }}" class="text-sm font-bold text-red-900 w-6 text-center">{{ $qty }}</span>
                                    
                                    <button type="button" onclick="executeCartAction('/cart/add/{{ $product->id }}', 'POST')" 
                                            class="w-8 h-8 flex items-center justify-center text-red-600 font-bold hover:bg-red-200 rounded-full transition">
                                        +
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- STICKY FOOTER (Melayang) --}}
    <div id="cart-footer" class="{{ $cartItems->count() > 0 ? '' : 'hidden' }} fixed bottom-0 left-0 w-full bg-white border-t border-gray-200 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)] p-4 z-50 animate-bounce-in">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="bg-red-100 p-3 rounded-full text-red-600 relative">
                    <i class="fas fa-shopping-cart text-xl"></i>
                    <span id="total-qty-badge" class="absolute -top-1 -right-1 bg-red-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">
                        {{ $cartItems->sum('quantity') }}
                    </span>
                </div>
                <div class="flex flex-col">
                    <span class="text-gray-500 text-xs font-medium">Total Tagihan</span>
                    <span id="total-price-display" class="text-xl md:text-2xl font-extrabold text-gray-900">
                        Rp {{ number_format($totalPrice, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            <form action="{{ route('checkout.process') }}" method="POST">
                @csrf
                <button type="submit" class="bg-red-600 text-white font-bold py-3 px-6 md:px-10 rounded-full shadow-lg hover:bg-red-700 transition transform active:scale-95 flex items-center gap-2">
                    Bayar <i class="fas fa-arrow-right"></i>
                </button>
            </form>
        </div>
    </div>

    @if(Auth::user()->role == 'mitra')
        {{-- ======================================================== --}}
        {{-- LACI KERANJANG (SIDEBAR) --}}
        {{-- ======================================================== --}}
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
            
            {{-- Bagian List Item (Akan direplace JS saat klik tanpa refresh) --}}
            <div id="cart-items-container" class="flex-1 overflow-y-auto p-6 bg-slate-50 pb-32">
                @if($cartSidebar->count() > 0)
                    @foreach($cartSidebar as $item)
                        <div class="flex gap-4 bg-white p-4 rounded-2xl border border-slate-100 shadow-sm mb-4 relative group hover:border-slate-200 transition-colors">
                            <div class="w-20 h-20 rounded-xl bg-slate-50 overflow-hidden shrink-0 flex items-center justify-center text-slate-400">
                                <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1 flex flex-col justify-center">
                                <h4 class="text-sm font-bold text-slate-800 mb-1 leading-tight line-clamp-2">{{ $item->product->name }}</h4>
                                <p class="text-xs font-black text-red-600 mb-3">Rp {{ number_format($item->product->price, 0, ',', '.') }} <span class="text-slate-400 font-normal">/ Pack</span></p>
                                <div class="flex items-center gap-3 w-fit bg-slate-50 rounded-lg p-1 border border-slate-100">
                                    {{-- FIX: Tombol kurang menggunakan button biasa + JS, BUKAN Form --}}
                                    <button type="button" onclick="executeCartAction('{{ url('/cart/decrease/'.$item->product_id) }}', 'POST')" class="w-7 h-7 rounded bg-white border border-slate-200 text-slate-500 shadow-sm hover:text-red-600 flex items-center justify-center text-xs">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    
                                    <span class="text-xs font-bold text-slate-800 w-4 text-center">{{ $item->quantity }}</span>
                                    
                                    {{-- FIX: Tombol tambah menggunakan button biasa + JS, BUKAN Form --}}
                                    <button type="button" onclick="executeCartAction('{{ url('/cart/add/'.$item->product_id) }}', 'POST')" class="w-7 h-7 rounded bg-white border border-slate-200 text-slate-500 shadow-sm hover:text-red-600 flex items-center justify-center text-xs">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            
                            {{-- FIX: Tombol Hapus (Tong Sampah) menggunakan button biasa + JS, BUKAN Form --}}
                            <button type="button" onclick="executeCartAction('{{ route('cart.remove', $item->id) }}', 'DELETE')" class="m-0 p-0 absolute top-4 right-4 text-slate-300 hover:text-red-600 transition-colors">
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
                    <span class="text-2xl font-black text-slate-900 tracking-tight">Rp {{ number_format($totalSidebar, 0, ',', '.') }}</span>
                </div>
                
                <form action="{{ route('checkout.process') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full py-3.5 bg-[#b91c1c] hover:bg-[#991b1b] text-white rounded-xl font-bold text-sm flex items-center justify-center gap-2 shadow-md transition-all {{ $cartSidebar->count() == 0 ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $cartSidebar->count() == 0 ? 'disabled' : '' }}>
                        Lanjutkan Pembayaran <i class="fas fa-arrow-right ml-1"></i>
                    </button>
                </form>
            </div>
        </div>

        {{-- SCRIPT JAVASCRIPT AJAX TINGKAT TINGGI (SEAMLESS DOM REPLACEMENT) --}}
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

            // Fungsi Siluman: Bekerja dalam diam tanpa memuat ulang layar!
            async function executeCartAction(url, method) {
                try {
                    // 1. Eksekusi API secara diam-diam (Background)
                    let response = await fetch(url, {
                        method: method,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        }
                    });

                    if (response.ok) {
                        // 2. Ambil HTML halaman terbaru di background
                        let pageResponse = await fetch(window.location.href);
                        let pageHtml = await pageResponse.text();
                        let doc = new DOMParser().parseFromString(pageHtml, 'text/html');

                        // 3. TIMPA ELEMEN TANPA REFRESH (Sangat Mulus)
                        
                        // Update grid produk (angka di bawah foto)
                        let oldGrid = document.getElementById('product-grid');
                        let newGrid = doc.getElementById('product-grid');
                        if (oldGrid && newGrid) oldGrid.innerHTML = newGrid.innerHTML;

                        // Update isi laci keranjang
                        let oldCartItems = document.getElementById('cart-items-container');
                        let newCartItems = doc.getElementById('cart-items-container');
                        if (oldCartItems && newCartItems) oldCartItems.innerHTML = newCartItems.innerHTML;

                        // Update total harga di footer laci
                        let oldSidebarFooter = document.getElementById('cart-sidebar-footer');
                        let newSidebarFooter = doc.getElementById('cart-sidebar-footer');
                        if (oldSidebarFooter && newSidebarFooter) oldSidebarFooter.innerHTML = newSidebarFooter.innerHTML;

                        // Update Sticky Footer Utama
                        let oldFooter = document.getElementById('cart-footer');
                        let newFooter = doc.getElementById('cart-footer');
                        if (oldFooter && newFooter) {
                            oldFooter.innerHTML = newFooter.innerHTML;
                            oldFooter.className = newFooter.className;
                        }

                        // Update Badge Keranjang di Navigasi Atas
                        let oldBadgeBtn = document.querySelector('button[onclick="toggleOffcanvasCart()"]');
                        let newBadgeBtn = doc.querySelector('button[onclick="toggleOffcanvasCart()"]');
                        if (oldBadgeBtn && newBadgeBtn) oldBadgeBtn.innerHTML = newBadgeBtn.innerHTML;

                    }
                } catch (error) {
                    console.error('Error:', error);
                }
            }
        </script>
    @endif

    @stack('scripts')
</x-app-layout>
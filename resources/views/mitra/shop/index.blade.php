<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Mitra') }}
        </h2>
    </x-slot>

    {{-- Script Penting & FontAwesome --}}
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <meta name="csrf-token" content="{{ csrf_token() }}"> {{-- Token Keamanan untuk AJAX --}}
    </head>

    {{-- Pesan Error / Sukses (Flash Message) --}}
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
            
            {{-- HERO BANNER --}}
            <div class="bg-gradient-to-r from-red-700 to-red-500 rounded-2xl p-6 md:p-10 text-white shadow-lg mb-8 relative overflow-hidden">
                <div class="relative z-10">
                    <h1 class="text-3xl md:text-4xl font-bold mb-2">Halo, {{ Auth::user()->name }}! 👋</h1>
                    <p class="text-red-100 text-lg max-w-xl">Stok menipis? Pesan sekarang, proses cepat tanpa ribet.</p>
                </div>
                <i class="fas fa-shopping-basket absolute -bottom-4 -right-4 text-9xl text-white opacity-10 transform -rotate-12"></i>
            </div>

            {{-- GRID PRODUK --}}
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-800 border-l-4 border-red-600 pl-3">Katalog Bahan Baku</h3>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                
                {{-- Cek apakah produk ini ada di keranjang? --}}
                @php
                    $inCart = $cartItems->where('product_id', $product->id)->first();
                    $qty = $inCart ? $inCart->quantity : 0;
                @endphp

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col h-full relative group hover:shadow-lg transition duration-300">
                    
                    {{-- Stok Habis Overlay --}}
                    @if($product->stock <= 0)
                    <div class="absolute inset-0 bg-white/60 z-10 flex items-center justify-center">
                        <span class="bg-gray-800 text-white px-3 py-1 rounded-full text-sm font-bold shadow-md">Stok Habis</span>
                    </div>
                    @endif

                    {{-- Gambar --}}
                    <div class="aspect-square bg-gray-100 relative">
                        <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                        <div class="absolute top-2 right-2 bg-white/90 backdrop-blur px-2 py-1 rounded-lg text-xs font-bold text-gray-600 shadow-sm">
                            Stok: {{ $product->stock }}
                        </div>
                    </div>

                    {{-- Info Produk --}}
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
                            
                            {{-- LOGIKA TOMBOL CANGGIH (AJAX) --}}
                            <div class="product-action-container" data-id="{{ $product->id }}">
                                
                                {{-- Tombol "Pesan" (Muncul jika qty 0) --}}
                                <button onclick="updateCart({{ $product->id }}, 'add')" 
                                        class="btn-add {{ $qty > 0 ? 'hidden' : '' }} bg-red-600 text-white border border-red-600 px-4 py-2 rounded-full text-xs font-bold hover:bg-red-700 hover:shadow-md transition flex items-center gap-1">
                                    <i class="fas fa-plus"></i> Pesan
                                </button>

                                {{-- Counter (+ 1 -) (Muncul jika qty > 0) --}}
                                <div class="btn-counter {{ $qty > 0 ? 'flex' : 'hidden' }} items-center bg-red-50 rounded-full px-1 border border-red-100 shadow-sm">
                                    {{-- Tombol Kurang --}}
                                    <button onclick="updateCart({{ $product->id }}, 'decrease')" 
                                            class="w-8 h-8 flex items-center justify-center text-red-600 font-bold hover:bg-red-200 rounded-full transition">
                                        -
                                    </button>
                                    
                                    {{-- Angka Tengah --}}
                                    <span id="qty-{{ $product->id }}" class="text-sm font-bold text-red-900 w-6 text-center">{{ $qty }}</span>
                                    
                                    {{-- Tombol Tambah --}}
                                    <button onclick="updateCart({{ $product->id }}, 'add')" 
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
    {{-- Kita kasih ID 'cart-footer' biar bisa di-show/hide pakai JS --}}
    <div id="cart-footer" class="{{ $cartItems->count() > 0 ? '' : 'hidden' }} fixed bottom-0 left-0 w-full bg-white border-t border-gray-200 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)] p-4 z-50 animate-bounce-in">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="bg-red-100 p-3 rounded-full text-red-600 relative">
                    <i class="fas fa-shopping-cart text-xl"></i>
                    {{-- Badge Jumlah Item --}}
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

            {{-- Tombol Checkout ke Midtrans --}}
            <form action="{{ route('checkout.process') }}" method="POST">
                @csrf
                <button type="submit" class="bg-red-600 text-white font-bold py-3 px-6 md:px-10 rounded-full shadow-lg hover:bg-red-700 transition transform active:scale-95 flex items-center gap-2">
                    Bayar <i class="fas fa-arrow-right"></i>
                </button>
            </form>
        </div>
    </div>

    {{-- SCRIPT JAVASCRIPT AJAX (OTAKNYA ADA DI SINI) --}}
    <script>
        async function updateCart(productId, action) {
            // Tentukan URL berdasarkan aksi (add / decrease)
            let url = action === 'add' ? '/cart/add/' + productId : '/cart/decrease/' + productId;
            
            try {
                // Kirim request ke server tanpa refresh halaman (Fetch API)
                let response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                });

                let data = await response.json();

                if (data.status === 'success') {
                    // 1. Update Tampilan Footer
                    document.getElementById('total-price-display').innerText = 'Rp ' + data.total_price;
                    document.getElementById('total-qty-badge').innerText = data.total_qty;

                    // Show/Hide Footer berdasarkan jumlah item
                    let footer = document.getElementById('cart-footer');
                    if (data.total_qty > 0) {
                        footer.classList.remove('hidden');
                    } else {
                        footer.classList.add('hidden');
                    }

                    // 2. Update Angka di Produk Spesifik
                    let container = document.querySelector(`.product-action-container[data-id="${productId}"]`);
                    let btnAdd = container.querySelector('.btn-add');
                    let btnCounter = container.querySelector('.btn-counter');
                    let qtyDisplay = container.querySelector(`#qty-${productId}`);

                    // Ambil qty terbaru produk ini dari respon server
                    // Jika tidak ada di list cart_items, berarti qty = 0
                    let newQty = data.cart_items[productId] || 0;

                    // Update angka di tengah tombol
                    qtyDisplay.innerText = newQty;

                    // Logika Ganti Tombol (Pesan <-> Counter)
                    if (newQty > 0) {
                        btnAdd.classList.add('hidden');
                        btnCounter.classList.remove('hidden');
                        btnCounter.classList.add('flex');
                    } else {
                        btnAdd.classList.remove('hidden');
                        btnCounter.classList.add('hidden');
                        btnCounter.classList.remove('flex');
                    }
                }

            } catch (error) {
                console.error('Error:', error);
                alert('Gagal update keranjang. Cek koneksi internet!');
            }
        }
    </script>

</x-app-layout>
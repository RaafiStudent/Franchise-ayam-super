<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Halo, {{ Auth::user()->name }}! 👋
        </h2>
    </x-slot>

    <div class="py-6 pb-24"> 
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                
                @foreach($products as $product)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col h-full relative">
                    
                    @if($product->stock <= 0)
                    <div class="absolute inset-0 bg-white/60 z-10 flex items-center justify-center">
                        <span class="bg-gray-800 text-white px-3 py-1 rounded-full text-sm font-bold">Stok Habis</span>
                    </div>
                    @endif

                    <div class="aspect-square bg-gray-100 relative">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        <div class="absolute top-2 right-2 bg-white/90 backdrop-blur px-2 py-1 rounded-lg text-xs font-bold text-gray-600 shadow-sm">
                            Stok: {{ $product->stock }}
                        </div>
                    </div>

                    <div class="p-4 flex-grow flex flex-col justify-between">
                        <div>
                            <h3 class="font-bold text-gray-800 line-clamp-2 leading-tight mb-1">{{ $product->name }}</h3>
                            <p class="text-xs text-gray-500 line-clamp-2 mb-2">{{ $product->description }}</p>
                        </div>
                        
                        <div class="flex items-center justify-between mt-3">
                            <span class="text-red-600 font-extrabold text-lg">
                                Rp{{ number_format($product->price, 0, ',', '.') }}
                            </span>
                            
                            @php
                                // Cek apakah produk ini ada di keranjang user
                                $inCart = $cartItems->where('product_id', $product->id)->first();
                            @endphp

                            @if($inCart)
                                <div class="flex items-center bg-gray-100 rounded-full px-1">
                                    <form action="{{ route('cart.decrease', $inCart->id) }}" method="POST">
                                        @csrf
                                        <button class="w-7 h-7 flex items-center justify-center text-red-600 font-bold hover:bg-gray-200 rounded-full transition">-</button>
                                    </form>
                                    <span class="text-sm font-bold text-gray-800 w-6 text-center">{{ $inCart->quantity }}</span>
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                        @csrf
                                        <button class="w-7 h-7 flex items-center justify-center text-red-600 font-bold hover:bg-gray-200 rounded-full transition">+</button>
                                    </form>
                                </div>
                            @else
                                @if($product->stock > 0)
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                        @csrf
                                        <button class="bg-red-50 text-red-700 border border-red-200 px-3 py-1.5 rounded-full text-sm font-bold hover:bg-red-600 hover:text-white transition">
                                            + Tambah
                                        </button>
                                    </form>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>

    @if($cartItems->count() > 0)
    <div class="fixed bottom-0 left-0 w-full bg-white border-t border-gray-200 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)] p-4 z-50 animate-bounce-in">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            
            <div class="flex flex-col">
                <span class="text-gray-500 text-xs font-medium">{{ $cartItems->sum('quantity') }} Item dipilih</span>
                <span class="text-xl font-extrabold text-gray-900">Total: Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
            </div>

            <button onclick="alert('Fitur Checkout Midtrans akan kita buat di Tahap 7!')" class="bg-red-600 text-white font-bold py-3 px-8 rounded-full shadow-lg hover:bg-red-700 transition transform active:scale-95 flex items-center gap-2">
                Checkout <i class="fas fa-arrow-right"></i>
            </button>
        </div>
    </div>
    @endif

</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <h2 class="font-extrabold text-2xl text-slate-800 leading-tight tracking-tight">
                {{ __('Manajemen Produk / Stok') }}
            </h2>
            <a href="{{ route('admin.products.create') }}" class="bg-gradient-to-r from-red-600 to-red-500 hover:from-red-700 hover:to-red-600 text-white px-5 py-2.5 rounded-xl transition-all shadow-md shadow-red-500/30 font-bold text-sm flex items-center gap-2 active:scale-95 w-fit">
                <i class="fas fa-plus-circle"></i> Tambah Produk
            </a>
        </div>
    </x-slot>

    <div class="py-8 pb-20">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- ALERT SUCCESS PREMIUM --}}
            @if(session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-xl shadow-sm mb-6 flex items-center gap-3 animate-bounce-in">
                    <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center shrink-0">
                        <i class="fas fa-check text-emerald-600"></i>
                    </div>
                    <span class="font-bold text-sm">{{ session('success') }}</span>
                </div>
            @endif

            {{-- === PANEL FILTER & PENCARIAN (RAPI & MENYATU) === --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 mb-8">
                <form method="GET" action="{{ route('admin.products.index') }}" class="flex flex-col md:flex-row justify-between items-center gap-4">
                    
                    <div class="flex items-center gap-3 w-full md:w-auto bg-slate-50 px-4 py-2 rounded-xl border border-slate-100">
                        <i class="fas fa-boxes text-red-500"></i>
                        {{-- FIX: Menggunakan count() agar aman jika pagination mati --}}
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">
                            Total: {{ $products instanceof \Illuminate\Pagination\LengthAwarePaginator ? $products->total() : $products->count() }} Produk
                        </span>
                    </div>

                    {{-- Search Bar Premium --}}
                    <div class="flex w-full md:w-auto gap-2">
                        <div class="relative w-full md:w-80">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-search text-slate-400"></i>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama Produk..." class="w-full pl-10 pr-4 py-2.5 border border-slate-200 bg-slate-50 rounded-xl focus:ring-red-500 focus:border-red-500 text-sm font-medium text-slate-700 transition-all placeholder-slate-400">
                        </div>
                        <button type="submit" class="bg-slate-800 text-white px-6 py-2.5 rounded-xl hover:bg-slate-900 transition-all shadow-md font-bold text-sm flex items-center gap-2 active:scale-95 whitespace-nowrap">
                            Cari
                        </button>
                        @if(request('search'))
                            <a href="{{ route('admin.products.index') }}" class="bg-red-50 text-red-600 px-4 py-2.5 rounded-xl hover:bg-red-100 transition-all shadow-sm font-bold text-sm flex items-center justify-center active:scale-95">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- === DAFTAR PRODUK (CARD LAYOUT - DIKOTAKIN) === --}}
            <div class="grid grid-cols-1 gap-4">
                {{-- Judul Kolom (Desktop Only) --}}
                <div class="hidden md:grid grid-cols-12 gap-6 px-8 py-3 text-[10px] uppercase tracking-widest font-black text-slate-400">
                    <div class="col-span-2 text-center">Foto Produk</div>
                    <div class="col-span-4">Rincian & Deskripsi</div>
                    <div class="col-span-2 text-center">Harga Mitra</div>
                    <div class="col-span-2 text-center">Stok Gudang</div>
                    <div class="col-span-2 text-center">Kelola</div>
                </div>

                @forelse($products as $product)
                    <div class="bg-white rounded-[2rem] shadow-sm hover:shadow-md border border-slate-100 p-5 md:p-6 transition-all duration-300 flex flex-col md:grid md:grid-cols-12 gap-6 items-center relative group overflow-hidden">
                        
                        {{-- Garis dekorasi di samping --}}
                        <div class="absolute left-0 top-0 bottom-0 w-1 {{ $product->stock <= 10 ? 'bg-red-600' : 'bg-slate-200 group-hover:bg-red-600' }} transition-colors rounded-l-2xl"></div>

                        {{-- Kolom 1: Foto --}}
                        <div class="col-span-2 flex justify-center">
                            <div class="relative w-24 h-24">
                                <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover rounded-2xl border border-slate-100 shadow-sm group-hover:scale-105 transition-transform duration-500">
                                @if($product->stock <= 10)
                                    <div class="absolute -top-2 -right-2 bg-red-600 text-white text-[8px] font-black px-1.5 py-0.5 rounded-full animate-pulse shadow-sm">CRITICAL</div>
                                @endif
                            </div>
                        </div>

                        {{-- Kolom 2: Nama & Info --}}
                        <div class="col-span-4 w-full">
                            <h3 class="font-extrabold text-slate-800 text-lg leading-tight mb-1 group-hover:text-red-600 transition-colors">{{ $product->name }}</h3>
                            <p class="text-xs text-slate-400 font-medium line-clamp-2 italic">"{{ $product->description ?? 'Tidak ada deskripsi produk.' }}"</p>
                        </div>

                        {{-- Kolom 3: Harga --}}
                        <div class="col-span-2 w-full text-center">
                            <p class="text-[9px] md:hidden font-black text-slate-400 uppercase tracking-widest mb-1">Harga Mitra</p>
                            <span class="text-xl font-black text-red-600 tracking-tighter">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        </div>

                        {{-- Kolom 4: Stok --}}
                        <div class="col-span-2 w-full flex justify-center">
                            <div class="flex flex-col items-center">
                                <p class="text-[9px] md:hidden font-black text-slate-400 uppercase tracking-widest mb-2">Stok Gudang</p>
                                @if($product->stock <= 10)
                                    <span class="px-4 py-1.5 rounded-xl bg-red-50 text-red-600 border border-red-100 text-xs font-black shadow-sm flex items-center gap-2">
                                        <i class="fas fa-exclamation-triangle"></i> {{ $product->stock }} Pcs
                                    </span>
                                @else
                                    <span class="px-4 py-1.5 rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100 text-xs font-black shadow-sm flex items-center gap-2">
                                        <i class="fas fa-check-circle"></i> {{ $product->stock }} Pcs
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Kolom 5: Aksi --}}
                        <div class="col-span-2 w-full flex justify-center gap-2 border-t border-slate-50 pt-4 md:border-none md:pt-0">
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 hover:bg-amber-600 hover:text-white flex items-center justify-center transition-all shadow-sm" title="Edit Produk">
                                <i class="fas fa-edit text-sm"></i>
                            </a>
                            
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-10 h-10 rounded-xl bg-red-50 text-red-500 hover:bg-red-600 hover:text-white flex items-center justify-center transition-all shadow-sm" title="Hapus Produk">
                                    <i class="fas fa-trash-alt text-sm"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-[2rem] border border-slate-100 p-16 text-center shadow-sm">
                        <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-box-open text-4xl text-slate-300"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-700">Produk Tidak Ditemukan</h3>
                        <p class="text-sm text-slate-400 mt-1">Coba gunakan kata kunci lain atau tambahkan produk baru.</p>
                    </div>
                @endforelse
            </div>

            {{-- === PAGINATION LINKS === --}}
            @if(method_exists($products, 'links'))
            <div class="mt-8 bg-white p-4 rounded-2xl shadow-sm border border-slate-100">
                {{ $products->links() }}
            </div>
            @endif

        </div>
    </div>

    <style>
        .animate-bounce-in { animation: bounceIn 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards; }
        @keyframes bounceIn {
            0% { transform: scale(0.9); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
    </style>
</x-app-layout>
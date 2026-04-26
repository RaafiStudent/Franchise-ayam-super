<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-red-600 rounded-2xl flex items-center justify-center shadow-lg shadow-red-200">
                    <i class="fas fa-utensils text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="font-extrabold text-2xl text-slate-800 leading-tight tracking-tight">
                        {{ __('Katalog Menu Utama') }}
                    </h2>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest px-1">Manajemen Produk Tampil</p>
                </div>
            </div>
            
            <a href="{{ route('admin.menus.create') }}" class="bg-gradient-to-r from-red-700 to-red-600 hover:from-red-800 hover:to-red-700 text-white px-6 py-3.5 rounded-xl font-black text-xs uppercase tracking-widest shadow-lg shadow-red-200 transition-all active:scale-95 flex items-center gap-2 w-fit">
                <i class="fas fa-plus-circle text-sm"></i> Tambah Menu
            </a>
        </div>
    </x-slot>

    <div class="py-8 pb-24">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- ALERT SUCCESS PREMIUM --}}
            @if(session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-xl shadow-sm mb-8 flex items-center gap-3 animate-bounce-in">
                    <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center shrink-0">
                        <i class="fas fa-check text-emerald-600"></i>
                    </div>
                    <span class="font-bold text-sm">{{ session('success') }}</span>
                </div>
            @endif

            {{-- === GRID KARTU MENU === --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($menus as $menu)
                <div class="bg-white rounded-[2rem] border border-slate-100 shadow-[0_10px_40px_rgba(0,0,0,0.03)] overflow-hidden group hover:shadow-[0_20px_50px_rgba(0,0,0,0.08)] transition-all duration-500 flex flex-col">
                    
                    {{-- Bagian Gambar & Badge --}}
                    <div class="h-56 overflow-hidden relative bg-slate-50">
                        @if($menu->image)
                            <img src="{{ asset('storage/' . $menu->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                <i class="fas fa-image text-5xl"></i>
                            </div>
                        @endif
                        
                        {{-- Efek Gelap Transparan saat di-hover --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                        @if($menu->badge)
                            <span class="absolute top-4 right-4 bg-red-600 text-white text-[10px] font-black px-4 py-1.5 rounded-xl shadow-md uppercase tracking-widest z-10">
                                {{ $menu->badge }}
                            </span>
                        @endif
                    </div>

                    {{-- Bagian Konten --}}
                    <div class="p-6 md:p-8 flex-1 flex flex-col">
                        <h3 class="font-black text-slate-800 text-xl mb-2 line-clamp-1" title="{{ $menu->name }}">
                            {{ $menu->name }}
                        </h3>
                        <p class="text-sm text-slate-500 leading-relaxed line-clamp-2 mb-6 flex-1">
                            {{ $menu->description }}
                        </p>
                        
                        {{-- Bagian Footer Kartu (Likes & Tombol Aksi) --}}
                        <div class="flex items-center justify-between pt-5 border-t border-slate-100">
                            
                            {{-- Info Respon --}}
                            <div class="flex gap-3">
                                <div class="flex items-center gap-1.5" title="Total Disukai">
                                    <div class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-500 border border-emerald-100">
                                        <i class="fas fa-heart text-xs"></i>
                                    </div>
                                    <span class="text-xs font-black text-slate-700">{{ $menu->loves }}</span>
                                </div>
                                <div class="flex items-center gap-1.5" title="Total Tidak Disukai">
                                    <div class="w-8 h-8 rounded-full bg-rose-50 flex items-center justify-center text-rose-400 border border-rose-100">
                                        <i class="fas fa-heart-broken text-xs"></i>
                                    </div>
                                    <span class="text-xs font-black text-slate-700">{{ $menu->hates }}</span>
                                </div>
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="flex gap-2">
                                <a href="{{ route('admin.menus.edit', $menu->id) }}" 
                                   class="w-10 h-10 rounded-xl bg-slate-50 text-blue-600 hover:bg-blue-600 hover:text-white border border-slate-100 hover:border-blue-600 flex items-center justify-center transition-all shadow-sm active:scale-90" title="Edit Menu">
                                    <i class="fas fa-pen text-sm"></i>
                                </a>
                                <form action="{{ route('admin.menus.destroy', $menu->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus menu ini secara permanen?')">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="w-10 h-10 rounded-xl bg-slate-50 text-red-500 hover:bg-red-600 hover:text-white border border-slate-100 hover:border-red-600 flex items-center justify-center transition-all shadow-sm active:scale-90" title="Hapus Menu">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                    {{-- === TAMPILAN KOSONG (EMPTY STATE) === --}}
                    <div class="col-span-1 md:col-span-2 lg:col-span-3 bg-white rounded-[2.5rem] border border-slate-100 p-20 text-center shadow-sm">
                        <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-utensils text-5xl text-slate-300"></i>
                        </div>
                        <h3 class="text-2xl font-black text-slate-800 mb-2">Katalog Menu Masih Kosong</h3>
                        <p class="text-slate-500 mb-8 max-w-md mx-auto">Belum ada menu yang ditampilkan ke pengunjung. Silakan tambahkan menu pertama Anda untuk memikat pelanggan.</p>
                        <a href="{{ route('admin.menus.create') }}" class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-8 py-4 rounded-xl font-black text-sm uppercase tracking-widest shadow-lg shadow-red-200 transition-all active:scale-95">
                            <i class="fas fa-plus"></i> Tambah Menu Sekarang
                        </a>
                    </div>
                @endforelse
            </div>

            {{-- === PAGINATION === --}}
            @if($menus->hasPages())
                <div class="mt-10 bg-white p-4 rounded-2xl shadow-sm border border-slate-100">
                    {{ $menus->links() }}
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
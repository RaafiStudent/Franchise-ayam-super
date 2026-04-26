<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.products.index') }}" class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-slate-400 hover:text-red-600 shadow-sm transition-all border border-slate-100">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h2 class="font-extrabold text-2xl text-slate-800 leading-tight tracking-tight">
                {{ __('Update Data Produk') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10 pb-24">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.04)] border border-slate-100 overflow-hidden relative">
                {{-- Dekorasi Aksen Merah --}}
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-red-600 via-red-500 to-orange-400"></div>

                <div class="p-8 md:p-12">
                    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                            
                            {{-- KOLOM KIRI: FORM INPUT --}}
                            <div class="lg:col-span-7 space-y-6">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Nama Bahan Baku</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="fas fa-tag text-slate-300"></i>
                                        </div>
                                        <input type="text" name="name" value="{{ old('name', $product->name) }}" 
                                               class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border-transparent focus:border-red-500 focus:ring-4 focus:ring-red-500/10 rounded-2xl text-sm font-bold text-slate-700 transition-all placeholder-slate-400" 
                                               placeholder="Contoh: Ayam Marinasi (Pre-Cut)" required>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Deskripsi Singkat</label>
                                    <textarea name="description" rows="4" 
                                              class="w-full px-5 py-4 bg-slate-50 border-transparent focus:border-red-500 focus:ring-4 focus:ring-red-500/10 rounded-2xl text-sm font-medium text-slate-600 transition-all placeholder-slate-400" 
                                              placeholder="Jelaskan rincian produk ini...">{{ old('description', $product->description) }}</textarea>
                                </div>

                                <div class="grid grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Harga Mitra (Rp)</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                <span class="text-xs font-bold text-slate-300">Rp</span>
                                            </div>
                                            <input type="number" name="price" value="{{ old('price', $product->price) }}" 
                                                   class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border-transparent focus:border-red-500 focus:ring-4 focus:ring-red-500/10 rounded-2xl text-sm font-black text-red-600 transition-all" required>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Stok Gudang</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                <i class="fas fa-boxes text-slate-300"></i>
                                            </div>
                                            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" 
                                                   class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border-transparent focus:border-red-500 focus:ring-4 focus:ring-red-500/10 rounded-2xl text-sm font-bold text-slate-700 transition-all" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- KOLOM KANAN: MEDIA MANAGEMENT --}}
                            <div class="lg:col-span-5">
                                <div class="bg-slate-50 rounded-[2rem] p-6 border border-slate-100 h-full flex flex-col items-center justify-center text-center">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-6">Visual Produk</label>
                                    
                                    <div class="relative group mb-6">
                                        <div class="w-48 h-48 rounded-[2rem] overflow-hidden shadow-xl border-4 border-white">
                                            @if($product->image)
                                                <img id="previewImage" src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full bg-slate-200 flex items-center justify-center">
                                                    <i class="fas fa-image text-4xl text-slate-400"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center rounded-[2rem]">
                                            <i class="fas fa-camera text-white text-2xl"></i>
                                        </div>
                                    </div>

                                    <div class="w-full">
                                        <label for="image-upload" class="cursor-pointer inline-flex items-center gap-2 bg-white px-5 py-2.5 rounded-xl shadow-sm border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50 transition-all active:scale-95">
                                            <i class="fas fa-cloud-upload-alt text-red-500"></i> Ganti Foto Baru
                                        </label>
                                        <input id="image-upload" type="file" name="image" class="hidden" onchange="previewFile()">
                                        <p class="text-[10px] text-slate-400 mt-4 leading-relaxed">*Ukuran maksimal 2MB dengan format JPG atau PNG.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- TOMBOL AKSI --}}
                        <div class="flex items-center justify-end gap-4 mt-12 pt-8 border-t border-slate-50">
                            <a href="{{ route('admin.products.index') }}" class="text-xs font-bold text-slate-400 hover:text-slate-600 transition-colors uppercase tracking-widest px-6">
                                Batalkan
                            </a>
                            <button type="submit" class="bg-gradient-to-r from-red-700 to-red-600 hover:from-red-800 hover:to-red-700 text-white font-black text-xs uppercase tracking-[0.15em] py-4 px-10 rounded-2xl shadow-lg shadow-red-200 transition-all active:scale-95 flex items-center gap-3">
                                <span>Simpan Perubahan</span>
                                <i class="fas fa-check-circle"></i>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Script untuk Preview Foto Instan --}}
    <script>
        function previewFile() {
            const preview = document.getElementById('previewImage');
            const file = document.getElementById('image-upload').files[0];
            const reader = new FileReader();

            reader.onloadend = function () {
                preview.src = reader.result;
            }

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>

    <style>
        .animate-bounce-in { animation: bounceIn 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards; }
        @keyframes bounceIn {
            0% { transform: scale(0.9); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
    </style>
</x-app-layout>
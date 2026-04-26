<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.products.index') }}" class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-slate-400 hover:text-red-600 shadow-sm transition-all border border-slate-100">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h2 class="font-extrabold text-2xl text-slate-800 leading-tight tracking-tight">
                {{ __('Tambah Produk Baru') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10 pb-24">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.04)] border border-slate-100 overflow-hidden relative">
                {{-- Dekorasi Aksen Merah Shopee Style --}}
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-red-600 via-red-500 to-orange-400"></div>

                <div class="p-8 md:p-12">
                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                            
                            {{-- KOLOM KIRI: FORM INPUT DATA --}}
                            <div class="lg:col-span-7 space-y-6">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Nama Produk</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="fas fa-drumstick-bite text-slate-300"></i>
                                        </div>
                                        <input type="text" name="name" value="{{ old('name') }}" 
                                               class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border-transparent focus:border-red-500 focus:ring-4 focus:ring-red-500/10 rounded-2xl text-sm font-bold text-slate-700 transition-all placeholder-slate-400" 
                                               placeholder="Contoh: Ayam Marinasi (Pre-Cut)" required>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Deskripsi Produk</label>
                                    <textarea name="description" rows="4" 
                                              class="w-full px-5 py-4 bg-slate-50 border-transparent focus:border-red-500 focus:ring-4 focus:ring-red-500/10 rounded-2xl text-sm font-medium text-slate-600 transition-all placeholder-slate-400" 
                                              placeholder="Jelaskan spesifikasi atau rincian bahan baku ini...">{{ old('description') }}</textarea>
                                </div>

                                <div class="grid grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Harga Mitra (Rp)</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                <span class="text-xs font-bold text-slate-300">Rp</span>
                                            </div>
                                            <input type="number" name="price" value="{{ old('price') }}" 
                                                   class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border-transparent focus:border-red-500 focus:ring-4 focus:ring-red-500/10 rounded-2xl text-sm font-black text-red-600 transition-all" 
                                                   placeholder="0" required>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Stok Awal</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                <i class="fas fa-boxes text-slate-300"></i>
                                            </div>
                                            <input type="number" name="stock" value="{{ old('stock') }}" 
                                                   class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border-transparent focus:border-red-500 focus:ring-4 focus:ring-red-500/10 rounded-2xl text-sm font-bold text-slate-700 transition-all" 
                                                   placeholder="0" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- KOLOM KANAN: UPLOAD MEDIA --}}
                            <div class="lg:col-span-5">
                                <div class="bg-slate-50 rounded-[2.5rem] p-8 border border-slate-100 h-full flex flex-col items-center justify-center text-center">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-8">Preview Foto Produk</label>
                                    
                                    <div class="relative mb-8">
                                        <div class="w-56 h-56 rounded-[2.5rem] overflow-hidden shadow-2xl border-4 border-white bg-white flex items-center justify-center group">
                                            <img id="previewImage" src="#" class="w-full h-full object-cover hidden">
                                            <div id="placeholderIcon" class="flex flex-col items-center text-slate-300 transition-all group-hover:text-red-300">
                                                <i class="fas fa-cloud-upload-alt text-6xl mb-4"></i>
                                                <span class="text-[10px] font-black uppercase tracking-widest">Belum Ada Foto</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="w-full">
                                        <label for="image-upload" class="cursor-pointer inline-flex items-center gap-2 bg-white px-6 py-3 rounded-2xl shadow-sm border border-slate-200 text-xs font-bold text-slate-600 hover:text-red-600 hover:border-red-200 transition-all active:scale-95">
                                            <i class="fas fa-image text-red-500"></i> Pilih File Foto
                                        </label>
                                        <input id="image-upload" type="file" name="image" class="hidden" onchange="previewFile()" required>
                                        <p class="text-[10px] text-slate-400 mt-5 leading-relaxed font-medium">
                                            Gunakan foto produk dengan latar belakang bersih.<br>
                                            Maksimal ukuran file: <span class="font-bold text-slate-500">2MB</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- TOMBOL AKSI BAWAH --}}
                        <div class="flex items-center justify-end gap-5 mt-12 pt-8 border-t border-slate-50">
                            <a href="{{ route('admin.products.index') }}" class="text-xs font-bold text-slate-400 hover:text-slate-600 transition-colors uppercase tracking-widest px-4">
                                Batalkan
                            </a>
                            <button type="submit" class="bg-gradient-to-r from-red-700 to-red-600 hover:from-red-800 hover:to-red-700 text-white font-black text-xs uppercase tracking-[0.2em] py-4 px-12 rounded-2xl shadow-lg shadow-red-200 transition-all active:scale-95 flex items-center gap-3">
                                <span>Simpan Produk</span>
                                <i class="fas fa-check-circle"></i>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Script Pintar Preview Foto --}}
    <script>
        function previewFile() {
            const preview = document.getElementById('previewImage');
            const placeholder = document.getElementById('placeholderIcon');
            const file = document.getElementById('image-upload').files[0];
            const reader = new FileReader();

            reader.onloadend = function () {
                preview.src = reader.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = "";
                preview.classList.add('hidden');
                placeholder.classList.remove('hidden');
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
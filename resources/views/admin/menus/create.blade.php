<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.menus.index') }}" class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-slate-400 hover:text-red-600 shadow-sm transition-all border border-slate-100">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h2 class="font-extrabold text-2xl text-slate-800 leading-tight">
                {{ __('Tambah Menu Baru') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10 pb-24">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('admin.menus.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden relative">
                    <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-red-600 to-orange-400"></div>
                    
                    <div class="p-8 md:p-12">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            {{-- SISI KIRI: INPUT DATA --}}
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Nama Menu</label>
                                    <input type="text" name="name" placeholder="Contoh: Ayam Bakar Madu" required
                                           class="w-full px-5 py-3.5 bg-slate-50 border-transparent focus:border-red-500 focus:ring-4 focus:ring-red-500/10 rounded-2xl text-sm font-bold text-slate-700 transition-all">
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Label / Badge (Opsional)</label>
                                    <select name="badge" class="w-full px-5 py-3.5 bg-slate-50 border-transparent focus:border-red-500 focus:ring-4 focus:ring-red-500/10 rounded-2xl text-sm font-bold text-slate-700 transition-all appearance-none">
                                        <option value="">Tanpa Badge</option>
                                        <option value="NEW">NEW (Baru)</option>
                                        <option value="HEMAT">HEMAT</option>
                                        <option value="BEST SELLER">BEST SELLER</option>
                                        <option value="PEDAS">PEDAS</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Deskripsi Menu</label>
                                    <textarea name="description" rows="4" placeholder="Tuliskan komposisi atau keunggulan menu..." required
                                              class="w-full px-5 py-3.5 bg-slate-50 border-transparent focus:border-red-500 focus:ring-4 focus:ring-red-500/10 rounded-2xl text-sm font-bold text-slate-700 transition-all"></textarea>
                                </div>
                            </div>

                            {{-- SISI KANAN: UPLOAD GAMBAR --}}
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Foto Menu Produk</label>
                                    <div class="relative group">
                                        <input type="file" name="image" id="image_input" required onchange="previewImage()"
                                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                        <div id="image_placeholder" class="w-full h-64 bg-slate-50 border-2 border-dashed border-slate-200 rounded-[2rem] flex flex-col items-center justify-center group-hover:bg-slate-100 transition-all overflow-hidden">
                                            <img id="image_preview" src="#" class="w-full h-full object-cover hidden">
                                            <div id="placeholder_content" class="text-center p-6">
                                                <i class="fas fa-cloud-upload-alt text-4xl text-slate-300 mb-3"></i>
                                                <p class="text-xs font-bold text-slate-400 uppercase">Klik untuk upload foto</p>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-[9px] text-slate-400 mt-3 italic">*Gunakan rasio 4:3 dengan format JPG/PNG (Maks 2MB)</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-5 mt-12 pt-8 border-t border-slate-50">
                            <a href="{{ route('admin.menus.index') }}" class="text-xs font-bold text-slate-400 uppercase tracking-widest px-4">Batal</a>
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-black text-xs uppercase tracking-[0.2em] py-4 px-12 rounded-2xl shadow-lg shadow-red-200 transition-all active:scale-95">
                                Daftarkan Menu
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewImage() {
            const input = document.getElementById('image_input');
            const preview = document.getElementById('image_preview');
            const placeholder = document.getElementById('placeholder_content');
            const file = input.files[0];
            const reader = new FileReader();

            reader.onloadend = function () {
                preview.src = reader.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }
            if (file) { reader.readAsDataURL(file); }
        }
    </script>
</x-app-layout>
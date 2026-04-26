<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.menus.index') }}" class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-slate-400 hover:text-red-600 shadow-sm transition-all border border-slate-100">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h2 class="font-extrabold text-2xl text-slate-800 leading-tight">
                {{ __('Edit Detail Menu') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10 pb-24">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('admin.menus.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden relative">
                    <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-600 to-indigo-400"></div>
                    
                    <div class="p-8 md:p-12">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Nama Menu</label>
                                    <input type="text" name="name" value="{{ old('name', $menu->name) }}" required
                                           class="w-full px-5 py-3.5 bg-slate-50 border-transparent focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 rounded-2xl text-sm font-bold text-slate-700 transition-all">
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Label / Badge</label>
                                    <select name="badge" class="w-full px-5 py-3.5 bg-slate-50 border-transparent focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 rounded-2xl text-sm font-bold text-slate-700 transition-all appearance-none">
                                        <option value="" {{ $menu->badge == '' ? 'selected' : '' }}>Tanpa Badge</option>
                                        <option value="NEW" {{ $menu->badge == 'NEW' ? 'selected' : '' }}>NEW (Baru)</option>
                                        <option value="HEMAT" {{ $menu->badge == 'HEMAT' ? 'selected' : '' }}>HEMAT</option>
                                        <option value="BEST SELLER" {{ $menu->badge == 'BEST SELLER' ? 'selected' : '' }}>BEST SELLER</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Deskripsi Menu</label>
                                    <textarea name="description" rows="4" required
                                              class="w-full px-5 py-3.5 bg-slate-50 border-transparent focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 rounded-2xl text-sm font-bold text-slate-700 transition-all">{{ old('description', $menu->description) }}</textarea>
                                </div>
                            </div>

                            <div class="space-y-6 text-center">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 text-left">Update Foto Menu</label>
                                <div class="relative group">
                                    <input type="file" name="image" id="image_edit" onchange="previewEdit()"
                                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                    <div class="w-full h-64 bg-slate-50 border-2 border-dashed border-slate-200 rounded-[2rem] overflow-hidden">
                                        <img id="edit_preview" src="{{ asset('storage/' . $menu->image) }}" class="w-full h-full object-cover">
                                    </div>
                                </div>
                                <p class="text-[9px] text-blue-600 font-bold italic">Kosongkan jika tidak ingin mengganti foto lama</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-5 mt-12 pt-8 border-t border-slate-50">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-black text-xs uppercase tracking-[0.2em] py-4 px-12 rounded-2xl shadow-lg shadow-blue-100 transition-all active:scale-95">
                                Update Data Menu
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewEdit() {
            const input = document.getElementById('image_edit');
            const preview = document.getElementById('edit_preview');
            const file = input.files[0];
            const reader = new FileReader();
            reader.onloadend = function () { preview.src = reader.result; }
            if (file) { reader.readAsDataURL(file); }
        }
    </script>
</x-app-layout>
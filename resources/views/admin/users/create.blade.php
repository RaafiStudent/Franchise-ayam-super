<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.users.index') }}" class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-slate-400 hover:text-red-600 shadow-sm transition-all border border-slate-100">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h2 class="font-extrabold text-2xl text-slate-800 leading-tight tracking-tight">
                {{ __('Tambah Pengguna Baru') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10 pb-24" x-data="{ role: 'mitra' }">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.04)] border border-slate-100 overflow-hidden relative">
                    {{-- Aksen Merah Gradient --}}
                    <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-red-600 via-red-500 to-orange-400"></div>

                    <div class="p-8 md:p-12">
                        {{-- BAGIAN 1: INFORMASI LOGIN DASAR --}}
                        <div class="mb-12">
                            <h3 class="text-sm font-black text-red-600 uppercase tracking-[0.2em] mb-8 flex items-center gap-2">
                                <span class="w-8 h-px bg-red-200"></span>
                                01. Informasi Akun
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Nama Lengkap</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="fas fa-user text-slate-300"></i>
                                        </div>
                                        <input type="text" name="name" value="{{ old('name') }}" required
                                               class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border-transparent focus:border-red-500 focus:ring-4 focus:ring-red-500/10 rounded-2xl text-sm font-bold text-slate-700 transition-all placeholder-slate-400" 
                                               placeholder="Masukkan nama lengkap...">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Alamat Email</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="fas fa-envelope text-slate-300"></i>
                                        </div>
                                        <input type="email" name="email" value="{{ old('email') }}" required
                                               class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border-transparent focus:border-red-500 focus:ring-4 focus:ring-red-500/10 rounded-2xl text-sm font-bold text-slate-700 transition-all placeholder-slate-400" 
                                               placeholder="contoh@ayamsuper.com">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Hak Akses (Role)</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="fas fa-user-tag text-slate-300"></i>
                                        </div>
                                        <select name="role" x-model="role" required
                                                class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border-transparent focus:border-red-500 focus:ring-4 focus:ring-red-500/10 rounded-2xl text-sm font-bold text-slate-700 transition-all appearance-none">
                                            <option value="mitra">Mitra Cabang</option>
                                            <option value="admin">Administrator</option>
                                            <option value="owner">Owner / Eksekutif</option>
                                        </select>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Status Awal</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="fas fa-toggle-on text-slate-300"></i>
                                        </div>
                                        <select name="status" required
                                                class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border-transparent focus:border-red-500 focus:ring-4 focus:ring-red-500/10 rounded-2xl text-sm font-bold text-slate-700 transition-all appearance-none">
                                            <option value="active">Langsung Aktif</option>
                                            <option value="pending">Menunggu Verifikasi</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- BAGIAN 2: KELENGKAPAN DATA MITRA (HANYA TAMPIL JIKA ROLE MITRA) --}}
                        <div x-show="role === 'mitra'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="mb-12 bg-slate-50 rounded-[2rem] p-8 border border-slate-100 relative overflow-hidden">
                            
                            <div class="absolute right-0 top-0 p-8 opacity-[0.03] pointer-events-none">
                                <i class="fas fa-store text-9xl text-slate-900"></i>
                            </div>

                            <h3 class="text-sm font-black text-red-600 uppercase tracking-[0.2em] mb-8 flex items-center gap-2">
                                <span class="w-8 h-px bg-red-200"></span>
                                02. Kelengkapan Data Mitra
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 relative z-10">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">No. Handphone (WhatsApp)</label>
                                    <input type="text" name="no_hp" 
                                           class="w-full px-5 py-3.5 bg-white border-transparent focus:border-red-500 focus:ring-4 focus:ring-red-500/10 rounded-2xl text-sm font-bold text-slate-700 shadow-sm" 
                                           placeholder="Contoh: 08123456789">
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Upload Foto KTP</label>
                                    <div class="relative">
                                        <input type="file" name="ktp_image" 
                                               class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-6 file:rounded-xl file:border-0 file:text-xs file:font-black file:bg-red-50 file:text-red-700 hover:file:bg-red-100 transition-all cursor-pointer bg-white p-1 rounded-2xl shadow-sm border border-slate-100">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Provinsi</label>
                                    <input type="text" name="provinsi" 
                                           class="w-full px-5 py-3.5 bg-white border-transparent focus:border-red-500 focus:ring-4 focus:ring-red-500/10 rounded-2xl text-sm font-bold text-slate-700 shadow-sm" 
                                           placeholder="Contoh: Jawa Tengah">
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Kota / Kabupaten</label>
                                    <input type="text" name="kota" 
                                           class="w-full px-5 py-3.5 bg-white border-transparent focus:border-red-500 focus:ring-4 focus:ring-red-500/10 rounded-2xl text-sm font-bold text-slate-700 shadow-sm" 
                                           placeholder="Contoh: Semarang">
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Alamat Lengkap Outlet</label>
                                    <textarea name="alamat_lengkap" rows="3" 
                                              class="w-full px-5 py-3.5 bg-white border-transparent focus:border-red-500 focus:ring-4 focus:ring-red-500/10 rounded-2xl text-sm font-bold text-slate-700 shadow-sm placeholder-slate-300" 
                                              placeholder="Tuliskan alamat detail cabang di sini..."></textarea>
                                </div>
                            </div>
                        </div>

                        {{-- BAGIAN 3: KEAMANAN PASSWORD --}}
                        <div>
                            <h3 class="text-sm font-black text-red-600 uppercase tracking-[0.2em] mb-8 flex items-center gap-2">
                                <span class="w-8 h-px bg-red-200"></span>
                                03. Keamanan Akun
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Password</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="fas fa-lock text-slate-300"></i>
                                        </div>
                                        <input type="password" name="password" required
                                               class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border-transparent focus:border-red-500 focus:ring-4 focus:ring-red-500/10 rounded-2xl text-sm font-bold text-slate-700 transition-all placeholder-slate-400" 
                                               placeholder="Minimal 8 karakter">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Konfirmasi Password</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="fas fa-shield-alt text-slate-300"></i>
                                        </div>
                                        <input type="password" name="password_confirmation" required
                                               class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border-transparent focus:border-red-500 focus:ring-4 focus:ring-red-500/10 rounded-2xl text-sm font-bold text-slate-700 transition-all placeholder-slate-400" 
                                               placeholder="Ulangi password di atas">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- TOMBOL AKSI --}}
                        <div class="flex items-center justify-end gap-5 mt-16 pt-8 border-t border-slate-50">
                            <a href="{{ route('admin.users.index') }}" class="text-xs font-bold text-slate-400 hover:text-slate-600 transition-colors uppercase tracking-widest px-4">
                                Batalkan
                            </a>
                            <button type="submit" class="bg-gradient-to-r from-red-700 to-red-600 hover:from-red-800 hover:to-red-700 text-white font-black text-xs uppercase tracking-[0.2em] py-4 px-12 rounded-2xl shadow-lg shadow-red-200 transition-all active:scale-95 flex items-center gap-3">
                                <span>Daftarkan Pengguna</span>
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
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
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.users.index') }}" class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-slate-400 hover:text-red-600 shadow-sm transition-all border border-slate-100">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h2 class="font-extrabold text-2xl text-slate-800 leading-tight tracking-tight">
                {{ __('Update Data Pengguna') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10 pb-24" x-data="{ role: '{{ $user->role }}', showConfirmModal: false }">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            {{-- ALERT ERROR PINTAR: Sekarang dia akan memberitahu APANYA yang salah --}}
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-5 rounded-xl shadow-sm animate-bounce-in">
                    <div class="flex items-center gap-3 mb-3">
                        <i class="fas fa-exclamation-triangle text-red-600 text-lg"></i>
                        <h3 class="text-sm font-black text-red-800 uppercase tracking-widest">Gagal Menyimpan! Detail Kesalahan:</h3>
                    </div>
                    <ul class="list-disc ml-9 text-xs text-red-700 font-bold space-y-1.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="formUpdateUser" action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data" @submit.prevent="showConfirmModal = true">
                @csrf
                @method('PUT')

                {{-- Trik Rahasia: Input tersembunyi agar role tetap terkirim meski select-nya disabled --}}
                <input type="hidden" name="role" value="{{ $user->role }}">

                <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.04)] border border-slate-100 overflow-hidden relative">
                    <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-red-600 via-red-500 to-orange-400"></div>

                    <div class="p-8 md:p-12">
                        
                        {{-- BAGIAN 1: PROFIL DASAR --}}
                        <div class="mb-12">
                            <h3 class="text-sm font-black text-red-600 uppercase tracking-[0.2em] mb-8 flex items-center gap-2">
                                <span class="w-8 h-px bg-red-200"></span>
                                01. Informasi Akun
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="md:col-span-2">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Nama Lengkap</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="fas fa-user text-slate-300"></i>
                                        </div>
                                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                               class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border-transparent focus:border-red-500 focus:ring-4 focus:ring-red-500/10 rounded-2xl text-sm font-bold text-slate-700 transition-all">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Alamat Email</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="fas fa-envelope text-slate-300"></i>
                                        </div>
                                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                               class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border-transparent focus:border-red-500 focus:ring-4 focus:ring-red-500/10 rounded-2xl text-sm font-bold text-slate-700 transition-all">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Hak Akses (Role)</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="fas fa-lock text-red-400"></i>
                                        </div>
                                        <select disabled class="w-full pl-11 pr-4 py-3.5 bg-slate-100 border-transparent rounded-2xl text-sm font-bold text-slate-400 cursor-not-allowed appearance-none">
                                            <option value="mitra" {{ $user->role == 'mitra' ? 'selected' : '' }}>Mitra Cabang</option>
                                            <option value="owner" {{ $user->role == 'owner' ? 'selected' : '' }}>Owner (Pemilik)</option>
                                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrator</option>
                                        </select>
                                    </div>
                                    <p class="text-[9px] text-red-500 mt-2 font-bold ml-1 italic">*Role tidak dapat diubah demi validitas data.</p>
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Status Keaktifan</label>
                                    <div class="flex gap-4">
                                        @foreach(['active' => 'Aktif', 'pending' => 'Menunggu', 'banned' => 'Blokir'] as $val => $label)
                                            <label class="flex-1 cursor-pointer group">
                                                <input type="radio" name="status" value="{{ $val }}" class="hidden peer" {{ $user->status == $val ? 'checked' : '' }}>
                                                <div class="text-center py-3 rounded-2xl border-2 border-slate-50 bg-slate-50 text-slate-400 font-bold text-xs transition-all peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:text-red-600 group-hover:bg-slate-100">
                                                    {{ $label }}
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- BAGIAN 2: DATA MITRA --}}
                        <div x-show="role === 'mitra'" x-transition class="mb-12 bg-slate-50 rounded-[2rem] p-8 border border-slate-100 relative">
                            <h3 class="text-sm font-black text-red-600 uppercase tracking-[0.2em] mb-8 flex items-center gap-2">
                                <span class="w-8 h-px bg-red-200"></span>
                                02. Detail Lokasi & KTP Mitra
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">No. WhatsApp</label>
                                    <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}"
                                           class="w-full px-5 py-3.5 bg-white border-transparent focus:border-red-500 focus:ring-4 focus:ring-red-500/10 rounded-2xl text-sm font-bold text-slate-700 shadow-sm">
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Update Foto KTP</label>
                                    <input type="file" name="ktp_image" id="ktp_input" onchange="previewKTP()"
                                           class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-6 file:rounded-xl file:border-0 file:text-xs file:font-black file:bg-red-50 file:text-red-700 hover:file:bg-red-100 transition-all cursor-pointer bg-white p-1 rounded-2xl shadow-sm border border-slate-100">
                                </div>

                                <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="bg-white p-4 rounded-2xl border border-slate-200 flex flex-col items-center justify-center">
                                        <p class="text-[9px] font-black text-slate-400 uppercase mb-3">Foto KTP Saat Ini</p>
                                        @if($user->ktp_image)
                                            <img src="{{ asset('storage/' . $user->ktp_image) }}" class="h-32 w-full object-cover rounded-xl shadow-sm border">
                                        @else
                                            <div class="h-32 w-full bg-slate-100 rounded-xl flex items-center justify-center text-slate-300">
                                                <i class="fas fa-image text-3xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="bg-white p-4 rounded-2xl border border-slate-200 flex flex-col items-center justify-center">
                                        <p class="text-[9px] font-black text-slate-400 uppercase mb-3">Preview Foto Baru</p>
                                        <img id="ktp_preview" src="#" class="h-32 w-full object-cover rounded-xl shadow-sm border hidden">
                                        <div id="ktp_placeholder" class="h-32 w-full bg-slate-100 rounded-xl flex items-center justify-center text-slate-300 border-2 border-dashed border-slate-200">
                                            <p class="text-[10px] font-bold">Belum Ada Perubahan</p>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Provinsi</label>
                                    <input type="text" name="provinsi" value="{{ old('provinsi', $user->provinsi) }}"
                                           class="w-full px-5 py-3.5 bg-white border-transparent focus:border-red-500 focus:ring-4 focus:ring-red-500/10 rounded-2xl text-sm font-bold text-slate-700 shadow-sm">
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Kota / Kabupaten</label>
                                    <input type="text" name="kota" value="{{ old('kota', $user->kota) }}"
                                           class="w-full px-5 py-3.5 bg-white border-transparent focus:border-red-500 focus:ring-4 focus:ring-red-500/10 rounded-2xl text-sm font-bold text-slate-700 shadow-sm">
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Alamat Lengkap</label>
                                    <textarea name="alamat_lengkap" rows="3" 
                                              class="w-full px-5 py-3.5 bg-white border-transparent focus:border-red-500 focus:ring-4 focus:ring-red-500/10 rounded-2xl text-sm font-bold text-slate-700 shadow-sm">{{ old('alamat_lengkap', $user->alamat_lengkap) }}</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- BAGIAN 3: KEAMANAN --}}
                        <div>
                            <h3 class="text-sm font-black text-red-600 uppercase tracking-[0.2em] mb-8 flex items-center gap-2">
                                <span class="w-8 h-px bg-red-200"></span>
                                03. Keamanan Password
                            </h3>
                            
                            <div class="bg-amber-50 border-l-4 border-amber-400 p-4 rounded-r-2xl mb-8">
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-info-circle text-amber-500"></i>
                                    <p class="text-xs font-bold text-amber-800">Biarkan kosong jika Anda tidak ingin mengubah kata sandi pengguna ini.</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div x-data="{ showPw1: false }">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Password Baru</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="fas fa-lock text-slate-300"></i>
                                        </div>
                                        <input :type="showPw1 ? 'text' : 'password'" name="password" 
                                               class="w-full pl-11 pr-12 py-3.5 bg-slate-50 border-transparent focus:border-red-500 focus:ring-4 focus:ring-red-500/10 rounded-2xl text-sm font-bold text-slate-700 transition-all placeholder-slate-300" placeholder="Minimal 8 karakter">
                                        <button type="button" @click="showPw1 = !showPw1" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-red-600 transition-colors focus:outline-none">
                                            <i class="fas" :class="showPw1 ? 'fa-eye-slash' : 'fa-eye'"></i>
                                        </button>
                                    </div>
                                </div>

                                <div x-data="{ showPw2: false }">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Konfirmasi Password Baru</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="fas fa-shield-alt text-slate-300"></i>
                                        </div>
                                        <input :type="showPw2 ? 'text' : 'password'" name="password_confirmation" 
                                               class="w-full pl-11 pr-12 py-3.5 bg-slate-50 border-transparent focus:border-red-500 focus:ring-4 focus:ring-red-500/10 rounded-2xl text-sm font-bold text-slate-700 transition-all placeholder-slate-300" placeholder="Ulangi password di atas">
                                        <button type="button" @click="showPw2 = !showPw2" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-red-600 transition-colors focus:outline-none">
                                            <i class="fas" :class="showPw2 ? 'fa-eye-slash' : 'fa-eye'"></i>
                                        </button>
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
                                <span>Simpan Perubahan</span>
                                <i class="fas fa-check-circle"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            
            {{-- MODAL KONFIRMASI --}}
            <div x-show="showConfirmModal" x-cloak class="fixed inset-0 z-[150] flex items-center justify-center p-4">
                <div x-show="showConfirmModal" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"
                     @click="showConfirmModal = false">
                </div>

                <div x-show="showConfirmModal"
                     x-transition:enter="transition ease-out duration-300 transform"
                     x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                     x-transition:leave="transition ease-in duration-200 transform"
                     x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                     x-transition:leave-end="opacity-0 translate-y-8 scale-95"
                     class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden p-8 text-center"
                >
                    <div class="w-20 h-20 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center text-4xl mx-auto mb-6 shadow-inner">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    
                    <h3 class="text-xl font-black text-slate-800 mb-2">Simpan Perubahan Data?</h3>
                    <p class="text-sm text-slate-500 mb-8 font-medium leading-relaxed">
                        Anda akan menyimpan pembaruan untuk pengguna <span class="font-bold text-red-600">{{ $user->name }}</span> yang berstatus sebagai <span class="font-bold text-slate-700 uppercase">{{ $user->role }}</span>. Pastikan semua data, status keaktifan, atau password baru (jika ada) sudah benar.
                    </p>
                    
                    <div class="flex items-center gap-4">
                        <button @click="showConfirmModal = false" type="button" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold py-3.5 rounded-xl transition-colors">
                            Batal
                        </button>
                        <button onclick="document.getElementById('formUpdateUser').submit()" type="button" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-red-200 transition-all active:scale-95">
                            Ya, Simpan!
                        </button>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <script>
        function previewKTP() {
            const input = document.getElementById('ktp_input');
            const preview = document.getElementById('ktp_preview');
            const placeholder = document.getElementById('ktp_placeholder');
            const file = input.files[0];
            const reader = new FileReader();

            reader.onloadend = function () {
                preview.src = reader.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
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
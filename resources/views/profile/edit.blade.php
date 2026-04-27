<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-slate-800 rounded-xl flex items-center justify-center shadow-lg">
                <i class="fas fa-user-shield text-white text-sm"></i>
            </div>
            <h2 class="font-extrabold text-2xl text-slate-800 leading-tight">
                {{ __('Pengaturan Akun & Keamanan') }}
            </h2>
        </div>
    </x-slot>

    {{-- Kita bungkus seluruh halaman dengan Alpine.js untuk fitur Modal Konfirmasi --}}
    <div class="py-12 pb-24" x-data="{ showConfirmModal: false }">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- ALERT SUKSES --}}
            @if (session('status') === 'password-updated')
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" 
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-4"
                     class="bg-emerald-500 text-white p-4 rounded-2xl shadow-lg flex items-center gap-3">
                    <i class="fas fa-check-circle text-xl animate-bounce"></i>
                    <span class="font-bold text-sm">Berhasil! Password Anda telah diperbarui secara aman.</span>
                </div>
            @endif

            {{-- BAGIAN 1: INFORMASI PROFIL (DIKUNCI / READ-ONLY) --}}
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden relative">
                <div class="p-8 md:p-10">
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl shadow-sm">
                                <i class="fas fa-id-card"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-black text-slate-800 uppercase tracking-tight">Informasi Dasar</h3>
                                <p class="text-xs font-bold text-slate-400">Data pendaftaran resmi Anda (Hanya untuk dibaca).</p>
                            </div>
                        </div>
                        <div class="bg-slate-100 text-slate-500 text-[10px] font-bold px-3 py-1.5 rounded-lg border border-slate-200 uppercase flex items-center gap-1.5">
                            <i class="fas fa-lock"></i> Terkunci
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Nama Lengkap Terdaftar</label>
                            <div class="relative">
                                <input type="text" value="{{ $user->name }}" disabled class="w-full px-5 py-3.5 bg-slate-100 border-transparent rounded-2xl text-sm font-bold text-slate-500 cursor-not-allowed opacity-80">
                                <i class="fas fa-ban absolute right-5 top-1/2 -translate-y-1/2 text-slate-300"></i>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Alamat Email / Login</label>
                            <div class="relative">
                                <input type="email" value="{{ $user->email }}" disabled class="w-full px-5 py-3.5 bg-slate-100 border-transparent rounded-2xl text-sm font-bold text-slate-500 cursor-not-allowed opacity-80">
                                <i class="fas fa-ban absolute right-5 top-1/2 -translate-y-1/2 text-slate-300"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6 inline-flex items-center gap-2 bg-indigo-50/50 px-4 py-2.5 rounded-xl border border-indigo-50">
                        <i class="fas fa-info-circle text-indigo-500 text-sm"></i>
                        <p class="text-xs font-medium text-slate-500">
                            Penting: Untuk merubah nama identitas atau email login, Anda harus melapor ke <span class="font-bold text-slate-700">Administrator Pusat</span>.
                        </p>
                    </div>
                </div>
            </div>

            {{-- BAGIAN 2: UPDATE PASSWORD (KHUSUS KEAMANAN) --}}
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden relative">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-red-600 to-orange-400"></div>
                <div class="p-8 md:p-10">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-12 h-12 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center text-xl shadow-sm">
                            <i class="fas fa-key"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-slate-800 uppercase tracking-tight">Keamanan Akun</h3>
                            <p class="text-xs font-bold text-slate-400">Pastikan Anda menggunakan kombinasi huruf dan angka.</p>
                        </div>
                    </div>

                    {{-- Form menggunakan x-ref untuk di-submit via pop-up konfirmasi --}}
                    <form method="post" action="{{ route('profile.password.update') }}" class="space-y-6" x-ref="formPassword">
                        @csrf
                        @method('put')

                        <div class="space-y-6">
                            
                            {{-- Input Password Lama dengan Ikon Mata --}}
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Password Saat Ini</label>
                                <div class="relative" x-data="{ show: false }">
                                    <input :type="show ? 'text' : 'password'" name="current_password" required placeholder="Masukkan password lama Anda" class="w-full pl-5 pr-12 py-3.5 bg-slate-50 border-transparent focus:border-red-500 focus:ring-4 focus:ring-red-500/10 rounded-2xl text-sm font-bold text-slate-700 transition-all">
                                    <button type="button" @click="show = !show" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-red-600 focus:outline-none transition-colors p-1">
                                        <i class="fas" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                                    </button>
                                </div>
                                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-slate-100">
                                
                                {{-- Input Password Baru dengan Ikon Mata --}}
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Password Baru</label>
                                    <div class="relative" x-data="{ show: false }">
                                        <input :type="show ? 'text' : 'password'" name="password" required placeholder="Minimal 8 karakter" class="w-full pl-5 pr-12 py-3.5 bg-slate-50 border-transparent focus:border-red-500 focus:ring-4 focus:ring-red-500/10 rounded-2xl text-sm font-bold text-slate-700 transition-all">
                                        <button type="button" @click="show = !show" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-red-600 focus:outline-none transition-colors p-1">
                                            <i class="fas" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                                        </button>
                                    </div>
                                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                                </div>

                                {{-- Input Konfirmasi Password dengan Ikon Mata --}}
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Ulangi Password Baru</label>
                                    <div class="relative" x-data="{ show: false }">
                                        <input :type="show ? 'text' : 'password'" name="password_confirmation" required placeholder="Ketik ulang password baru" class="w-full pl-5 pr-12 py-3.5 bg-slate-50 border-transparent focus:border-red-500 focus:ring-4 focus:ring-red-500/10 rounded-2xl text-sm font-bold text-slate-700 transition-all">
                                        <button type="button" @click="show = !show" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-red-600 focus:outline-none transition-colors p-1">
                                            <i class="fas" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                                        </button>
                                    </div>
                                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                                </div>

                            </div>
                        </div>

                        <div class="flex justify-end pt-6 border-t border-slate-50">
                            {{-- Tombol ini tidak langsung submit, melainkan membuka modal konfirmasi --}}
                            <button type="button" @click="showConfirmModal = true" class="bg-red-600 hover:bg-red-700 text-white font-black text-[10px] uppercase tracking-widest py-4 px-10 rounded-2xl shadow-lg shadow-red-100 transition-all active:scale-95 flex items-center gap-2">
                                <i class="fas fa-save"></i> Perbarui Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

        {{-- ======================================================== --}}
        {{-- MODAL KONFIRMASI GANTI PASSWORD (ALPINE JS)              --}}
        {{-- ======================================================== --}}
        <div x-show="showConfirmModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6">
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
                 x-transition:enter-start="opacity-0 translate-y-8 scale-90"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-200 transform"
                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                 x-transition:leave-end="opacity-0 translate-y-8 scale-90"
                 class="relative bg-white rounded-[2rem] shadow-2xl w-full max-w-sm p-8 text-center"
            >
                <div class="w-20 h-20 bg-red-50 text-red-600 rounded-full flex items-center justify-center mx-auto mb-5 text-3xl shadow-inner">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                
                <h3 class="text-xl font-extrabold text-slate-800 mb-2 tracking-tight">Yakin Ganti Password?</h3>
                <p class="text-sm text-slate-500 mb-8 leading-relaxed">
                    Jika Anda melanjutkan, Anda akan menggunakan password baru ini pada saat Login berikutnya. Pastikan Anda mengingatnya!
                </p>
                
                <div class="flex flex-col gap-3">
                    <button @click="$refs.formPassword.submit()" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold text-xs uppercase tracking-widest py-3.5 rounded-xl shadow-lg shadow-red-200 transition-all active:scale-95">
                        Ya, Ganti Password!
                    </button>
                    <button @click="showConfirmModal = false" class="w-full bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-xs uppercase tracking-widest py-3.5 rounded-xl transition-all">
                        Batal
                    </button>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
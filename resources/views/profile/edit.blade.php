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

    <div class="py-12 pb-24">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- ALERT SUKSES --}}
            @if (session('status') === 'profil-updated' || session('status') === 'password-updated')
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="bg-emerald-500 text-white p-4 rounded-2xl shadow-lg flex items-center gap-3 animate-bounce">
                    <i class="fas fa-check-circle text-xl"></i>
                    <span class="font-bold text-sm">Perubahan berhasil disimpan secara aman!</span>
                </div>
            @endif

            {{-- FORM 1: INFORMASI PROFIL --}}
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden relative">
                <div class="p-8 md:p-10">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl shadow-sm">
                            <i class="fas fa-id-card"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-slate-800 uppercase tracking-tight">Informasi Dasar</h3>
                            <p class="text-xs font-bold text-slate-400">Perbarui nama tampilan dan alamat email Anda.</p>
                        </div>
                    </div>

                    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                        @csrf
                        @method('patch')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-5 py-3.5 bg-slate-50 border-transparent focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 rounded-2xl text-sm font-bold text-slate-700 transition-all">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Alamat Email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-5 py-3.5 bg-slate-50 border-transparent focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 rounded-2xl text-sm font-bold text-slate-700 transition-all">
                            </div>
                        </div>

                        <div class="flex justify-end pt-4">
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-black text-[10px] uppercase tracking-widest py-4 px-8 rounded-2xl shadow-lg shadow-indigo-100 transition-all active:scale-95">
                                Simpan Informasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- FORM 2: UPDATE PASSWORD (KHUSUS KEAMANAN) --}}
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden relative">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-red-600 to-orange-400"></div>
                <div class="p-8 md:p-10">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-12 h-12 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center text-xl shadow-sm">
                            <i class="fas fa-lock"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-slate-800 uppercase tracking-tight">Keamanan Akun</h3>
                            <p class="text-xs font-bold text-slate-400">Pastikan Anda menggunakan password yang kuat dan unik.</p>
                        </div>
                    </div>

                    <form method="post" action="{{ route('profile.password.update') }}" class="space-y-6">
                        @csrf
                        @method('put')

                        <div class="space-y-6">
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Password Saat Ini</label>
                                <input type="password" name="current_password" required class="w-full px-5 py-3.5 bg-slate-50 border-transparent focus:border-red-500 focus:ring-4 focus:ring-red-500/10 rounded-2xl text-sm font-bold text-slate-700 transition-all">
                                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Password Baru</label>
                                    <input type="password" name="password" required class="w-full px-5 py-3.5 bg-slate-50 border-transparent focus:border-red-500 focus:ring-4 focus:ring-red-500/10 rounded-2xl text-sm font-bold text-slate-700 transition-all">
                                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Konfirmasi Password Baru</label>
                                    <input type="password" name="password_confirmation" required class="w-full px-5 py-3.5 bg-slate-50 border-transparent focus:border-red-500 focus:ring-4 focus:ring-red-500/10 rounded-2xl text-sm font-bold text-slate-700 transition-all">
                                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end pt-4">
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-black text-[10px] uppercase tracking-widest py-4 px-10 rounded-2xl shadow-lg shadow-red-100 transition-all active:scale-95">
                                Perbarui Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
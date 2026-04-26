<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-slate-800 leading-tight tracking-tight">
            {{ __('Kotak Masuk (Saran & Kritik)') }}
        </h2>
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

            {{-- === PANEL KONTROL: FILTER & PENCARIAN === --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 mb-8">
                <form method="GET" action="{{ route('admin.messages.index') }}" class="flex flex-col md:flex-row justify-between items-center gap-4">
                    
                    {{-- Dropdown Show Entries --}}
                    <div class="flex items-center gap-3 w-full md:w-auto bg-slate-50 px-4 py-2 rounded-xl border border-slate-100">
                        <i class="fas fa-filter text-red-600"></i>
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Tampilkan</span>
                        <select name="per_page" onchange="this.form.submit()" class="border-none focus:ring-0 bg-transparent text-sm font-bold text-slate-800 cursor-pointer p-0 pr-8">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                        </select>
                    </div>

                    {{-- Search Bar Premium --}}
                    <div class="flex w-full md:w-auto gap-2">
                        <div class="relative w-full md:w-96">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-search text-slate-300"></i>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama, Kontak, atau Isi Pesan..." class="w-full pl-11 pr-4 py-2.5 border border-slate-200 bg-slate-50 rounded-xl focus:ring-red-500 focus:border-red-500 text-sm font-medium text-slate-700 transition-all placeholder-slate-400">
                        </div>
                        <button type="submit" class="bg-slate-800 text-white px-6 py-2.5 rounded-xl hover:bg-slate-900 transition-all shadow-md font-bold text-sm active:scale-95 whitespace-nowrap">
                            Cari
                        </button>
                        @if(request('search'))
                            <a href="{{ route('admin.messages.index') }}" class="bg-red-50 text-red-600 px-4 py-2.5 rounded-xl hover:bg-red-100 transition-all shadow-sm font-bold flex items-center justify-center">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- === HEADER JUDUL KOLOM (Desktop Only) === --}}
            <div class="hidden lg:grid grid-cols-12 gap-8 px-10 py-3 text-[10px] uppercase tracking-[0.2em] font-black text-slate-400 mb-2">
                <div class="col-span-3">Pengirim & Kontak</div>
                <div class="col-span-7">Isi Saran & Kritik</div>
                <div class="col-span-2 text-center">Tindakan</div>
            </div>

            {{-- === DAFTAR PESAN (CARD LAYOUT - DIKOTAKIN) === --}}
            <div class="space-y-5">
                @forelse($messages as $msg)
                    <div class="bg-white rounded-[2rem] shadow-sm hover:shadow-md border border-slate-100 p-6 md:p-8 transition-all duration-300 relative group overflow-hidden">
                        
                        {{-- Garis Aksen Samping --}}
                        <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-red-600 opacity-0 group-hover:opacity-100 transition-opacity"></div>

                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                            
                            {{-- KOLOM 1: Nama & Kontak (Sesuai Form) --}}
                            <div class="lg:col-span-3">
                                <div class="flex flex-col">
                                    <div class="flex items-center gap-2 mb-3">
                                        <div class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center text-xs border border-red-100">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Data Pengirim</span>
                                    </div>

                                    <h3 class="font-black text-slate-800 text-lg leading-tight mb-1 truncate" title="{{ $msg->name }}">
                                        {{ $msg->name }}
                                    </h3>
                                    
                                    <div class="flex items-center gap-2 text-red-600 font-bold mb-3">
                                        <i class="{{ str_contains($msg->contact, '@') ? 'fas fa-envelope' : 'fas fa-phone' }} text-[10px]"></i>
                                        <span class="text-xs truncate">{{ $msg->contact }}</span>
                                    </div>

                                    <div class="inline-flex items-center gap-1.5 text-[9px] font-bold text-slate-400 bg-slate-50 w-fit px-2 py-1 rounded-md">
                                        <i class="far fa-clock"></i>
                                        {{ $msg->created_at->translatedFormat('d M Y - H:i') }} WIB
                                    </div>
                                </div>
                            </div>

                            {{-- KOLOM 2: Isi Pesan --}}
                            <div class="lg:col-span-7">
                                <div class="flex items-center gap-2 mb-3">
                                    <div class="w-8 h-8 rounded-lg bg-slate-50 text-slate-400 flex items-center justify-center text-xs border border-slate-100">
                                        <i class="fas fa-comment-dots"></i>
                                    </div>
                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Pesan / Saran</span>
                                </div>
                                
                                <div class="bg-slate-50 p-5 rounded-[1.5rem] border border-slate-100 relative group-hover:bg-white transition-colors h-full">
                                    <i class="fas fa-quote-left absolute top-4 left-4 text-slate-200 text-2xl opacity-50"></i>
                                    <p class="text-sm text-slate-600 leading-relaxed italic relative z-10 pl-6 pr-2">
                                        {{ $msg->message }}
                                    </p>
                                </div>
                            </div>

                            {{-- KOLOM 3: Aksi --}}
                            <div class="lg:col-span-2 flex flex-row lg:flex-col items-center justify-center lg:h-full gap-3 pt-4 lg:pt-0 border-t lg:border-none border-slate-50">
                                <span class="lg:hidden text-[9px] font-black text-slate-400 uppercase tracking-widest mr-auto">Kelola Pesan</span>
                                <form action="{{ route('admin.messages.destroy', $msg->id) }}" method="POST" onsubmit="return confirm('Hapus pesan ini selamanya?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-12 h-12 rounded-2xl bg-red-50 text-red-500 hover:bg-red-600 hover:text-white flex items-center justify-center transition-all shadow-sm active:scale-90" title="Hapus Pesan">
                                        <i class="fas fa-trash-alt text-lg"></i>
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                @empty
                    {{-- State Jika Kosong --}}
                    <div class="bg-white rounded-[2.5rem] border border-slate-100 p-20 text-center shadow-sm">
                        <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-inbox text-5xl text-slate-200"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-700">Kotak Masuk Masih Bersih</h3>
                        <p class="text-sm text-slate-400 mt-2">Belum ada saran atau kritik yang masuk ke sistem saat ini.</p>
                    </div>
                @endforelse
            </div>

            {{-- === FOOTER: PAGINATION & TOTAL DATA === --}}
            <div class="mt-8 flex flex-col md:flex-row items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                    Menampilkan {{ $messages->count() }} dari {{ $messages->total() }} pesan
                </p>
                <div>
                    {{ $messages->links() }}
                </div>
            </div>

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
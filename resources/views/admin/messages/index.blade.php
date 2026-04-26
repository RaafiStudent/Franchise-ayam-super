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
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 mb-6">
                <form method="GET" action="{{ route('admin.messages.index') }}" class="flex flex-col md:flex-row justify-between items-center gap-4">
                    
                    {{-- Dropdown Show Entries --}}
                    <div class="flex items-center gap-3 w-full md:w-auto bg-slate-50 px-4 py-2 rounded-xl border border-slate-100">
                        <i class="fas fa-filter text-red-500 text-xs"></i>
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Tampilkan</span>
                        <select name="per_page" onchange="this.form.submit()" class="border-none focus:ring-0 bg-transparent text-sm font-bold text-slate-800 cursor-pointer p-0 pr-6">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                        </select>
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Pesan</span>
                    </div>

                    {{-- Search Bar --}}
                    <div class="flex w-full md:w-auto gap-2">
                        <div class="relative w-full md:w-80">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-search text-slate-400"></i>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama atau Isi Pesan..." class="w-full pl-10 pr-4 py-2.5 border border-slate-200 bg-slate-50 rounded-xl focus:ring-red-500 focus:border-red-500 text-sm font-medium text-slate-700 transition-all">
                        </div>
                        <button type="submit" class="bg-slate-800 text-white px-6 py-2.5 rounded-xl hover:bg-slate-900 transition-all shadow-md font-bold text-sm active:scale-95 whitespace-nowrap">
                            Cari
                        </button>
                        @if(request('search'))
                            <a href="{{ route('admin.messages.index') }}" class="bg-red-50 text-red-600 px-4 py-2.5 rounded-xl hover:bg-red-100 transition-all shadow-sm flex items-center justify-center">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- === DAFTAR PESAN "DIKOTAKIN" (CARD LAYOUT) === --}}
            <div class="space-y-4">
                @forelse($messages as $msg)
                    <div class="bg-white rounded-[1.5rem] shadow-sm hover:shadow-md border border-slate-100 p-5 md:p-6 transition-all duration-300 relative group overflow-hidden">
                        
                        {{-- Aksen Garis Merah di samping --}}
                        <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-red-600 opacity-0 group-hover:opacity-100 transition-opacity rounded-l-2xl"></div>

                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                            
                            {{-- Info Pengirim & Waktu --}}
                            <div class="flex items-start gap-4 md:w-1/3">
                                <div class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center shrink-0 border border-slate-100 text-slate-400 group-hover:bg-red-50 group-hover:text-red-500 transition-colors">
                                    <i class="fas fa-envelope-open-text text-lg"></i>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] mb-1">
                                        {{ $msg->created_at->translatedFormat('d M Y - H:i') }} WIB
                                    </span>
                                    <h3 class="font-extrabold text-slate-800 text-base leading-tight">{{ $msg->name }}</h3>
                                    <p class="text-xs text-red-600 font-semibold mt-1">{{ $msg->email }}</p>
                                </div>
                            </div>

                            {{-- Isi Pesan --}}
                            <div class="flex-1 bg-slate-50/50 p-4 rounded-2xl border border-slate-100 group-hover:bg-white transition-colors">
                                <p class="text-sm text-slate-600 leading-relaxed italic">
                                    "{{ $msg->message }}"
                                </p>
                            </div>

                            {{-- Aksi --}}
                            <div class="shrink-0 flex md:justify-end">
                                <form action="{{ route('admin.messages.destroy', $msg->id) }}" method="POST" onsubmit="return confirm('Hapus pesan ini selamanya?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-10 h-10 rounded-xl bg-red-50 text-red-500 hover:bg-red-600 hover:text-white flex items-center justify-center transition-all shadow-sm group-hover:shadow-md active:scale-90">
                                        <i class="fas fa-trash-alt text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- State Kosong --}}
                    <div class="bg-white rounded-[2rem] border border-slate-100 p-16 text-center shadow-sm">
                        <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-inbox text-4xl text-slate-300"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-700">Kotak Masuk Kosong</h3>
                        <p class="text-sm text-slate-400 mt-1">Belum ada saran atau kritik yang masuk saat ini.</p>
                    </div>
                @endforelse
            </div>

            {{-- === TOMBOL PAGINATION (ANGKA HALAMAN) === --}}
            <div class="mt-8 bg-white p-4 rounded-2xl shadow-sm border border-slate-100">
                {{ $messages->links() }}
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
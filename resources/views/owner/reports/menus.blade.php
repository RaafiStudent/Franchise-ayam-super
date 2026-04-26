<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 bg-red-600 rounded-2xl flex items-center justify-center shadow-lg shadow-red-200">
                <i class="fas fa-utensils text-white text-xl"></i>
            </div>
            <div>
                <h2 class="font-extrabold text-2xl text-slate-800 leading-tight tracking-tight">
                    {{ __('Laporan Popularitas Menu') }}
                </h2>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest px-1">Analisis Minat Pelanggan</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 pb-24">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- === BAGIAN 1: KARTU STATISTIK PREMIUM === --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                
                {{-- Menu Paling Disukai --}}
                <div class="bg-white rounded-[2rem] p-7 border border-slate-100 shadow-sm relative overflow-hidden group">
                    <div class="absolute -right-4 -bottom-4 opacity-[0.03] group-hover:scale-110 transition-transform duration-700">
                        <i class="fas fa-heart text-[8rem] text-red-600"></i>
                    </div>
                    <div class="relative z-10">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Menu Paling Disukai</p>
                        <h3 class="text-xl font-black text-slate-800 leading-tight mb-1">
                            {{ $bestMenu->name ?? 'Belum Ada Data' }}
                        </h3>
                        <div class="flex items-center gap-2 text-emerald-500 font-bold text-xs">
                            <i class="fas fa-thumbs-up"></i>
                            <span>{{ $bestMenu->loves ?? 0 }} Likes dari User</span>
                        </div>
                    </div>
                    <div class="absolute top-0 left-0 h-full w-1.5 bg-emerald-500"></div>
                </div>

                {{-- Total Varian Menu --}}
                <div class="bg-white rounded-[2rem] p-7 border border-slate-100 shadow-sm relative overflow-hidden group">
                    <div class="absolute -right-4 -bottom-4 opacity-[0.03] group-hover:scale-110 transition-transform duration-700">
                        <i class="fas fa-list text-[8rem] text-blue-600"></i>
                    </div>
                    <div class="relative z-10">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Total Varian Menu</p>
                        <h3 class="text-4xl font-black text-slate-800 tracking-tighter">
                            {{ $totalVariants }} <span class="text-sm text-slate-400 font-bold ml-1 uppercase">Item</span>
                        </h3>
                        <p class="text-[10px] font-bold text-slate-400 italic mt-2">Tersedia di Katalog Publik</p>
                    </div>
                    <div class="absolute top-0 left-0 h-full w-1.5 bg-blue-500"></div>
                </div>

                {{-- Total Partisipasi --}}
                <div class="bg-white rounded-[2rem] p-7 border border-slate-100 shadow-sm relative overflow-hidden group">
                    <div class="absolute -right-4 -bottom-4 opacity-[0.03] group-hover:scale-110 transition-transform duration-700">
                        <i class="fas fa-users text-[8rem] text-amber-600"></i>
                    </div>
                    <div class="relative z-10">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Total Partisipasi User</p>
                        <h3 class="text-4xl font-black text-slate-800 tracking-tighter">
                            {{ $totalParticipation }} <span class="text-sm text-slate-400 font-bold ml-1 uppercase">Suara</span>
                        </h3>
                        <p class="text-[10px] font-bold text-slate-400 italic mt-2">Total Akumulasi Like + Dislike</p>
                    </div>
                    <div class="absolute top-0 left-0 h-full w-1.5 bg-amber-500"></div>
                </div>

            </div>

            {{-- === BAGIAN 2: PERINGKAT MENU (MODERN LIST) === --}}
            <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.04)] border border-slate-100 overflow-hidden">
                <div class="p-8 md:p-10 border-b border-slate-50 flex items-center justify-between bg-slate-50/30">
                    <div>
                        <h3 class="font-black text-xl text-slate-800 tracking-tight">Peringkat Menu Berdasarkan Like</h3>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Data kepuasan pelanggan real-time</p>
                    </div>
                    <div class="hidden md:flex items-center gap-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                        <span class="flex items-center gap-1.5"><i class="fas fa-thumbs-up text-emerald-400"></i> Suka</span>
                        <span class="flex items-center gap-1.5"><i class="fas fa-thumbs-down text-rose-400"></i> Gak Suka</span>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-center w-20">Rank</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Menu Informasi</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-center">Respon</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-center">Rating</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">Status Analisis</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($menus as $index => $menu)
                                <tr class="group hover:bg-slate-50/80 transition-all duration-300">
                                    {{-- Kolom Rank --}}
                                    <td class="px-8 py-6 text-center">
                                        @if($index == 0)
                                            <div class="w-10 h-10 bg-gradient-to-br from-yellow-300 to-yellow-500 rounded-full flex items-center justify-center text-white shadow-md shadow-yellow-200 mx-auto">
                                                <i class="fas fa-crown text-sm"></i>
                                            </div>
                                        @elseif($index == 1)
                                            <div class="w-9 h-9 bg-slate-300 rounded-full flex items-center justify-center text-white shadow-md mx-auto">
                                                <span class="font-black text-xs">2</span>
                                            </div>
                                        @elseif($index == 2)
                                            <div class="w-9 h-9 bg-orange-300 rounded-full flex items-center justify-center text-white shadow-md mx-auto">
                                                <span class="font-black text-xs">3</span>
                                            </div>
                                        @else
                                            <span class="font-bold text-slate-300">#{{ $index + 1 }}</span>
                                        @endif
                                    </td>

                                    {{-- Info Menu --}}
                                    <td class="px-8 py-6">
                                        <div class="flex items-center gap-4">
                                            <div class="w-14 h-14 rounded-2xl overflow-hidden shadow-sm border border-slate-100 shrink-0">
                                                <img src="{{ asset('storage/' . $menu->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="font-black text-slate-800 text-base leading-tight">{{ $menu->name }}</span>
                                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-1 bg-slate-100 px-2 py-0.5 rounded w-fit">
                                                    {{ $menu->label ?? 'Katalog Menu' }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Respon Like/Dislike --}}
                                    <td class="px-8 py-6 text-center">
                                        <div class="inline-flex items-center gap-3">
                                            <div class="flex flex-col items-center">
                                                <span class="text-xs font-black text-emerald-500">{{ $menu->loves }}</span>
                                                <div class="w-8 h-1 bg-emerald-100 rounded-full mt-1 overflow-hidden">
                                                    <div class="bg-emerald-500 h-full" style="width: 100%"></div>
                                                </div>
                                            </div>
                                            <div class="flex flex-col items-center">
                                                <span class="text-xs font-black text-rose-400">{{ $menu->hates }}</span>
                                                <div class="w-8 h-1 bg-rose-100 rounded-full mt-1 overflow-hidden">
                                                    <div class="bg-rose-400 h-full" style="width: 100%"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Rating Bintang --}}
                                    <td class="px-8 py-6 text-center">
                                        @php
                                            $totalFeedback = $menu->loves + $menu->hates;
                                            $rating = $totalFeedback > 0 ? round(($menu->loves / $totalFeedback) * 5, 1) : 0;
                                        @endphp
                                        <div class="flex flex-col items-center">
                                            <div class="flex items-center gap-1 text-yellow-400 text-[10px]">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="{{ $i <= $rating ? 'fas' : 'far' }} fa-star"></i>
                                                @endfor
                                            </div>
                                            <span class="text-[10px] font-black text-slate-700 mt-1">{{ $rating }} / 5.0</span>
                                            <span class="text-[8px] font-bold text-slate-400 uppercase italic">({{ $totalFeedback }} votes)</span>
                                        </div>
                                    </td>

                                    {{-- Status Analisis --}}
                                    <td class="px-8 py-6 text-right">
                                        @if($rating >= 3.0)
                                            <span class="inline-flex items-center bg-emerald-50 text-emerald-600 px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest border border-emerald-100 shadow-sm">
                                                <i class="fas fa-check-circle mr-2"></i> Performa Aman
                                            </span>
                                        @else
                                            <span class="inline-flex items-center bg-rose-50 text-rose-600 px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest border border-rose-100 shadow-sm">
                                                <i class="fas fa-exclamation-triangle mr-2"></i> Perlu Evaluasi
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-20 text-center">
                                        <div class="flex flex-col items-center">
                                            <i class="fas fa-layer-group text-6xl text-slate-100 mb-4"></i>
                                            <p class="text-slate-400 font-bold">Belum ada data menu untuk dianalisis.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-8 bg-slate-50/50 border-t border-slate-50 text-center">
                    <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.3em]">Menu Performance Insights v1.0</p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
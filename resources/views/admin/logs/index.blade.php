<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-slate-800 rounded-2xl flex items-center justify-center shadow-lg shadow-slate-200">
                    <i class="fas fa-shield-alt text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="font-extrabold text-2xl text-slate-800 leading-tight tracking-tight">
                        {{ __('Audit Log - Aktivitas Sistem') }}
                    </h2>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest px-1">Keamanan & Riwayat Tindakan</p>
                </div>
            </div>
            
            {{-- READ ONLY BADGE --}}
            <div class="bg-slate-50 border border-slate-200 px-4 py-2 rounded-xl flex items-center gap-2 w-fit">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-slate-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-slate-500"></span>
                </span>
                <span class="text-[10px] font-black text-slate-700 uppercase tracking-wider italic">Otomatis Terrekam</span>
            </div>
        </div>
    </x-slot>

    <div class="py-8 pb-24">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- === PANEL KONTROL: FILTER & PENCARIAN === --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 mb-8">
                <form method="GET" action="{{ url()->current() }}" class="flex flex-col md:flex-row justify-between items-center gap-4">
                    
                    <div class="flex items-center gap-3 w-full md:w-auto bg-slate-50 px-4 py-2 rounded-xl border border-slate-100">
                        <i class="fas fa-list-ol text-slate-400 text-xs"></i>
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Show</span>
                        <select name="per_page" onchange="this.form.submit()" class="border-none focus:ring-0 bg-transparent text-sm font-bold text-slate-800 cursor-pointer p-0 pr-8">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        </select>
                    </div>

                    <div class="flex w-full md:w-auto gap-2">
                        <div class="relative w-full md:w-96">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-search text-slate-300"></i>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Pelaku, Tindakan, atau Detail..." class="w-full pl-11 pr-4 py-2.5 border border-slate-200 bg-slate-50 rounded-xl focus:ring-slate-500 focus:border-slate-500 text-sm font-medium text-slate-700 transition-all placeholder-slate-400">
                        </div>
                        <button type="submit" class="bg-slate-800 text-white px-6 py-2.5 rounded-xl hover:bg-slate-900 transition-all shadow-md font-bold text-sm active:scale-95 whitespace-nowrap">
                            Cari Log
                        </button>
                    </div>
                </form>
            </div>

            {{-- === MAIN TABLE CONTAINER === --}}
            <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.04)] border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Waktu Event</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Pelaku (Admin)</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-center">Aksi / Tindakan</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Target Akun</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Keterangan Detail</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($logs as $log)
                                <tr class="group hover:bg-slate-50/50 transition-all duration-300">
                                    <td class="px-8 py-6">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-extrabold text-slate-700">{{ $log->created_at->format('d M Y') }}</span>
                                            <span class="text-[10px] font-bold text-slate-400">{{ $log->created_at->format('H:i:s') }} WIB</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-white transition-colors border border-transparent group-hover:border-slate-100 shadow-sm font-black text-[10px]">
                                                {{ substr($log->user->name ?? 'S', 0, 1) }}
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="font-extrabold text-slate-800 text-sm">{{ $log->user->name ?? 'System' }}</span>
                                                <span class="text-[9px] font-bold text-slate-400 italic">IP: {{ $log->ip_address ?? '-' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 text-center">
                                        @php
                                            $action = strtoupper($log->action);
                                            $color = 'slate';
                                            if(str_contains($action, 'CREATE')) $color = 'emerald';
                                            elseif(str_contains($action, 'UPDATE')) $color = 'blue';
                                            elseif(str_contains($action, 'DELETE')) $color = 'red';
                                        @endphp
                                        <span class="inline-flex items-center bg-{{ $color }}-50 text-{{ $color }}-600 px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest border border-{{ $color }}-100 shadow-sm">
                                            {{ $log->action }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="bg-slate-100/50 px-3 py-1.5 rounded-lg border border-slate-100 w-fit">
                                            <span class="text-xs font-black text-slate-600">{{ $log->target_user ?? '-' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <p class="text-xs text-slate-500 leading-relaxed font-medium italic">
                                            "{{ $log->description }}"
                                        </p>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-24 text-center">
                                        <div class="flex flex-col items-center">
                                            <i class="fas fa-fingerprint text-6xl text-slate-100 mb-4"></i>
                                            <p class="text-slate-400 font-bold uppercase tracking-widest text-xs">Belum ada aktivitas terekam.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                {{-- Footer Info --}}
                <div class="p-8 bg-slate-50/50 border-t border-slate-50 flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">Security Audit v1.0</p>
                    <div>
                        {{ $logs->links() }}
                    </div>
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
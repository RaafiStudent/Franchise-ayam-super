<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-slate-800 leading-tight tracking-tight">
            {{ __('Audit Log - Aktivitas Sistem') }}
        </h2>
    </x-slot>

    <div class="py-8 pb-20">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- MAIN CONTAINER PREMIUM --}}
            <div class="bg-white rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 overflow-hidden">
                <div class="p-6 md:p-8">

                    {{-- === FITUR PENCARIAN (RAPI & MENYATU) === --}}
                    <form method="GET" action="{{ route('admin.logs') }}" class="mb-8 flex flex-col md:flex-row justify-between items-center gap-4 bg-slate-50 p-4 rounded-2xl border border-slate-100">
                        
                        {{-- Dropdown Show Entries --}}
                        <div class="flex items-center gap-3 w-full md:w-auto">
                            <div class="w-10 h-10 bg-white rounded-xl shadow-sm flex items-center justify-center text-red-600 border border-slate-100 shrink-0">
                                <i class="fas fa-list-ul"></i>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Tampilkan</span>
                                <select name="per_page" onchange="this.form.submit()" class="border-transparent focus:border-red-500 focus:ring-red-500 rounded-xl shadow-sm text-sm font-bold text-slate-700 bg-white cursor-pointer hover:bg-slate-50 transition-colors py-2 pl-4 pr-8 appearance-none">
                                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                </select>
                            </div>
                        </div>

                        {{-- Search Bar Premium --}}
                        <div class="flex w-full md:w-auto gap-2">
                            <div class="relative w-full md:w-80">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-slate-400"></i>
                                </div>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Tindakan, Target, atau Detail..." class="w-full pl-11 pr-4 py-2.5 border-transparent focus:border-red-500 focus:ring-red-500 rounded-xl shadow-sm text-sm bg-white font-medium text-slate-700 transition-all placeholder-slate-400">
                            </div>
                            <button type="submit" class="bg-slate-800 text-white px-6 py-2.5 rounded-xl hover:bg-slate-900 transition-all shadow-md font-bold text-sm flex items-center gap-2 active:scale-95 whitespace-nowrap">
                                Cari
                            </button>
                            @if(request('search'))
                                <a href="{{ route('admin.logs') }}" class="bg-red-50 text-red-600 px-4 py-2.5 rounded-xl hover:bg-red-100 transition-all shadow-sm font-bold text-sm flex items-center justify-center active:scale-95" title="Reset Pencarian">
                                    <i class="fas fa-times"></i>
                                </a>
                            @endif
                        </div>
                    </form>
                    {{-- ============================== --}}

                    {{-- TABEL PREMIUM --}}
                    <div class="overflow-x-auto rounded-2xl border border-slate-100">
                        <table class="min-w-full bg-white text-sm text-left">
                            <thead>
                                <tr class="bg-slate-50/80 text-slate-500 text-[10px] uppercase tracking-widest font-black border-b border-slate-100">
                                    <th class="py-5 px-6 rounded-tl-2xl">Waktu</th>
                                    <th class="py-5 px-6">Pelaku (Admin)</th>
                                    <th class="py-5 px-6 text-center">Tindakan</th>
                                    <th class="py-5 px-6">Target Akun</th>
                                    <th class="py-5 px-6 rounded-tr-2xl">Keterangan Detail</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50 font-medium">
                                @forelse($logs as $log)
                                <tr class="hover:bg-slate-50/50 transition-colors group">
                                    
                                    {{-- Kolom 1: Waktu --}}
                                    <td class="py-4 px-6 align-top whitespace-nowrap">
                                        <div class="flex items-center gap-2 text-slate-600">
                                            <i class="far fa-calendar-alt text-slate-400"></i>
                                            <span class="text-xs font-bold">{{ $log->created_at->format('d/m/Y') }}</span>
                                        </div>
                                        <div class="text-[10px] text-slate-400 mt-1 ml-5 font-semibold">
                                            {{ $log->created_at->format('H:i:s') }} WIB
                                        </div>
                                    </td>

                                    {{-- Kolom 2: Pelaku --}}
                                    <td class="py-4 px-6 align-top">
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center text-[10px] font-bold">
                                                {{ strtoupper(substr($log->user->name ?? 'S', 0, 1)) }}
                                            </div>
                                            <span class="font-bold text-slate-800 text-sm">{{ $log->user->name ?? 'Sistem' }}</span>
                                        </div>
                                        <div class="text-[10px] text-slate-400 mt-1 ml-8 font-mono">
                                            IP: {{ $log->ip_address ?? '-' }}
                                        </div>
                                    </td>

                                    {{-- Kolom 3: Tindakan (Warna Dinamis) --}}
                                    <td class="py-4 px-6 text-center align-top">
                                        @if(str_contains(strtoupper($log->action), 'CREATE'))
                                            <span class="inline-flex items-center bg-emerald-50 text-emerald-600 py-1.5 px-3 rounded-lg text-[10px] font-black uppercase tracking-widest border border-emerald-200/60 shadow-sm">
                                                {{ $log->action }}
                                            </span>
                                        @elseif(str_contains(strtoupper($log->action), 'UPDATE'))
                                            <span class="inline-flex items-center bg-blue-50 text-blue-600 py-1.5 px-3 rounded-lg text-[10px] font-black uppercase tracking-widest border border-blue-200/60 shadow-sm">
                                                {{ $log->action }}
                                            </span>
                                        @elseif(str_contains(strtoupper($log->action), 'DELETE'))
                                            <span class="inline-flex items-center bg-red-50 text-red-600 py-1.5 px-3 rounded-lg text-[10px] font-black uppercase tracking-widest border border-red-200/60 shadow-sm">
                                                {{ $log->action }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center bg-slate-100 text-slate-600 py-1.5 px-3 rounded-lg text-[10px] font-black uppercase tracking-widest border border-slate-200 shadow-sm">
                                                {{ $log->action }}
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Kolom 4: Target --}}
                                    <td class="py-4 px-6 align-top">
                                        <span class="font-bold text-slate-700 bg-slate-50 px-2 py-1 rounded-md border border-slate-100">
                                            {{ $log->target_user ?? '-' }}
                                        </span>
                                    </td>

                                    {{-- Kolom 5: Deskripsi --}}
                                    <td class="py-4 px-6 align-top">
                                        <p class="text-xs text-slate-500 leading-relaxed italic max-w-sm">
                                            "{{ $log->description ?? '-' }}"
                                        </p>
                                    </td>

                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-16">
                                        <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <i class="fas fa-clipboard-list text-4xl text-slate-300"></i>
                                        </div>
                                        <h3 class="text-lg font-bold text-slate-700 mb-1">Log Kosong</h3>
                                        <p class="text-sm text-slate-400">Belum ada catatan aktivitas yang terekam sistem.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- === PAGINATION LINKS === --}}
                    @if(method_exists($logs, 'links'))
                    <div class="mt-6">
                        {{ $logs->links() }}
                    </div>
                    @endif
                    {{-- =========================================== --}}

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
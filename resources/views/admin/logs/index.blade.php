<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-red-600 rounded-xl flex items-center justify-center shadow-md">
                <i class="fas fa-history text-white"></i>
            </div>
            <h2 class="font-extrabold text-2xl text-slate-800 leading-tight tracking-tight">
                {{ __('Audit Log - Aktivitas Sistem') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8 pb-20">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 overflow-hidden">
                <div class="p-6 md:p-8">

                    {{-- === PANEL KONTROL: FILTER & PENCARIAN (FIXED ROUTE) === --}}
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 mb-8">
                        {{-- FIX: Route diarahkan ke admin.logs, bukan owner.logs --}}
                        <form method="GET" action="{{ route('admin.logs') }}" class="flex flex-col md:flex-row justify-between items-center gap-4">
                            
                            <div class="flex items-center gap-3 w-full md:w-auto">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Tampilkan</span>
                                <select name="per_page" onchange="this.form.submit()" class="border-transparent focus:ring-0 rounded-xl shadow-sm text-sm font-bold text-slate-700 bg-white cursor-pointer px-4">
                                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                </select>
                            </div>

                            <div class="flex w-full md:w-auto gap-2">
                                <div class="relative w-full md:w-80">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-search text-slate-400"></i>
                                    </div>
                                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Tindakan, Pelaku, atau Target..." class="w-full pl-11 pr-4 py-2.5 border-transparent focus:border-red-500 focus:ring-red-500 rounded-xl shadow-sm text-sm font-medium text-slate-700 bg-white transition-all">
                                </div>
                                <button type="submit" class="bg-slate-800 text-white px-6 py-2.5 rounded-xl hover:bg-slate-900 transition-all shadow-md font-bold text-sm active:scale-95 whitespace-nowrap">
                                    Cari
                                </button>
                                @if(request('search'))
                                    <a href="{{ route('admin.logs') }}" class="bg-red-50 text-red-600 px-4 py-2.5 rounded-xl hover:bg-red-100 transition-all shadow-sm flex items-center justify-center" title="Reset">
                                        <i class="fas fa-times"></i>
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>

                    {{-- === TABEL LOG PREMIUM === --}}
                    <div class="overflow-x-auto rounded-2xl border border-slate-50">
                        <table class="min-w-full bg-white text-sm text-left">
                            <thead>
                                <tr class="bg-slate-50/80 text-slate-500 text-[10px] uppercase tracking-widest font-black border-b border-slate-100">
                                    <th class="py-5 px-6">Waktu Kejadian</th>
                                    <th class="py-5 px-6">Pelaku</th>
                                    <th class="py-5 px-6 text-center">Tindakan</th>
                                    <th class="py-5 px-6">Target Akun</th>
                                    <th class="py-5 px-6">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50 font-medium text-slate-600">
                                @forelse($logs as $log)
                                <tr class="hover:bg-slate-50/50 transition-colors group">
                                    <td class="py-4 px-6 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <i class="far fa-calendar-alt text-slate-300"></i>
                                            <span class="font-bold text-slate-700">{{ $log->created_at->format('d/m/Y') }}</span>
                                        </div>
                                        <div class="text-[10px] text-slate-400 mt-0.5 ml-5">{{ $log->created_at->format('H:i') }} WIB</div>
                                    </td>

                                    <td class="py-4 px-6">
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-lg bg-slate-100 flex items-center justify-center text-[10px] font-black text-slate-500 uppercase">
                                                {{ substr($log->user->name ?? 'S', 0, 1) }}
                                            </div>
                                            <span class="font-black text-slate-800">{{ $log->user->name ?? 'System' }}</span>
                                        </div>
                                        <div class="text-[10px] text-slate-400 mt-1 font-mono">IP: {{ $log->ip_address }}</div>
                                    </td>

                                    <td class="py-4 px-6 text-center">
                                        @php
                                            $action = strtoupper($log->action);
                                            $color = 'bg-slate-50 text-slate-500 border-slate-200';
                                            if(str_contains($action, 'CREATE')) $color = 'bg-emerald-50 text-emerald-600 border-emerald-100';
                                            if(str_contains($action, 'UPDATE')) $color = 'bg-blue-50 text-blue-600 border-blue-100';
                                            if(str_contains($action, 'DELETE')) $color = 'bg-red-50 text-red-600 border-red-100';
                                        @endphp
                                        <span class="{{ $color }} py-1 px-3 rounded-lg text-[10px] font-black tracking-widest border shadow-sm">
                                            {{ $action }}
                                        </span>
                                    </td>

                                    <td class="py-4 px-6">
                                        <span class="bg-slate-50 px-2 py-1 rounded text-xs font-bold text-slate-700 border border-slate-100">
                                            {{ $log->target_user ?? '-' }}
                                        </span>
                                    </td>

                                    <td class="py-4 px-6">
                                        <p class="text-xs italic text-slate-400 max-w-xs leading-relaxed">
                                            "{{ $log->description }}"
                                        </p>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-20">
                                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-200">
                                            <i class="fas fa-stream text-3xl"></i>
                                        </div>
                                        <h3 class="text-lg font-bold text-slate-700">Tidak Ada Rekaman Log</h3>
                                        <p class="text-sm text-slate-400">Gunakan kata kunci lain atau tunggu aktivitas sistem.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-8">
                        {{ $logs->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
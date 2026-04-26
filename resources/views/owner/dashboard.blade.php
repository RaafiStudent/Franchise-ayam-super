<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-red-600 rounded-2xl flex items-center justify-center shadow-lg shadow-red-200">
                    <i class="fas fa-chart-line text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="font-extrabold text-2xl text-slate-800 leading-tight tracking-tight">
                        {{ __('Business Monitoring') }}
                    </h2>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Laporan Eksekutif Owner</p>
                </div>
            </div>
            {{-- READ ONLY BADGE --}}
            <div class="bg-amber-50 border border-amber-200 px-4 py-2 rounded-xl flex items-center gap-2 w-fit">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
                </span>
                <span class="text-[10px] font-black text-amber-700 uppercase tracking-wider">Mode Pantau Saja</span>
            </div>
        </div>
    </x-slot>

    <div class="py-8 pb-24">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- === BAGIAN 1: KARTU STATISTIK PREMIUM === --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                
                {{-- Total Omset All-Time --}}
                <div class="bg-white rounded-[2rem] p-8 border border-slate-100 shadow-[0_10px_40px_rgba(0,0,0,0.03)] relative overflow-hidden group hover:shadow-md transition-all duration-500">
                    <div class="absolute -right-6 -bottom-6 opacity-[0.03] group-hover:scale-110 transition-transform duration-700">
                        <i class="fas fa-coins text-[10rem] text-slate-900"></i>
                    </div>
                    <div class="relative z-10">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Total Omset (All-Time)</p>
                        <h3 class="text-3xl font-black text-slate-900 tracking-tighter">
                            Rp {{ number_format($totalOmsetAllTime, 0, ',', '.') }}
                        </h3>
                        <div class="mt-4 flex items-center gap-2">
                            <span class="w-10 h-1 bg-yellow-400 rounded-full"></span>
                            <span class="text-[10px] font-bold text-slate-400 italic">Akumulasi Seluruh Penjualan</span>
                        </div>
                    </div>
                </div>

                {{-- Omset Tahun Ini --}}
                <div class="bg-white rounded-[2rem] p-8 border border-slate-100 shadow-[0_10px_40px_rgba(0,0,0,0.03)] relative overflow-hidden group hover:shadow-md transition-all duration-500">
                    <div class="absolute -right-6 -bottom-6 opacity-[0.03] group-hover:scale-110 transition-transform duration-700">
                        <i class="fas fa-calendar-check text-[10rem] text-slate-900"></i>
                    </div>
                    <div class="relative z-10">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Omset Tahun {{ date('Y') }}</p>
                        <h3 class="text-3xl font-black text-red-600 tracking-tighter">
                            Rp {{ number_format($omsetYear, 0, ',', '.') }}
                        </h3>
                        <div class="mt-4 flex items-center gap-2">
                            <span class="w-10 h-1 bg-emerald-400 rounded-full"></span>
                            <span class="text-[10px] font-bold text-slate-400 italic">Pencapaian Tahun Berjalan</span>
                        </div>
                    </div>
                </div>

                {{-- Total Mitra --}}
                <div class="bg-white rounded-[2rem] p-8 border border-slate-100 shadow-[0_10px_40px_rgba(0,0,0,0.03)] relative overflow-hidden group hover:shadow-md transition-all duration-500">
                    <div class="absolute -right-6 -bottom-6 opacity-[0.03] group-hover:scale-110 transition-transform duration-700">
                        <i class="fas fa-store text-[10rem] text-slate-900"></i>
                    </div>
                    <div class="relative z-10">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Total Mitra Bergabung</p>
                        <h3 class="text-4xl font-black text-slate-900 tracking-tighter">
                            {{ $totalMitra }} <span class="text-lg text-slate-400 font-bold ml-1 uppercase">Cabang</span>
                        </h3>
                        <div class="mt-4 flex items-center gap-2">
                            <span class="w-10 h-1 bg-red-600 rounded-full"></span>
                            <span class="text-[10px] font-bold text-slate-400 italic">Ekspansi Jaringan Aktif</span>
                        </div>
                    </div>
                </div>

            </div>

            {{-- === BAGIAN 2: TRANSAKSI TERAKHIR (CARD LIST) === --}}
            <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.04)] border border-slate-100 overflow-hidden">
                <div class="p-8 md:p-10 border-b border-slate-50 flex items-center justify-between">
                    <div>
                        <h3 class="font-black text-xl text-slate-800 tracking-tight">Transaksi Terakhir</h3>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Data Real-time arus kas masuk</p>
                    </div>
                    <i class="fas fa-history text-slate-200 text-3xl"></i>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th class="px-10 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Mitra / Pengirim</th>
                                <th class="px-10 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Total Belanja</th>
                                <th class="px-10 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-center">Status Pembayaran</th>
                                <th class="px-10 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">Waktu</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($recentTransactions as $tx)
                                <tr class="group hover:bg-slate-50/50 transition-all duration-300">
                                    <td class="px-10 py-6">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-white transition-colors border border-transparent group-hover:border-slate-100 shadow-sm">
                                                <i class="fas fa-user-tie text-sm"></i>
                                            </div>
                                            <span class="font-extrabold text-slate-800 text-base">{{ $tx->user->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-10 py-6">
                                        <span class="font-black text-red-600 text-lg tracking-tighter">
                                            Rp {{ number_format($tx->total_price, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td class="px-10 py-6 text-center">
                                        @if($tx->payment_status == 'paid' || $tx->payment_status == 'PAID')
                                            <span class="inline-flex items-center bg-emerald-50 text-emerald-600 px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest border border-emerald-100 shadow-sm">
                                                <i class="fas fa-check-circle mr-2"></i> PAID
                                            </span>
                                        @else
                                            <span class="inline-flex items-center bg-slate-50 text-slate-400 px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest border border-slate-100 shadow-sm">
                                                <i class="fas fa-clock mr-2"></i> UNPAID
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-10 py-6 text-right">
                                        <span class="text-xs font-bold text-slate-400 bg-slate-100 px-3 py-1 rounded-lg">
                                            {{ $tx->created_at->diffForHumans() }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-10 py-20 text-center">
                                        <div class="flex flex-col items-center">
                                            <i class="fas fa-receipt text-5xl text-slate-200 mb-4"></i>
                                            <p class="text-slate-400 font-bold">Belum ada transaksi terekam.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                {{-- Footer Transaction Card --}}
                <div class="p-8 bg-slate-50/50 border-t border-slate-50">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Menampilkan {{ count($recentTransactions) }} Data Terakhir</p>
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
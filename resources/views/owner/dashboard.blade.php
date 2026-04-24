<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <h2 class="font-bold text-2xl text-red-700 leading-tight">
                {{ __('Business Monitoring (Owner)') }}
            </h2>
            <span class="text-[10px] font-bold uppercase tracking-widest text-red-500 border border-red-300 bg-red-50 px-2 py-1 rounded">
                Read Only Mode
            </span>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- WIDGET METRIK: 3 KOLOM SEKARANG --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                {{-- KARTU 1: Omset Seluruh Masa (All Time) --}}
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-slate-100 flex flex-col justify-center relative overflow-hidden">
                    <div class="absolute left-0 top-0 bottom-0 w-2 bg-yellow-400"></div>
                    <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Total Omset (All-Time)</p>
                    <h3 class="text-3xl font-black text-slate-800 tracking-tighter">
                        Rp {{ number_format($total_omset, 0, ',', '.') }}
                    </h3>
                </div>

                {{-- KARTU 2: Omset Tahun Ini Saja (Baru) --}}
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-slate-100 flex flex-col justify-center relative overflow-hidden">
                    <div class="absolute left-0 top-0 bottom-0 w-2 bg-emerald-500"></div>
                    <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Omset Tahun {{ date('Y') }}</p>
                    <h3 class="text-3xl font-black text-slate-800 tracking-tighter">
                        Rp {{ number_format($omset_tahun_ini, 0, ',', '.') }}
                    </h3>
                </div>

                {{-- KARTU 3: Total Cabang / Mitra --}}
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-slate-100 flex flex-col justify-center relative overflow-hidden">
                    <div class="absolute left-0 top-0 bottom-0 w-2 bg-red-600"></div>
                    <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Total Mitra Bergabung</p>
                    <h3 class="text-3xl font-black text-slate-800 tracking-tighter">
                        {{ $total_mitra }} <span class="text-lg font-bold text-slate-400">Cabang</span>
                    </h3>
                </div>

            </div>

            {{-- TABEL TRANSAKSI TERAKHIR (TIDAK BERKURANG SAMA SEKALI) --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-50">
                    <h3 class="text-lg font-bold text-slate-800">Transaksi Terakhir</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50 text-slate-400 text-xs font-black uppercase tracking-widest">
                                <th class="px-6 py-4">Mitra</th>
                                <th class="px-6 py-4 text-left">Total Belanja</th>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4 text-right">Waktu</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($pesanan_terbaru as $order)
                            <tr class="hover:bg-slate-50/30 transition-colors">
                                <td class="px-6 py-5">
                                    <span class="font-bold text-slate-700">{{ $order->user->name ?? 'Mitra Dihapus' }}</span>
                                </td>
                                <td class="px-6 py-5 font-bold text-red-600">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-5 text-center">
                                    @if($order->payment_status == 'paid')
                                        <span class="bg-emerald-50 text-emerald-600 border border-emerald-100 text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider">
                                            Paid
                                        </span>
                                    @else
                                        <span class="bg-slate-100 text-slate-500 border border-slate-200 text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider">
                                            Unpaid
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-5 text-right text-xs font-medium text-slate-400">
                                    {{ $order->created_at->diffForHumans() }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-slate-400 text-sm font-medium">
                                    Belum ada transaksi terbaru.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
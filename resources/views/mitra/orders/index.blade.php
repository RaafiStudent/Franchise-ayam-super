<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-red-600 rounded-xl flex items-center justify-center shadow-md">
                <i class="fas fa-clipboard-list text-white"></i>
            </div>
            <div>
                <h2 class="font-extrabold text-2xl text-slate-800 leading-tight tracking-tight">
                    {{ __('Riwayat Pesanan Saya') }}
                </h2>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest px-1">Pantau Status Belanja Stok Anda</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 pb-20">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- MAIN CONTAINER PREMIUM --}}
            <div class="bg-white rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 overflow-hidden">
                <div class="p-6 md:p-8">

                    {{-- === PANEL KONTROL: FILTER & PENCARIAN === --}}
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 mb-8">
                        <form method="GET" action="{{ route('orders.index') }}" class="flex flex-col md:flex-row justify-between items-center gap-4">
                            
                            {{-- Tampilkan Berapa Data --}}
                            <div class="flex items-center gap-3 w-full md:w-auto">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Tampilkan</span>
                                <select name="per_page" onchange="this.form.submit()" class="border-transparent focus:ring-0 rounded-xl shadow-sm text-sm font-bold text-slate-700 bg-white cursor-pointer px-4 py-2.5 outline-none hover:border-red-300 transition-colors">
                                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                </select>
                            </div>

                            {{-- Kotak Cari Premium --}}
                            <div class="flex w-full md:w-auto gap-2">
                                <div class="relative w-full md:w-80">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-search text-slate-400"></i>
                                    </div>
                                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari No. Order / Resi..." class="w-full pl-11 pr-4 py-2.5 border-transparent focus:border-red-500 focus:ring-red-500 rounded-xl shadow-sm text-sm font-medium text-slate-700 bg-white transition-all">
                                </div>
                                <button type="submit" class="bg-slate-800 text-white px-6 py-2.5 rounded-xl hover:bg-slate-900 transition-all shadow-md font-bold text-sm active:scale-95 whitespace-nowrap">
                                    Cari
                                </button>
                                @if(request('search'))
                                    <a href="{{ route('orders.index') }}" class="bg-red-50 text-red-600 px-4 py-2.5 rounded-xl hover:bg-red-100 transition-all shadow-sm flex items-center justify-center" title="Reset">
                                        <i class="fas fa-times"></i>
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>

                    {{-- === TABEL PESANAN PREMIUM === --}}
                    <div class="overflow-x-auto rounded-2xl border border-slate-50">
                        <table class="min-w-full bg-white text-sm text-left">
                            <thead>
                                <tr class="bg-slate-50/80 text-slate-500 text-[10px] uppercase tracking-widest font-black border-b border-slate-100">
                                    <th class="py-5 px-6">ID Order & Tanggal</th>
                                    <th class="py-5 px-6">Total Belanja</th>
                                    <th class="py-5 px-6 text-center">Status Pembayaran</th>
                                    <th class="py-5 px-6 text-center">Status Barang</th>
                                    <th class="py-5 px-6 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50 font-medium text-slate-600">
                                @forelse($orders as $order)
                                <tr class="hover:bg-slate-50/50 transition-colors group">
                                    {{-- Kolom ID & Tanggal --}}
                                    <td class="py-4 px-6 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-red-100 group-hover:text-red-600 transition-colors">
                                                <i class="fas fa-box"></i>
                                            </div>
                                            <div>
                                                <p class="font-black text-slate-800 tracking-tight">#ORDER-{{ $order->id }}</p>
                                                <p class="text-[10px] text-slate-400 mt-0.5 font-bold uppercase"><i class="far fa-calendar-alt mr-1"></i> {{ $order->created_at->format('d M Y - H:i') }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Kolom Total --}}
                                    <td class="py-4 px-6">
                                        <p class="font-black text-slate-800">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                        <p class="text-[10px] text-slate-400 mt-0.5 font-bold">{{ $order->items_count ?? 'Berbagai' }} Item</p>
                                    </td>

                                    {{-- Kolom Status Pembayaran --}}
                                    <td class="py-4 px-6 text-center">
                                        @if($order->payment_status == 'paid')
                                            <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-600 px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest border border-emerald-100 shadow-sm">
                                                <i class="fas fa-check-circle"></i> Lunas
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 bg-rose-50 text-rose-600 px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest border border-rose-100 shadow-sm">
                                                <i class="fas fa-clock"></i> Belum Bayar
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Kolom Status Order/Barang --}}
                                    <td class="py-4 px-6 text-center">
                                        @php
                                            $status = $order->order_status;
                                            $badgeClass = '';
                                            $icon = '';
                                            $label = '';

                                            switch($status) {
                                                case 'pending':
                                                    $badgeClass = 'bg-amber-50 text-amber-600 border-amber-100';
                                                    $icon = 'fas fa-spinner fa-spin';
                                                    $label = 'Menunggu';
                                                    break;
                                                case 'processing':
                                                    $badgeClass = 'bg-blue-50 text-blue-600 border-blue-100';
                                                    $icon = 'fas fa-box-open';
                                                    $label = 'Diproses';
                                                    break;
                                                case 'shipped':
                                                    $badgeClass = 'bg-indigo-50 text-indigo-600 border-indigo-100';
                                                    $icon = 'fas fa-truck-fast';
                                                    $label = 'Dikirim';
                                                    break;
                                                case 'completed':
                                                    $badgeClass = 'bg-emerald-50 text-emerald-600 border-emerald-100';
                                                    $icon = 'fas fa-clipboard-check';
                                                    $label = 'Selesai';
                                                    break;
                                                case 'cancelled':
                                                    $badgeClass = 'bg-slate-100 text-slate-500 border-slate-200';
                                                    $icon = 'fas fa-times-circle';
                                                    $label = 'Dibatalkan';
                                                    break;
                                                default:
                                                    $badgeClass = 'bg-gray-100 text-gray-600 border-gray-200';
                                                    $icon = 'fas fa-circle';
                                                    $label = ucfirst($status);
                                            }
                                        @endphp
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest border shadow-sm {{ $badgeClass }}">
                                            <i class="{{ $icon }}"></i> {{ $label }}
                                        </span>
                                    </td>

                                    {{-- Kolom Aksi --}}
                                    <td class="py-4 px-6 text-center">
                                        <a href="{{ route('orders.show', $order->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-slate-50 text-slate-400 hover:bg-slate-800 hover:text-white transition-all shadow-sm group-hover:shadow" title="Lihat Detail">
                                            <i class="fas fa-eye text-xs"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-20">
                                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-200">
                                            <i class="fas fa-shopping-basket text-3xl"></i>
                                        </div>
                                        <h3 class="text-lg font-bold text-slate-700">Belum Ada Pesanan</h3>
                                        <p class="text-sm text-slate-400">Anda belum melakukan belanja stok bahan baku.</p>
                                        <a href="{{ route('mitra.shop') }}" class="inline-block mt-4 bg-red-600 text-white font-bold text-xs uppercase tracking-widest px-6 py-3 rounded-xl hover:bg-red-700 transition shadow-lg shadow-red-200">
                                            Belanja Sekarang
                                        </a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- PAGINATION --}}
                    <div class="mt-8">
                        {{ $orders->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
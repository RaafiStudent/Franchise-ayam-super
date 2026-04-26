<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-slate-800 leading-tight tracking-tight">
            {{ __('Kelola Pesanan Masuk') }}
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

            {{-- MAIN CONTAINER PREMIUM --}}
            <div class="bg-white rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 overflow-hidden">
                <div class="p-6 md:p-8 text-slate-900">
                    
                    {{-- === FITUR PENCARIAN & FILTER (REDESIGN PREMIUM) === --}}
                    <form method="GET" action="{{ route('admin.orders.index') }}" class="mb-8 flex flex-col md:flex-row justify-between items-center gap-4 bg-slate-50 p-4 rounded-2xl border border-slate-100">
                        
                        {{-- Dropdown Show Entries --}}
                        <div class="flex items-center gap-3 w-full md:w-auto">
                            <div class="w-10 h-10 bg-white rounded-xl shadow-sm flex items-center justify-center text-red-600 border border-slate-100">
                                <i class="fas fa-list-ul"></i>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Tampilkan</span>
                                <select name="per_page" onchange="this.form.submit()" class="border-transparent focus:border-red-500 focus:ring-red-500 rounded-xl shadow-sm text-sm font-bold text-slate-700 bg-white cursor-pointer hover:bg-slate-50 transition-colors py-2 pl-4 pr-8 appearance-none">
                                    <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                                </select>
                                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Data</span>
                            </div>
                        </div>

                        {{-- Search Bar Premium --}}
                        <div class="flex w-full md:w-auto gap-2">
                            <div class="relative w-full md:w-72">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-slate-400"></i>
                                </div>
                                <input type="text" name="search" value="{{ $search }}" placeholder="Cari ID / Nama Mitra..." class="w-full pl-11 pr-4 py-2.5 border-transparent focus:border-red-500 focus:ring-red-500 rounded-xl shadow-sm text-sm bg-white font-medium text-slate-700 transition-all placeholder-slate-400">
                            </div>
                            <button type="submit" class="bg-slate-800 text-white px-5 py-2.5 rounded-xl hover:bg-slate-900 transition-all shadow-md font-bold text-sm flex items-center gap-2 active:scale-95">
                                Cari
                            </button>
                            @if($search)
                                <a href="{{ route('admin.orders.index') }}" class="bg-red-100 text-red-600 px-5 py-2.5 rounded-xl hover:bg-red-200 transition-all shadow-sm font-bold text-sm flex items-center gap-2 active:scale-95">
                                    <i class="fas fa-times"></i> Reset
                                </a>
                            @endif
                        </div>
                    </form>
                    {{-- ========================================== --}}

                    {{-- TABEL PREMIUM --}}
                    <div class="overflow-x-auto rounded-2xl border border-slate-100">
                        <table class="min-w-full bg-white text-sm text-left">
                            <thead>
                                <tr class="bg-slate-50/80 text-slate-500 text-[10px] uppercase tracking-widest font-black border-b border-slate-100">
                                    <th class="py-5 px-6 rounded-tl-2xl">Pesanan & Mitra</th>
                                    <th class="py-5 px-6">Total & Pembayaran</th>
                                    <th class="py-5 px-6 text-center">Status Logistik</th>
                                    <th class="py-5 px-6 text-left rounded-tr-2xl">Aksi / Tindakan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50 font-medium">
                                @forelse($orders as $order)
                                <tr class="hover:bg-slate-50/50 transition-colors group">
                                    
                                    {{-- Kolom 1: ID, Nama & Alamat Lengkap (BARU) --}}
                                    <td class="py-5 px-6 align-top">
                                        <div class="flex flex-col">
                                            <div class="flex items-center gap-2 mb-1">
                                                <span class="px-2 py-0.5 rounded-md bg-red-50 text-red-700 font-black text-xs tracking-tight">#ORDER-{{ $order->id }}</span>
                                                <span class="text-[10px] text-slate-400 font-semibold"><i class="far fa-clock"></i> {{ $order->created_at->format('d M Y H:i') }}</span>
                                            </div>
                                            
                                            <div class="mt-2 flex items-center gap-2">
                                                <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center shrink-0 border border-slate-200">
                                                    <i class="fas fa-store text-xs"></i>
                                                </div>
                                                <span class="font-extrabold text-slate-800 text-sm">{{ $order->user->name }}</span>
                                            </div>

                                            {{-- FIX: KARTU ALAMAT LENGKAP --}}
                                            <div class="mt-3 flex items-start gap-2 bg-slate-50/80 p-3 rounded-xl border border-slate-100 w-full max-w-xs group-hover:bg-white transition-colors">
                                                <div class="w-5 h-5 rounded-full bg-red-100 text-red-500 flex items-center justify-center shrink-0 mt-0.5">
                                                    <i class="fas fa-map-marker-alt text-[10px]"></i>
                                                </div>
                                                <div class="leading-snug">
                                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-wider mb-0.5">Lokasi Pengiriman</p>
                                                    @if($order->user->alamat_lengkap)
                                                        <span class="text-[11px] text-slate-700 font-bold">{{ $order->user->alamat_lengkap }}, {{ $order->user->kota }}, {{ $order->user->provinsi }}</span>
                                                    @else
                                                        <span class="text-[11px] text-red-500 italic font-bold">Alamat belum dilengkapi!</span>
                                                    @endif
                                                </div>
                                            </div>

                                        </div>
                                    </td>

                                    {{-- Kolom 2: Uang & Badges Livin Style --}}
                                    <td class="py-5 px-6 align-top">
                                        <div class="font-black text-slate-900 text-lg tracking-tight mb-2">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                                        <div>
                                            @if($order->payment_status == 'paid')
                                                <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-600 py-1.5 px-3 rounded-lg text-[10px] font-black uppercase tracking-widest border border-emerald-200/60 shadow-sm">
                                                    <i class="fas fa-check-circle"></i> Lunas
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-600 py-1.5 px-3 rounded-lg text-[10px] font-black uppercase tracking-widest border border-amber-200/60 shadow-sm">
                                                    <i class="fas fa-clock"></i> Belum Lunas
                                                </span>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- Kolom 3: Status Logistik --}}
                                    <td class="py-5 px-6 text-center align-top">
                                        <div class="flex justify-center mt-1">
                                            @if($order->order_status == 'pending')
                                                <span class="bg-slate-100 text-slate-500 py-1.5 px-4 rounded-xl text-xs font-bold shadow-sm inline-block w-full max-w-[130px]">Menunggu Bayar</span>
                                            @elseif($order->order_status == 'processing')
                                                <span class="bg-blue-50 border border-blue-200 text-blue-600 py-1.5 px-4 rounded-xl text-xs font-black shadow-sm shadow-blue-100 inline-block w-full max-w-[130px] animate-pulse">
                                                    PERLU DIKIRIM
                                                </span>
                                            @elseif($order->order_status == 'shipped')
                                                <div class="flex flex-col items-center">
                                                    <span class="bg-amber-50 border border-amber-200 text-amber-600 py-1.5 px-4 rounded-xl text-xs font-black shadow-sm mb-2 w-full max-w-[130px]">
                                                        <i class="fas fa-truck-fast"></i> DIKIRIM
                                                    </span>
                                                    <div class="text-[10px] font-mono bg-white p-2 rounded-lg border border-slate-200 shadow-sm w-full max-w-[130px]">
                                                        <span class="font-bold text-slate-700 block border-b border-slate-100 pb-1 mb-1">{{ $order->courier_name }}</span>
                                                        <span class="text-slate-500">{{ $order->resi_number }}</span>
                                                    </div>
                                                </div>
                                            @elseif($order->order_status == 'completed')
                                                <span class="bg-emerald-500 text-white py-1.5 px-4 rounded-xl text-xs font-black shadow-md shadow-emerald-200 inline-block w-full max-w-[130px]">
                                                    SELESAI
                                                </span>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- Kolom 4: Form Input Resi Shopee Style --}}
                                    <td class="py-5 px-6 align-top">
                                        @if($order->payment_status == 'paid' && $order->order_status == 'processing')
                                            <form action="{{ route('admin.orders.ship', $order->id) }}" method="POST" class="bg-slate-50 p-4 rounded-2xl border border-slate-200/60 shadow-inner max-w-xs relative overflow-hidden group-hover:bg-white transition-colors">
                                                <div class="absolute -right-4 -top-4 w-16 h-16 bg-blue-100 rounded-full blur-xl opacity-50"></div>
                                                @csrf
                                                @method('PATCH')
                                                <div class="mb-3 relative z-10">
                                                    <input type="text" name="courier_name" class="w-full text-xs border-slate-200 bg-white rounded-xl focus:ring-red-500 focus:border-red-500 shadow-sm py-2 px-3 font-medium placeholder-slate-400" placeholder="Nama Kurir / Supir" required>
                                                </div>
                                                <div class="mb-3 relative z-10">
                                                    <input type="text" name="resi_number" class="w-full text-xs border-slate-200 bg-white rounded-xl focus:ring-red-500 focus:border-red-500 shadow-sm py-2 px-3 font-medium placeholder-slate-400" placeholder="No. Resi / Plat Nomor" required>
                                                </div>
                                                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white text-[11px] font-extrabold tracking-wider py-2.5 rounded-xl transition-all shadow-md shadow-blue-500/30 flex items-center justify-center gap-2 active:scale-95 relative z-10">
                                                    <i class="fas fa-paper-plane"></i> KIRIM BARANG
                                                </button>
                                            </form>
                                        @elseif($order->order_status == 'shipped')
                                            <div class="bg-amber-50 rounded-xl p-3 text-center border border-amber-100">
                                                <i class="fas fa-hourglass-half text-amber-500 mb-1 text-lg animate-spin-slow"></i>
                                                <p class="text-[10px] text-amber-700 font-bold uppercase tracking-wider">Menunggu Mitra</p>
                                            </div>
                                        @elseif($order->order_status == 'completed')
                                            <div class="bg-emerald-50 rounded-xl p-3 text-center border border-emerald-100">
                                                <i class="fas fa-check-square text-emerald-500 mb-1 text-lg"></i>
                                                <p class="text-[10px] text-emerald-700 font-bold uppercase tracking-wider">Transaksi Beres</p>
                                            </div>
                                        @else
                                            <div class="bg-slate-50 rounded-xl p-3 text-center border border-slate-100">
                                                <i class="fas fa-wallet text-slate-300 mb-1 text-lg"></i>
                                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Menunggu Bayar</p>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-16">
                                        <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <i class="fas fa-box-open text-4xl text-slate-300"></i>
                                        </div>
                                        <h3 class="text-lg font-bold text-slate-700 mb-1">Tidak Ada Pesanan</h3>
                                        <p class="text-sm text-slate-400">Data pesanan yang Anda cari tidak ditemukan.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- === PAGINATION LINKS === --}}
                    <div class="mt-6">
                        {{ $orders->links() }}
                    </div>
                    {{-- =========================================== --}}

                </div>
            </div>
        </div>
    </div>
    
    {{-- CSS Khusus untuk animasi halus --}}
    <style>
        .animate-bounce-in { animation: bounceIn 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards; }
        @keyframes bounceIn {
            0% { transform: scale(0.9); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
        .animate-spin-slow { animation: spin 3s linear infinite; }
    </style>
</x-app-layout>
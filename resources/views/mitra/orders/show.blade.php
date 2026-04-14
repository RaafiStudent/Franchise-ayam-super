<x-app-layout>
    {{-- Import Font Modern --}}
    <head>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
        <style>
            body { font-family: 'Inter', sans-serif; }
        </style>
    </head>

    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <nav class="flex mb-2" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3 text-xs font-semibold uppercase tracking-widest">
                        <li class="inline-flex items-center">
                            <a href="{{ route('orders.index') }}" class="text-slate-400 hover:text-red-600 transition-colors">Riwayat</a>
                        </li>
                        <li>
                            <div class="flex items-center text-slate-300">
                                <i class="fas fa-chevron-right text-[8px] mx-2"></i>
                                <span class="text-slate-400">Invoice</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h2 class="font-extrabold text-2xl text-slate-800 leading-tight">
                    Invoice <span class="text-red-600">#ORDER-{{ $order->id }}</span>
                </h2>
            </div>

            {{-- Status Badge Premium --}}
            <div class="flex items-center gap-3">
                @if($order->payment_status == 'paid')
                    <span class="bg-emerald-50 text-emerald-600 text-[10px] font-black px-4 py-2 rounded-xl border border-emerald-100 uppercase tracking-widest flex items-center gap-2">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        Paid Successfully
                    </span>
                @else
                    <span class="bg-amber-50 text-amber-600 text-[10px] font-black px-4 py-2 rounded-xl border border-amber-100 uppercase tracking-widest flex items-center gap-2 shadow-sm">
                        <i class="fas fa-clock animate-pulse"></i> Waiting for Payment
                    </span>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50/50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            {{-- MAIN INVOICE CARD --}}
            <div class="bg-white rounded-[3rem] shadow-[0_20px_50px_rgba(0,0,0,0.05)] border border-slate-100 overflow-hidden relative">
                
                {{-- Decorative Element --}}
                <div class="absolute top-0 right-0 w-64 h-64 bg-red-50/50 rounded-full -mr-32 -mt-32 blur-3xl"></div>

                <div class="p-8 md:p-12 relative z-10">
                    
                    {{-- Header Invoice --}}
                    <div class="flex flex-col md:flex-row justify-between gap-8 mb-16">
                        <div class="space-y-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-red-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-red-200">
                                    <i class="fas fa-file-invoice text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] leading-none">Tanggal Transaksi</p>
                                    <p class="text-slate-800 font-bold mt-1">{{ $order->created_at->translatedFormat('d F Y, H:i') }} WIB</p>
                                </div>
                            </div>
                        </div>

                        <div class="text-left md:text-right">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Kepada Yth.</p>
                            <p class="text-xl font-black text-slate-800 tracking-tight">{{ Auth::user()->name }}</p>
                            <p class="text-sm text-slate-500 font-medium italic">Mitra Resmi Ayam Super</p>
                        </div>
                    </div>

                    {{-- Table Section --}}
                    <div class="mb-12">
                        <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest mb-6 flex items-center gap-2">
                            <i class="fas fa-list-ul text-red-600"></i> Rincian Belanja Stok
                        </h3>
                        
                        <div class="overflow-hidden rounded-3xl border border-slate-50 shadow-sm">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-slate-50 text-slate-400 text-[10px] font-black uppercase tracking-widest">
                                        <th class="px-8 py-5">Item Produk</th>
                                        <th class="px-8 py-5 text-center">Jumlah</th>
                                        <th class="px-8 py-5 text-right">Harga Satuan</th>
                                        <th class="px-8 py-5 text-right">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    @foreach($order->items as $item)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-8 py-6">
                                            <div class="flex items-center gap-4">
                                                <div class="w-10 h-10 bg-slate-100 rounded-xl flex items-center justify-center text-slate-400">
                                                    <i class="fas fa-box"></i>
                                                </div>
                                                <span class="font-bold text-slate-700">{{ $item->product->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-8 py-6 text-center font-bold text-slate-600 bg-slate-50/20">
                                            {{ $item->quantity }}
                                        </td>
                                        <td class="px-8 py-6 text-right font-medium text-slate-500">
                                            Rp {{ number_format($item->price, 0, ',', '.') }}
                                        </td>
                                        <td class="px-8 py-6 text-right font-black text-slate-800">
                                            Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Total Tagihan Section --}}
                    <div class="flex flex-col items-end space-y-3">
                        <div class="bg-[#a51a1a]/5 p-6 md:p-8 rounded-[2rem] border border-red-50 flex flex-col items-end min-w-[300px]">
                            <p class="text-[10px] font-black text-red-700/60 uppercase tracking-[0.3em] mb-1">Total Tagihan Anda</p>
                            <h4 class="text-4xl font-black text-[#a51a1a] tracking-tighter">
                                <span class="text-xl">Rp</span> {{ number_format($order->total_price, 0, ',', '.') }}
                            </h4>
                        </div>
                        <p class="text-[10px] text-slate-400 italic font-medium">Selesaikan pembayaran untuk memproses pengiriman bahan baku.</p>
                    </div>

                </div>

                {{-- Action Buttons --}}
                <div class="bg-slate-50/80 p-8 flex flex-col md:flex-row items-center justify-between gap-4 border-t border-slate-100">
                    <div class="flex items-center gap-3">
                        <a href="{{ route('orders.index') }}" class="group px-6 py-3 bg-white text-slate-600 rounded-2xl font-bold text-sm shadow-sm hover:shadow-md border border-slate-200 transition-all flex items-center gap-2">
                            <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i> Kembali
                        </a>
                        <a href="{{ route('orders.invoice', $order->id) }}" target="_blank" class="px-6 py-3 bg-slate-800 text-white rounded-2xl font-bold text-sm shadow-lg hover:bg-black transition-all flex items-center gap-2">
                            <i class="fas fa-print"></i> Cetak Invoice
                        </a>
                    </div>

                    @if($order->payment_status == 'unpaid')
                        <button id="pay-button" class="w-full md:w-auto px-10 py-4 bg-gradient-to-r from-red-700 to-red-600 text-white rounded-[1.5rem] font-black text-base shadow-[0_15px_30px_rgba(185,28,28,0.3)] hover:scale-105 active:scale-95 transition-all flex items-center justify-center gap-3">
                            <i class="fas fa-credit-card"></i> BAYAR SEKARANG
                        </button>
                    @else
                        <div class="px-8 py-4 bg-emerald-500 text-white rounded-2xl font-black text-sm flex items-center gap-2">
                            <i class="fas fa-check-double"></i> PESANAN SUDAH TERBAYAR
                        </div>
                    @endif
                </div>
            </div>

            {{-- FOOTER INFO --}}
            <div class="mt-8 text-center px-10">
                <p class="text-xs text-slate-400 font-medium leading-relaxed">
                    Invoice ini dihasilkan secara otomatis oleh <strong>Sistem SCM Ayam Super</strong>.<br>
                    Harap simpan bukti pembayaran jika melakukan transfer manual, atau hubungi Admin jika ada kendala.
                </p>
            </div>

        </div>
    </div>

    {{-- Script Midtrans Tetap Sama (Sesuaikan ID) --}}
    @if($order->payment_status == 'unpaid')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script type="text/javascript">
        const payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            window.snap.pay('{{ $order->snap_token }}', {
                onSuccess: function (result) { window.location.href = "{{ route('orders.index') }}"; },
                onPending: function (result) { alert("Menunggu pembayaran!"); },
                onError: function (result) { alert("Pembayaran gagal!"); }
            });
        });
    </script>
    @endif
</x-app-layout>
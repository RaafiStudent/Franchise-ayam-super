<x-app-layout>
    <head>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
        <style>body { font-family: 'Inter', sans-serif; }</style>
    </head>

    <div class="py-8 bg-slate-50/50 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            
            {{-- HEADER RINGKAS --}}
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 px-4 md:px-0">
                <div class="flex items-center gap-4">
                    <a href="{{ route('orders.index') }}" class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-slate-400 hover:text-red-600 shadow-sm transition-all border border-slate-100">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div>
                        <h2 class="text-xl font-black text-slate-800 tracking-tight">Invoice <span class="text-red-600">#{{ $order->id }}</span></h2>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ $order->created_at->translatedFormat('d F Y, H:i') }} WIB</p>
                    </div>
                </div>
                
                <div class="mt-4 md:mt-0">
                    @if($order->payment_status == 'paid')
                        <span class="bg-emerald-100 text-emerald-700 text-[10px] font-black px-4 py-2 rounded-xl border border-emerald-200 uppercase tracking-widest flex items-center gap-2">
                            <i class="fas fa-check-circle"></i> Paid Successfully
                        </span>
                    @else
                        <span class="bg-amber-100 text-amber-700 text-[10px] font-black px-4 py-2 rounded-xl border border-amber-200 uppercase tracking-widest flex items-center gap-2">
                            <i class="fas fa-clock animate-pulse"></i> Awaiting Payment
                        </span>
                    @endif
                </div>
            </div>

            {{-- ======================================================== --}}
            {{-- FITUR BARU: BANNER INFORMASI STATUS LOGISTIK (DINAMIS) --}}
            {{-- ======================================================== --}}
            <div class="mb-8 px-4 md:px-0">
                @if($order->payment_status === 'paid' && $order->order_status === 'processing')
                    <div class="bg-blue-50 border border-blue-100 p-5 rounded-[1.5rem] shadow-sm">
                        <div class="flex gap-4 items-center">
                            <div class="w-12 h-12 bg-blue-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-blue-200 shrink-0">
                                <i class="fas fa-box-open text-xl"></i>
                            </div>
                            <div>
                                <h4 class="text-blue-900 font-extrabold text-sm uppercase tracking-tight">Pesanan Sedang Disiapkan 📦</h4>
                                <p class="text-blue-700/80 text-xs font-medium leading-relaxed mt-0.5">
                                    Tim Admin Ayam Super sedang menyiapkan dan mengemas paket Anda agar aman selama perjalanan. Mohon ditunggu ya!
                                </p>
                            </div>
                        </div>
                    </div>

                @elseif($order->order_status === 'shipped')
                    <div class="bg-amber-50 border border-amber-100 p-5 rounded-[1.5rem] shadow-sm">
                        <div class="flex gap-4 items-center">
                            <div class="w-12 h-12 bg-amber-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-amber-200 shrink-0 animate-bounce">
                                <i class="fas fa-truck-moving text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-amber-900 font-extrabold text-sm uppercase tracking-tight">Pesanan Dalam Perjalanan 🚚</h4>
                                <p class="text-amber-800/80 text-xs font-medium leading-relaxed mt-0.5">
                                    Paket Anda sedang dikirim oleh <strong>{{ $order->courier_name }}</strong> (Resi: {{ $order->resi_number }}).
                                    Jika barang sudah sampai, mohon klik <strong>Tombol Centang Hijau (Selesai)</strong> di halaman Riwayat Pesanan.
                                </p>
                            </div>
                        </div>
                    </div>

                @elseif($order->order_status === 'completed')
                    <div class="bg-emerald-50 border border-emerald-100 p-5 rounded-[1.5rem] shadow-sm">
                        <div class="flex gap-4 items-center">
                            <div class="w-12 h-12 bg-emerald-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-emerald-200 shrink-0">
                                <i class="fas fa-check-double text-xl"></i>
                            </div>
                            <div>
                                <h4 class="text-emerald-900 font-extrabold text-sm uppercase tracking-tight">Pesanan Diterima ✅</h4>
                                <p class="text-emerald-800/80 text-xs font-medium leading-relaxed mt-0.5">
                                    Terima kasih telah melakukan restock! Barang telah sampai dan diterima dengan baik. Stok cabang Anda otomatis terupdate.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            {{-- ======================================================== --}}

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- KOLOM KIRI: RINCIAN PRODUK --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
                        <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
                            <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest">Rincian Barang</h3>
                            <i class="fas fa-box text-slate-300"></i>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <tbody class="divide-y divide-slate-50">
                                    @foreach($order->items as $item)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-8 py-4">
                                            <p class="font-bold text-slate-700">{{ $item->product->name }}</p>
                                            <p class="text-[10px] text-slate-400 font-medium">Qty: {{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                        </td>
                                        <td class="px-8 py-4 text-right font-black text-slate-800">
                                            Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100 flex flex-col md:flex-row justify-between items-center gap-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-400">
                                <i class="fas fa-user-circle text-2xl"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none">Penerima</p>
                                <p class="text-slate-800 font-extrabold mt-1">{{ Auth::user()->name }}</p>
                            </div>
                        </div>
                        <div class="h-10 w-[1px] bg-slate-100 hidden md:block"></div>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-400">
                                <i class="fas fa-map-marker-alt text-2xl"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none">Lokasi Pengiriman</p>
                                <p class="text-slate-800 font-extrabold mt-1 italic text-sm">Alamat Terdaftar di Cabang</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN: RINGKASAN PEMBAYARAN (STICKY) --}}
                <div class="lg:col-span-1 px-4 md:px-0">
                    <div class="sticky top-8 space-y-4">
                        <div class="bg-white rounded-[2.5rem] p-8 shadow-xl shadow-slate-200/50 border border-slate-50 relative overflow-hidden">
                            {{-- Dekorasi Gradient --}}
                            <div class="absolute -top-10 -right-10 w-32 h-32 bg-red-50 rounded-full blur-2xl"></div>
                            
                            <div class="relative z-10">
                                <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6">Ringkasan Tagihan</h3>
                                
                                <div class="space-y-3 mb-6">
                                    <div class="flex justify-between text-sm font-medium text-slate-500">
                                        <span>Subtotal</span>
                                        <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm font-medium text-slate-500">
                                        <span>Biaya Admin</span>
                                        <span class="text-emerald-500 font-bold">FREE</span>
                                    </div>
                                    <div class="pt-4 border-t border-slate-50 flex justify-between items-end">
                                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Bayar</span>
                                        <span class="text-2xl font-black text-[#a51a1a] tracking-tighter">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                                    </div>
                                </div>

                                @if($order->payment_status == 'unpaid')
                                    <button id="pay-button" class="w-full py-4 bg-[#a51a1a] text-white rounded-2xl font-black text-sm shadow-lg shadow-red-200 hover:bg-red-700 active:scale-95 transition-all flex items-center justify-center gap-2 mb-3 uppercase tracking-widest">
                                        <i class="fas fa-wallet"></i> Bayar Sekarang
                                    </button>
                                @endif
                                
                                <a href="{{ route('orders.invoice', $order->id) }}" target="_blank" class="w-full py-3 bg-slate-50 text-slate-600 rounded-xl font-bold text-[10px] flex items-center justify-center gap-2 hover:bg-slate-100 transition-colors uppercase tracking-widest">
                                    <i class="fas fa-print"></i> Simpan / Cetak PDF
                                </a>
                            </div>
                        </div>

                        {{-- Info Tambahan --}}
                        <div class="bg-red-50/50 rounded-2xl p-4 border border-red-100/50">
                            <p class="text-[10px] text-red-700/70 font-medium leading-relaxed">
                                <i class="fas fa-info-circle mr-1"></i> Pembayaran menggunakan Midtrans akan terverifikasi secara otomatis oleh sistem.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Script Midtrans --}}
    @if($order->payment_status == 'unpaid')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function () {
            window.snap.pay('{{ $order->snap_token }}', {
                onSuccess: function (result) { window.location.href = "{{ route('orders.index') }}"; },
                onPending: function (result) { alert("Menunggu pembayaran!"); },
                onError: function (result) { alert("Pembayaran gagal!"); }
            });
        };
    </script>
    @endif
</x-app-layout>
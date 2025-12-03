<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Invoice: ') }} #ORDER-{{ $order->id }}
            </h2>
            {{-- Badge Status di Pojok Kanan Atas --}}
            <span class="px-4 py-2 rounded-full text-sm font-bold 
                @if($order->payment_status == 'paid') bg-green-100 text-green-700 
                @elseif($order->payment_status == 'unpaid') bg-yellow-100 text-yellow-700 
                @else bg-red-100 text-red-700 @endif">
                {{ strtoupper($order->payment_status) }}
            </span>
        </div>
    </x-slot>

    {{-- Script Midtrans --}}
    <head>
        <script type="text/javascript"
            src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('midtrans.client_key') }}"></script>
    </head>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                {{-- 1. INFO UMUM (Tanggal & Pelanggan) --}}
                <div class="grid grid-cols-2 gap-4 mb-8 border-b pb-6">
                    <div>
                        <p class="text-gray-500 text-sm">Tanggal Order</p>
                        <p class="font-bold text-gray-800">{{ $order->created_at->format('d M Y, H:i') }} WIB</p>
                    </div>
                    <div class="text-right">
                        <p class="text-gray-500 text-sm">Kepada Yth.</p>
                        <p class="font-bold text-gray-800">{{ $order->user->name }}</p>
                        <p class="text-sm text-gray-600">{{ $order->user->no_hp }}</p>
                    </div>
                </div>

                {{-- 2. INFO PENGIRIMAN (Hanya Muncul Jika Sudah Dikirim) --}}
                @if($order->order_status == 'shipped' || $order->order_status == 'completed')
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-8">
                    <h3 class="font-bold text-blue-800 mb-2"><i class="fas fa-shipping-fast mr-2"></i>Info Pengiriman</h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-blue-600">Kurir / Ekspedisi</p>
                            <p class="font-bold text-gray-800">{{ $order->courier_name }}</p>
                        </div>
                        <div>
                            <p class="text-blue-600">Nomor Resi / Plat</p>
                            <p class="font-bold text-gray-800">{{ $order->resi_number }}</p>
                        </div>
                    </div>
                </div>
                @endif

                {{-- 3. TABEL RINCIAN BARANG --}}
                <div class="mb-8">
                    <h3 class="font-bold text-gray-700 mb-3">Rincian Pesanan</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="py-2 px-4 text-left">Produk</th>
                                    <th class="py-2 px-4 text-center">Jumlah</th>
                                    <th class="py-2 px-4 text-right">Harga Satuan</th>
                                    <th class="py-2 px-4 text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($order->items as $item)
                                <tr>
                                    <td class="py-3 px-4">{{ $item->product->name }}</td>
                                    <td class="py-3 px-4 text-center">{{ $item->quantity }}</td>
                                    <td class="py-3 px-4 text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="py-3 px-4 text-right font-bold">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50 font-bold">
                                <tr>
                                    <td colspan="3" class="py-3 px-4 text-right text-gray-600">Total Tagihan</td>
                                    <td class="py-3 px-4 text-right text-red-600 text-lg">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                {{-- 4. TOMBOL AKSI (Update Terpenting Ada Di Sini) --}}
                <div class="flex justify-between items-center pt-6 border-t border-gray-100">
                    
                    {{-- KELOMPOK TOMBOL KIRI (Kembali & Cetak PDF) --}}
                    <div class="flex gap-3">
                        <a href="{{ route('orders.index') }}" class="text-gray-600 hover:text-gray-900 text-sm font-medium px-4 py-2 border border-gray-300 rounded-lg flex items-center transition hover:bg-gray-50">
                            <i class="fas fa-arrow-left mr-2"></i> Kembali
                        </a>

                        {{-- TOMBOL CETAK PDF (BARU) --}}
                        <a href="{{ route('orders.invoice', $order->id) }}" class="bg-gray-800 text-white text-sm font-bold px-4 py-2 rounded-lg hover:bg-gray-900 transition flex items-center shadow-md transform active:scale-95">
                            <i class="fas fa-print mr-2"></i> Cetak Invoice
                        </a>
                    </div>

                    {{-- KELOMPOK TOMBOL KANAN (Bayar / Status) --}}
                    <div>
                        {{-- Jika Belum Bayar -> Muncul Tombol Bayar --}}
                        @if($order->payment_status == 'unpaid')
                            <button id="pay-button" class="bg-red-600 text-white font-bold py-2 px-6 rounded-lg shadow-lg hover:bg-red-700 transition transform hover:-translate-y-0.5 active:scale-95 flex items-center">
                                <i class="fas fa-credit-card mr-2"></i> BAYAR SEKARANG
                            </button>
                        
                        {{-- Jika Sudah Lunas -> Muncul Info --}}
                        @else
                            <div class="text-green-600 font-bold flex items-center gap-2 bg-green-50 px-4 py-2 rounded-lg border border-green-200">
                                <i class="fas fa-check-circle text-xl"></i>
                                <span>Pembayaran Lunas</span>
                            </div>
                        @endif
                    </div>

                </div>

            </div>
        </div>
    </div>

    {{-- SCRIPT MIDTRANS (Hanya aktif jika tombol ada) --}}
    @if($order->payment_status == 'unpaid')
    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            window.snap.pay('{{ $order->snap_token }}', {
                onSuccess: function(result){ alert("Pembayaran Berhasil!"); window.location.reload(); },
                onPending: function(result){ alert("Menunggu Pembayaran!"); window.location.reload(); },
                onError: function(result){ alert("Pembayaran Gagal!"); },
                onClose: function(){ alert('Anda menutup popup tanpa menyelesaikan pembayaran'); }
            });
        });
    </script>
    @endif

</x-app-layout>
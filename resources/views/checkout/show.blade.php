<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Invoice: ') }} #ORDER-{{ $order->id }}
            </h2>
            
            <div class="flex gap-2">
                {{-- 1. BADGE STATUS PEMBAYARAN --}}
                <span class="px-4 py-2 rounded-full text-sm font-bold
                    @if($order->payment_status == 'paid') bg-green-100 text-green-700
                    @elseif($order->payment_status == 'unpaid') bg-yellow-100 text-yellow-700
                    @else bg-red-100 text-red-700 @endif">
                    {{ strtoupper($order->payment_status) }}
                </span>

                {{-- 2. BADGE STATUS BARANG (BARU - FITUR YANG BOSS MINTA) --}}
                @if($order->order_status == 'shipped')
                    <span class="px-4 py-2 rounded-full text-sm font-bold bg-purple-100 text-purple-700">
                        <i class="fas fa-truck mr-1"></i> SEDANG DIKIRIM
                    </span>
                @elseif($order->order_status == 'completed')
                    <span class="px-4 py-2 rounded-full text-sm font-bold bg-green-100 text-green-700 border border-green-200">
                        <i class="fas fa-check-circle mr-1"></i> DITERIMA
                    </span>
                @elseif($order->order_status == 'processing')
                    <span class="px-4 py-2 rounded-full text-sm font-bold bg-blue-100 text-blue-700">
                        <i class="fas fa-box mr-1"></i> DIKEMAS
                    </span>
                @endif
            </div>
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

                {{-- INFO UMUM --}}
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

                {{-- INFO PENGIRIMAN (Jika Ada) --}}
                @if($order->order_status == 'shipped' || $order->order_status == 'completed')
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-8">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-bold text-blue-800 mb-2"><i class="fas fa-shipping-fast mr-2"></i>Info Pengiriman</h3>
                            <div class="grid grid-cols-2 gap-8 text-sm">
                                <div>
                                    <p class="text-blue-600">Kurir / Ekspedisi</p>
                                    <p class="font-bold text-gray-800 uppercase">{{ $order->courier_name }}</p>
                                </div>
                                <div>
                                    <p class="text-blue-600">Nomor Resi / Plat</p>
                                    <p class="font-bold text-gray-800 uppercase">{{ $order->resi_number }}</p>
                                </div>
                            </div>
                        </div>
                        
                        {{-- STATUS BESAR DI DALAM KOTAK PENGIRIMAN --}}
                        <div class="text-right">
                            <p class="text-xs text-blue-500 mb-1">Status Paket:</p>
                            @if($order->order_status == 'completed')
                                <span class="text-xl font-bold text-green-600">SUDAH DITERIMA ✅</span>
                            @else
                                <span class="text-xl font-bold text-purple-600">DALAM PERJALANAN 🚚</span>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                {{-- TABEL BARANG --}}
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

                {{-- TOMBOL AKSI --}}
                <div class="flex justify-between items-center pt-6 border-t border-gray-100">
                    <div class="flex gap-2">
                        <a href="{{ route('orders.index') }}" class="text-gray-500 hover:text-gray-800 text-sm font-medium px-4 py-2 border rounded-lg">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                        </a>

                            {{-- Tambahkan target="_blank" agar buka tab baru --}}
<a href="{{ route('orders.invoice', $order->id) }}" target="_blank" class="bg-gray-800 text-white text-sm font-bold px-4 py-2 rounded-lg hover:bg-gray-900 transition flex items-center">
    <i class="fas fa-print mr-2"></i> Cetak Invoice
</a>
                    </div>

                    {{-- JIKA UNPAID: TOMBOL BAYAR --}}
                    @if($order->payment_status == 'unpaid')
                        <button id="pay-button" class="bg-red-600 text-white font-bold py-3 px-8 rounded-full shadow-lg hover:bg-red-700 transition transform hover:scale-105">
                            BAYAR SEKARANG
                        </button>
                    
                    {{-- JIKA SEDANG DIKIRIM: TOMBOL TERIMA --}}
                    @elseif($order->order_status == 'shipped')
                        <form action="{{ route('orders.complete', $order->id) }}" method="POST" onsubmit="return confirm('Barang sudah sampai?');">
                            @csrf
                            @method('PATCH')
                            <button class="bg-green-600 text-white font-bold py-3 px-8 rounded-full shadow-lg hover:bg-green-700 transition transform hover:scale-105 flex items-center">
                                <i class="fas fa-check-double mr-2"></i> KONFIRMASI TERIMA BARANG
                            </button>
                        </form>

                    {{-- JIKA SELESAI --}}
                    @elseif($order->order_status == 'completed')
                        <div class="text-green-600 font-bold flex items-center gap-2 border border-green-200 bg-green-50 px-4 py-2 rounded-lg">
                            <i class="fas fa-check-circle text-xl"></i>
                            <span>PESANAN SELESAI</span>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

    {{-- Script Midtrans --}}
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
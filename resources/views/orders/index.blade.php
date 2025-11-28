<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Pesanan Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if($orders->isEmpty())
                    <div class="text-center py-10">
                        <p class="text-gray-500">Belum ada riwayat pesanan.</p>
                        <a href="{{ route('dashboard') }}" class="text-red-600 font-bold hover:underline mt-2 inline-block">Mulai Belanja</a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead>
                                <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">Order ID</th>
                                    <th class="py-3 px-6 text-left">Tanggal</th>
                                    <th class="py-3 px-6 text-left">Total</th>
                                    <th class="py-3 px-6 text-center">Status Pembayaran</th>
                                    <th class="py-3 px-6 text-center">Status Barang</th>
                                    <th class="py-3 px-6 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                @foreach($orders as $order)
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="py-3 px-6 text-left whitespace-nowrap font-bold">
                                        #{{ $order->id }}
                                    </td>
                                    <td class="py-3 px-6 text-left">
                                        {{ $order->created_at->format('d M Y H:i') }}
                                    </td>
                                    <td class="py-3 px-6 text-left font-bold text-gray-800">
                                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                    </td>
                                    
                                    {{-- Status Pembayaran --}}
                                    <td class="py-3 px-6 text-center">
                                        @if($order->payment_status == 'paid')
                                            <span class="bg-green-200 text-green-700 py-1 px-3 rounded-full text-xs font-bold">Lunas</span>
                                        @elseif($order->payment_status == 'unpaid')
                                            <span class="bg-yellow-200 text-yellow-700 py-1 px-3 rounded-full text-xs font-bold">Belum Bayar</span>
                                        @else
                                            <span class="bg-red-200 text-red-700 py-1 px-3 rounded-full text-xs font-bold">{{ ucfirst($order->payment_status) }}</span>
                                        @endif
                                    </td>

                                    {{-- Status Pengiriman --}}
                                    <td class="py-3 px-6 text-center">
                                        @if($order->order_status == 'pending')
                                            <span class="bg-gray-200 text-gray-600 py-1 px-3 rounded-full text-xs">Menunggu</span>
                                        @elseif($order->order_status == 'processing')
                                            <span class="bg-blue-200 text-blue-700 py-1 px-3 rounded-full text-xs font-bold">Sedang Dikemas</span>
                                        @elseif($order->order_status == 'shipped')
                                            <span class="bg-purple-200 text-purple-700 py-1 px-3 rounded-full text-xs font-bold">Dikirim</span>
                                            <div class="text-[10px] mt-1 text-gray-500">Resi: {{ $order->resi_number ?? '-' }}</div>
                                        @elseif($order->order_status == 'completed')
                                            <span class="bg-green-200 text-green-700 py-1 px-3 rounded-full text-xs font-bold">Selesai</span>
                                        @endif
                                    </td>

                                    <td class="py-3 px-6 text-center">
                                        <div class="flex item-center justify-center gap-2">
                                            {{-- Tombol Detail --}}
                                            <a href="{{ route('checkout.show', $order->id) }}" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-600" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            {{-- Tombol Bayar (Kalau Belum Bayar) --}}
                                            @if($order->payment_status == 'unpaid')
                                                <a href="{{ route('checkout.show', $order->id) }}" class="w-8 h-8 rounded-full bg-red-100 hover:bg-red-200 flex items-center justify-center text-red-600" title="Bayar Sekarang">
                                                    <i class="fas fa-credit-card"></i>
                                                </a>
                                            @endif

                                            {{-- Tombol Terima Barang (Kalau Sedang Dikirim) --}}
                                            @if($order->order_status == 'shipped')
                                                <form action="{{ route('orders.complete', $order->id) }}" method="POST" onsubmit="return confirm('Barang sudah sampai?');">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="w-8 h-8 rounded-full bg-green-100 hover:bg-green-200 flex items-center justify-center text-green-600" title="Pesanan Diterima">
                                                        <i class="fas fa-check-double"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
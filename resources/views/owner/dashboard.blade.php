<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Owner Monitoring Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-sm text-gray-500 uppercase font-bold">Total Penjualan</div>
                    <div class="text-2xl font-bold">Rp {{ number_format($total_sales, 0, ',', '.') }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-sm text-gray-500 uppercase font-bold">Total Mitra Aktif</div>
                    <div class="text-2xl font-bold">{{ $total_mitra }} Cabang</div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-bold mb-4">Transaksi Terbaru</h3>
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="p-3 border">ID Pesanan</th>
                                <th class="p-3 border">Mitra</th>
                                <th class="p-3 border">Total</th>
                                <th class="p-3 border">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recent_orders as $order)
                            <tr>
                                <td class="p-3 border">{{ $order->id }}</td>
                                <td class="p-3 border">{{ $order->user->name }}</td>
                                <td class="p-3 border">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td class="p-3 border text-blue-600 font-semibold">{{ $order->status }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
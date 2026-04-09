<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-red-800 leading-tight">
                {{ __('Business Monitoring (Owner)') }}
            </h2>
            <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded border border-red-400">Read Only Mode</span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl shadow-md border-l-8 border-yellow-500">
                    <p class="text-gray-500 text-sm font-bold uppercase">Total Omset Penjualan</p>
                    <p class="text-3xl font-black text-gray-800">Rp {{ number_format($total_omset, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-md border-l-8 border-red-600">
                    <p class="text-gray-500 text-sm font-bold uppercase">Total Mitra Bergabung</p>
                    <p class="text-3xl font-black text-gray-800">{{ $total_mitra }} Cabang</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-700 mb-4 border-b pb-2">Transaksi Terakhir</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3">Mitra</th>
                                <th class="px-4 py-3">Total Belanja</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Waktu</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($pesanan_terbaru as $order)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 font-medium">{{ $order->user->name }}</td>
                                <td class="px-4 py-3 text-red-700 font-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase {{ $order->status == 'completed' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-gray-500 text-sm">{{ $order->created_at->diffForHumans() }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
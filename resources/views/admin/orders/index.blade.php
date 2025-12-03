<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Pesanan Masuk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- === FITUR PENCARIAN & FILTER (BARU) === --}}
                    <form method="GET" action="{{ route('admin.orders.index') }}" class="mb-6 flex flex-col md:flex-row justify-between items-center gap-4">
                        
                        {{-- Dropdown Show Entries --}}
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-gray-600">Tampilkan</span>
                            <select name="per_page" onchange="this.form.submit()" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                                <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                            </select>
                            <span class="text-sm text-gray-600">data</span>
                        </div>

                        {{-- Search Bar --}}
                        <div class="flex w-full md:w-auto gap-2">
                            <input type="text" name="search" value="{{ $search }}" placeholder="Cari Order ID / Nama Mitra..." class="w-full md:w-64 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition">
                                <i class="fas fa-search"></i> Cari
                            </button>
                            @if($search)
                                <a href="{{ route('admin.orders.index') }}" class="bg-red-100 text-red-600 px-4 py-2 rounded-md hover:bg-red-200 transition">
                                    Reset
                                </a>
                            @endif
                        </div>
                    </form>
                    {{-- ========================================== --}}

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200 text-sm">
                            <thead>
                                <tr class="bg-gray-800 text-white uppercase leading-normal">
                                    <th class="py-3 px-6 text-left">ID & Mitra</th>
                                    <th class="py-3 px-6 text-left">Total & Pembayaran</th>
                                    <th class="py-3 px-6 text-center">Status Barang</th>
                                    <th class="py-3 px-6 text-left">Aksi / Input Resi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 font-light">
                                @forelse($orders as $order)
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    
                                    {{-- Kolom 1: ID & Nama --}}
                                    <td class="py-3 px-6 text-left whitespace-nowrap">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-gray-800">#ORDER-{{ $order->id }}</span>
                                            <span class="text-xs text-gray-500">{{ $order->created_at->format('d M Y H:i') }}</span>
                                            <div class="mt-1 flex items-center gap-2">
                                                <i class="fas fa-user text-gray-400"></i>
                                                <span class="font-medium">{{ $order->user->name }}</span>
                                            </div>
                                            <span class="text-xs text-gray-400 ml-5">{{ $order->user->kota }}</span>
                                        </div>
                                    </td>

                                    {{-- Kolom 2: Uang --}}
                                    <td class="py-3 px-6 text-left">
                                        <div class="font-bold text-gray-800">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                                        <div class="mt-1">
                                            @if($order->payment_status == 'paid')
                                                <span class="bg-green-100 text-green-700 py-1 px-2 rounded text-xs font-bold border border-green-200">
                                                    <i class="fas fa-check-circle"></i> LUNAS
                                                </span>
                                            @else
                                                <span class="bg-yellow-100 text-yellow-700 py-1 px-2 rounded text-xs font-bold border border-yellow-200">
                                                    BELUM LUNAS
                                                </span>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- Kolom 3: Status --}}
                                    <td class="py-3 px-6 text-center">
                                        @if($order->order_status == 'pending')
                                            <span class="bg-gray-200 text-gray-600 py-1 px-3 rounded-full text-xs font-bold">Menunggu Bayar</span>
                                        @elseif($order->order_status == 'processing')
                                            <span class="bg-blue-100 text-blue-600 py-1 px-3 rounded-full text-xs font-bold animate-pulse">
                                                PERLU DIKIRIM
                                            </span>
                                        @elseif($order->order_status == 'shipped')
                                            <span class="bg-purple-100 text-purple-600 py-1 px-3 rounded-full text-xs font-bold">
                                                SEDANG DIKIRIM
                                            </span>
                                            <div class="text-[10px] mt-2 font-mono bg-gray-50 p-1 rounded border">
                                                {{ $order->courier_name }}<br>
                                                {{ $order->resi_number }}
                                            </div>
                                        @elseif($order->order_status == 'completed')
                                            <span class="bg-green-100 text-green-600 py-1 px-3 rounded-full text-xs font-bold">
                                                SELESAI
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Kolom 4: Form Input Resi --}}
                                    <td class="py-3 px-6 text-left">
                                        @if($order->payment_status == 'paid' && $order->order_status == 'processing')
                                            <form action="{{ route('admin.orders.ship', $order->id) }}" method="POST" class="bg-gray-50 p-3 rounded-lg border border-gray-200">
                                                @csrf
                                                @method('PATCH')
                                                <div class="mb-2">
                                                    <input type="text" name="courier_name" class="w-full text-xs border-gray-300 rounded focus:ring-red-500 focus:border-red-500" placeholder="Nama Kurir / Supir" required>
                                                </div>
                                                <div class="mb-2">
                                                    <input type="text" name="resi_number" class="w-full text-xs border-gray-300 rounded focus:ring-red-500 focus:border-red-500" placeholder="No. Resi / Plat Nomor" required>
                                                </div>
                                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold py-2 rounded transition flex items-center justify-center gap-1">
                                                    <i class="fas fa-paper-plane"></i> KIRIM SEKARANG
                                                </button>
                                            </form>
                                        @elseif($order->order_status == 'shipped')
                                            <span class="text-xs text-gray-400 italic">Menunggu konfirmasi Mitra...</span>
                                        @elseif($order->order_status == 'completed')
                                            <span class="text-green-600 font-bold text-xs"><i class="fas fa-check"></i> Transaksi Beres</span>
                                        @else
                                            <span class="text-xs text-gray-400">Menunggu pembayaran...</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-8 text-gray-500">
                                        <i class="fas fa-box-open text-4xl mb-2 text-gray-300"></i><br>
                                        Data pesanan tidak ditemukan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- === PAGINATION LINKS (Angka 1, 2, 3...) === --}}
                    <div class="mt-4">
                        {{ $orders->links() }}
                    </div>
                    {{-- =========================================== --}}

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
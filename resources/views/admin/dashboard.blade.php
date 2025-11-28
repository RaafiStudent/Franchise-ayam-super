<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Administrator') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- BAGIAN 1: KARTU STATISTIK --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-gray-500 text-sm font-medium uppercase">Omset Hari Ini</div>
                    <div class="text-3xl font-bold text-gray-800 mt-2">
                        Rp {{ number_format($omsetHariIni, 0, ',', '.') }}
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-gray-500 text-sm font-medium uppercase">Order Masuk (Hari Ini)</div>
                    <div class="text-3xl font-bold text-gray-800 mt-2">
                        {{ $orderHariIni }} <span class="text-sm font-normal text-gray-400">Pesanan</span>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-yellow-500">
                    <div class="text-gray-500 text-sm font-medium uppercase">Menunggu Pembayaran</div>
                    <div class="text-3xl font-bold text-gray-800 mt-2">
                        {{ $belumDibayar }} <span class="text-sm font-normal text-gray-400">Pesanan</span>
                    </div>
                </div>
            </div>

            {{-- BAGIAN 2: ALERT STOK MENIPIS (Hanya muncul jika ada stok < 10) --}}
            @if($stokMenipis->count() > 0)
            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex items-center mb-3">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl mr-2"></i>
                    <h3 class="text-lg font-bold text-red-800">Peringatan Stok Menipis!</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($stokMenipis as $produk)
                        <div class="bg-white p-3 rounded shadow-sm flex justify-between items-center">
                            <span class="font-medium text-gray-700">{{ $produk->name }}</span>
                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-bold">
                                Sisa: {{ $produk->stock }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- BAGIAN 3: APPROVAL MITRA (YANG LAMA) --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Daftar Permintaan & Status Mitra</h3>
                    
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead>
                                <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">Nama Mitra</th>
                                    <th class="py-3 px-6 text-left">Lokasi</th>
                                    <th class="py-3 px-6 text-center">KTP</th>
                                    <th class="py-3 px-6 text-center">Status</th>
                                    <th class="py-3 px-6 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                @foreach($mitras as $mitra)
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="py-3 px-6 text-left whitespace-nowrap">
                                        <div class="flex items-center">
                                            <span class="font-medium">{{ $mitra->name }}</span>
                                        </div>
                                        <div class="text-xs text-gray-500">{{ $mitra->email }}</div>
                                        <div class="text-xs text-gray-500">{{ $mitra->no_hp }}</div>
                                    </td>
                                    <td class="py-3 px-6 text-left">
                                        <span>{{ $mitra->kota }}, {{ $mitra->provinsi }}</span>
                                        <div class="text-xs text-gray-400 max-w-[150px] truncate">{{ $mitra->alamat_lengkap }}</div>
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        @if($mitra->ktp_image)
                                            <a href="{{ asset('storage/'.$mitra->ktp_image) }}" target="_blank" class="text-blue-500 underline hover:text-blue-700">Lihat Foto</a>
                                        @else
                                            <span class="text-red-400 text-xs">Tidak ada</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        @if($mitra->status == 'pending')
                                            <span class="bg-yellow-200 text-yellow-700 py-1 px-3 rounded-full text-xs">Pending</span>
                                        @elseif($mitra->status == 'active')
                                            <span class="bg-green-200 text-green-700 py-1 px-3 rounded-full text-xs">Active</span>
                                        @else
                                            <span class="bg-red-200 text-red-700 py-1 px-3 rounded-full text-xs">Banned</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        <div class="flex item-center justify-center gap-2">
                                            @if($mitra->status == 'pending')
                                                <form action="{{ route('admin.mitra.approve', $mitra->id) }}" method="POST">
                                                    @csrf @method('PATCH')
                                                    <button class="w-8 h-8 rounded-full bg-green-100 text-green-600 hover:bg-green-200 flex items-center justify-center" title="Terima / Aktifkan">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            @if($mitra->status !== 'banned')
                                                <form action="{{ route('admin.mitra.reject', $mitra->id) }}" method="POST" onsubmit="return confirm('Yakin ingin memblokir akun ini?');">
                                                    @csrf @method('PATCH')
                                                    <button class="w-8 h-8 rounded-full bg-red-100 text-red-600 hover:bg-red-200 flex items-center justify-center" title="Blokir / Tolak">
                                                        <i class="fas fa-ban"></i>
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
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
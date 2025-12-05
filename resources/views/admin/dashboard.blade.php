<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Administrator') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- UCAPAN SELAMAT DATANG (BARU) --}}
            <div class="bg-gradient-to-r from-red-600 to-red-500 rounded-2xl p-6 text-white shadow-lg flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold mb-1">Halo, {{ Auth::user()->name }}! 👋</h2>
                    <p class="text-red-100 text-sm">Selamat datang kembali di Panel Admin Ayam Super.</p>
                </div>
                <div class="hidden md:block opacity-20">
                    <i class="fas fa-user-astronaut text-6xl"></i>
                </div>
            </div>

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

            {{-- BAGIAN 2: ALERT STOK MENIPIS --}}
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

            {{-- === BAGIAN 3: COCKPIT WIDGETS (PRODUK LARIS & GRAFIK) === --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                {{-- WIDGET A: TOP PRODUK --}}
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 lg:col-span-1">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-bold text-gray-800 text-lg">🏆 Produk Terlaris</h3>
                    </div>
                    <div class="space-y-4">
                        @forelse($topProducts as $product)
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-lg bg-gray-100 overflow-hidden shrink-0 border">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover" alt="img">
                                @else
                                    <div class="flex items-center justify-center h-full text-gray-400"><i class="fas fa-image"></i></div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-bold text-gray-700 truncate w-32">{{ $product->name }}</span>
                                    <span class="text-xs font-bold text-red-600">{{ $product->total_sold }} Terjual</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-1.5">
                                    <div class="bg-yellow-400 h-1.5 rounded-full" style="width: {{ rand(40, 90) }}%"></div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <p class="text-gray-400 text-sm text-center py-4">Belum ada data penjualan.</p>
                        @endforelse
                    </div>
                </div>

                {{-- WIDGET B: GRAFIK MINI --}}
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 lg:col-span-2">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="font-bold text-gray-800 text-lg">📈 Tren Penjualan Minggu Ini</h3>
                        <span class="text-xs text-gray-400">Update Real-time</span>
                    </div>
                    <div class="h-64 w-full">
                        <canvas id="miniChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- BAGIAN 4: APPROVAL MITRA --}}
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
                                                    <button class="w-8 h-8 rounded-full bg-green-100 text-green-600 hover:bg-green-200 flex items-center justify-center" title="Terima">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            @if($mitra->status !== 'banned')
                                                <form action="{{ route('admin.mitra.reject', $mitra->id) }}" method="POST" onsubmit="return confirm('Blokir akun ini?');">
                                                    @csrf @method('PATCH')
                                                    <button class="w-8 h-8 rounded-full bg-red-100 text-red-600 hover:bg-red-200 flex items-center justify-center" title="Blokir">
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

    {{-- Script Chart.js Khusus Dashboard --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctxMini = document.getElementById('miniChart').getContext('2d');
        let gradientMini = ctxMini.createLinearGradient(0, 0, 0, 300);
        gradientMini.addColorStop(0, 'rgba(220, 38, 38, 0.2)'); 
        gradientMini.addColorStop(1, 'rgba(255, 255, 255, 0)');

        new Chart(ctxMini, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Omset',
                    data: {!! json_encode($chartValues) !!},
                    borderColor: '#dc2626',
                    backgroundColor: gradientMini,
                    borderWidth: 2,
                    pointRadius: 3,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { display: false },
                    x: { grid: { display: false } }
                }
            }
        });
    </script>
</x-app-layout>
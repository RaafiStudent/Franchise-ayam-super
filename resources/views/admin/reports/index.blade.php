<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            
            {{-- 1. BAGIAN KIRI: JUDUL --}}
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Laporan & Analisis Bisnis') }}
            </h2>
            
            {{-- 2. BAGIAN KANAN: GROUP FILTER & TOMBOL PDF --}}
            <div class="flex items-center gap-3">
                
                {{-- Form Filter --}}
                <form action="{{ route('admin.reports.index') }}" method="GET" class="flex items-center gap-2">
                    <label class="text-sm text-gray-600 font-bold hidden md:block">Periode:</label>
                    <select name="filter" onchange="this.form.submit()" class="border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm text-sm">
                        <option value="today" {{ $filter == 'today' ? 'selected' : '' }}>Hari Ini (Real-time)</option>
                        <option value="day" {{ $filter == 'day' ? 'selected' : '' }}>Harian (7 Hari)</option>
                        <option value="week" {{ $filter == 'week' ? 'selected' : '' }}>Mingguan (1 Bulan)</option>
                        <option value="month" {{ $filter == 'month' ? 'selected' : '' }}>Bulanan (Tahun Ini)</option>
                    </select>
                </form>

                {{-- Tombol Download PDF --}}
                <a href="{{ route('admin.reports.export', ['filter' => $filter]) }}" target="_blank" class="bg-red-600 hover:bg-red-700 text-white text-sm font-bold px-4 py-2 rounded-md shadow flex items-center gap-2 transition transform hover:scale-105">
                    <i class="fas fa-file-pdf"></i> 
                    <span class="hidden md:inline">Download PDF</span>
                    <span class="md:hidden">PDF</span> {{-- Teks pendek untuk HP --}}
                </a>

            </div>
        </div>
    </x-slot>

    {{-- Script Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- 1. HERO BANNER MERAH --}}
            <div class="bg-gradient-to-r from-red-700 to-red-600 rounded-2xl p-8 text-white shadow-xl relative overflow-hidden">
                <div class="relative z-10">
                    <h1 class="text-3xl font-bold mb-2">Dashboard Statistik Ayam Super</h1>
                    <p class="text-red-100">Pantau denyut nadi bisnis Anda secara real-time. Data yang akurat kunci kesuksesan.</p>
                </div>
                <div class="absolute right-0 bottom-0 opacity-10 transform translate-x-10 translate-y-10">
                    <i class="fas fa-chart-line text-9xl text-white"></i>
                </div>
            </div>

            {{-- 2. KARTU RINGKASAN --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Omset --}}
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-green-500 flex justify-between items-center">
                    <div>
                        <p class="text-gray-500 text-xs font-bold uppercase tracking-wider">Total Omset (Paid)</p>
                        <p class="text-2xl font-extrabold text-gray-800 mt-1">Rp {{ number_format($totalOmset, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full text-green-600">
                        <i class="fas fa-money-bill-wave text-xl"></i>
                    </div>
                </div>

                {{-- Total Transaksi --}}
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-yellow-500 flex justify-between items-center">
                    <div>
                        <p class="text-gray-500 text-xs font-bold uppercase tracking-wider">Total Pesanan Sukses</p>
                        <p class="text-2xl font-extrabold text-gray-800 mt-1">{{ $totalTransaksi }} <span class="text-sm font-normal text-gray-400">Trx</span></p>
                    </div>
                    <div class="bg-yellow-100 p-3 rounded-full text-yellow-600">
                        <i class="fas fa-shopping-bag text-xl"></i>
                    </div>
                </div>

                {{-- Mitra Aktif --}}
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-blue-500 flex justify-between items-center">
                    <div>
                        <p class="text-gray-500 text-xs font-bold uppercase tracking-wider">Mitra Aktif</p>
                        <p class="text-2xl font-extrabold text-gray-800 mt-1">{{ $totalMitra }} <span class="text-sm font-normal text-gray-400">Outlet</span></p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full text-blue-600">
                        <i class="fas fa-store text-xl"></i>
                    </div>
                </div>
            </div>

            {{-- 3. AREA GRAFIK --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- Grafik Pendapatan (Line Chart) --}}
                <div class="bg-white p-6 rounded-xl shadow-sm lg:col-span-2">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-bold text-gray-800 text-lg">Tren Pendapatan</h3>
                        <span class="bg-red-100 text-red-600 text-xs font-bold px-2 py-1 rounded">Graph View</span>
                    </div>
                    <div class="relative h-72 w-full">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>

                {{-- Grafik Status (Doughnut Chart) --}}
                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <h3 class="font-bold text-gray-800 text-lg mb-6">Komposisi Status Order</h3>
                    <div class="relative h-64 w-full flex justify-center">
                        <canvas id="statusChart"></canvas>
                    </div>
                    {{-- Legenda Manual Biar Rapi --}}
                    <div class="mt-6 grid grid-cols-2 gap-2 text-xs text-gray-500 text-center">
                        <span><span class="inline-block w-2 h-2 rounded-full bg-yellow-400 mr-1"></span> Pending</span>
                        <span><span class="inline-block w-2 h-2 rounded-full bg-blue-400 mr-1"></span> Processing</span>
                        <span><span class="inline-block w-2 h-2 rounded-full bg-purple-500 mr-1"></span> Shipped</span>
                        <span><span class="inline-block w-2 h-2 rounded-full bg-green-500 mr-1"></span> Completed</span>
                    </div>
                </div>

            </div>

        </div>
    </div>

    {{-- SCRIPT KONFIGURASI CHART --}}
    <script>
        // 1. CHART PENDAPATAN
        const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
        
        let gradient = ctxRevenue.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(239, 68, 68, 0.5)'); 
        gradient.addColorStop(1, 'rgba(239, 68, 68, 0.0)'); 

        new Chart(ctxRevenue, {
            type: 'line',
            data: {
                labels: {!! json_encode($label) !!}, 
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: {!! json_encode($dataPendapatan) !!}, 
                    borderColor: '#dc2626', 
                    backgroundColor: gradient,
                    borderWidth: 3,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#dc2626',
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    fill: true,
                    tension: 0.4 
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { borderDash: [2, 4] } },
                    x: { grid: { display: false } }
                }
            }
        });

        // 2. CHART STATUS
        const ctxStatus = document.getElementById('statusChart').getContext('2d');
        new Chart(ctxStatus, {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'Processing', 'Shipped', 'Completed', 'Cancelled'],
                datasets: [{
                    data: {!! json_encode($pieData) !!}, 
                    backgroundColor: [
                        '#facc15', '#60a5fa', '#a855f7', '#22c55e', '#ef4444'
                    ],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%', 
                plugins: { legend: { display: false } }
            }
        }); 
    </script>
</x-app-layout>
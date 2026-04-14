<section id="kemitraan" class="py-8 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-12">
            <h2 class="text-base text-red-600 font-bold tracking-wide uppercase">Info Kemitraan</h2>
            <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                Kenapa Memilih Ayam Super?
            </p>
        </div>

        {{-- Perbaikan: mb-10 diubah jadi mb-8 --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
            <div class="p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition border-t-4 border-red-500">
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Modal Terjangkau</h3>
                <p class="mt-2 text-gray-600 text-sm">Paket usaha fleksibel mulai dari 10 Jutaan. Balik modal cepat InsyaAllah.</p>
            </div>
            <div class="p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition border-t-4 border-yellow-500">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Bahan Baku Premium</h3>
                <p class="mt-2 text-gray-600 text-sm">Suplai ayam marinasi dan bumbu rahasia langsung dari pusat. Rasa konsisten.</p>
            </div>
            <div class="p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition border-t-4 border-blue-500">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Sistem Terintegrasi</h3>
                <p class="mt-2 text-gray-600 text-sm">Kelola usaha lebih mudah dengan dukungan sistem manajemen modern.</p>
            </div>
        </div>

        <div class="text-center mb-12">
            <h2 class="text-3xl font-extrabold text-gray-900">Pilih Paket Usaha Anda</h2>
            <div class="w-24 h-1 bg-yellow-400 mx-auto mt-2"></div>
            <p class="mt-4 text-gray-600">Investasi sekali, untung berkali-kali.</p>
        </div>

        <div class="max-w-5xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12 items-stretch">
                
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:scale-105 transition-transform duration-300 border border-gray-200 flex flex-col h-full">
                    <div class="h-64 flex-shrink-0 overflow-hidden bg-gray-200 relative group cursor-pointer" onclick="openModal('/images/paket1.jpeg')">
                        <img src="/images/paket1.jpeg" alt="Paket Usaha 1" class="w-full h-full object-cover group-hover:opacity-90 transition">
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300 bg-black bg-opacity-30">
                            <span class="text-white font-bold border border-white px-3 py-1 rounded"><i class="fas fa-search-plus mr-2"></i>Lihat Detail</span>
                        </div>
                        <div class="absolute top-0 right-0 bg-red-600 text-white font-bold px-4 py-2 rounded-bl-xl shadow-md">
                            HEMAT
                        </div>
                    </div>
                    
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-2xl font-bold text-gray-800">Paket 1</h3>
                        <div class="my-4">
                            <span class="text-4xl font-extrabold text-red-600">Rp 10,5 Jt</span>
                            <span class="text-gray-500 block text-sm mt-1">Modal Minimal Hasil Maksimal</span>
                        </div>
                        
                        <div class="flex-grow overflow-y-auto max-h-64 pr-2 mb-6 custom-scrollbar">
                            <p class="text-sm font-bold text-gray-700 mb-2 underline">Yang Diperoleh Mitra:</p>
                            <ul class="space-y-2 text-sm text-gray-600">
                                <li class="flex items-start"><i class="fas fa-check text-green-500 mt-1 mr-2 flex-shrink-0"></i> <span>Gerobak Fried Chicken</span></li>
                                <li class="flex items-start"><i class="fas fa-check text-green-500 mt-1 mr-2 flex-shrink-0"></i> <span>Kompor, Selang, Regulator</span></li>
                                <li class="flex items-start"><i class="fas fa-check text-green-500 mt-1 mr-2 flex-shrink-0"></i> <span>Wajan 20" + Tutup</span></li>
                                <li class="flex items-start"><i class="fas fa-check text-green-500 mt-1 mr-2 flex-shrink-0"></i> <span>Cooler Box 17 Ltr</span></li>
                                <li class="flex items-start"><i class="fas fa-check text-green-500 mt-1 mr-2 flex-shrink-0"></i> <span>Meja Pengaduk Penepungan</span></li>
                                <li class="flex items-start"><i class="fas fa-check text-green-500 mt-1 mr-2 flex-shrink-0"></i> <span>Termometer & Timer</span></li>
                                <li class="flex items-start"><i class="fas fa-check text-green-500 mt-1 mr-2 flex-shrink-0"></i> <span>Peralatan Masak Lengkap (Sodet, Saringan, Baskom, dll)</span></li>
                                <li class="flex items-start"><i class="fas fa-check text-green-500 mt-1 mr-2 flex-shrink-0"></i> <span>Bahan Baku: Ayam Marinasi 10 Ekor</span></li>
                                <li class="flex items-start"><i class="fas fa-check text-green-500 mt-1 mr-2 flex-shrink-0"></i> <span>Tepung Breader 10 Kg</span></li>
                                <li class="flex items-start"><i class="fas fa-check text-green-500 mt-1 mr-2 flex-shrink-0"></i> <span>Minyak Padat 15 Kg</span></li>
                                <li class="flex items-start"><i class="fas fa-check text-green-500 mt-1 mr-2 flex-shrink-0"></i> <span>Packaging (Dus Box 100pcs, Kantong, dll)</span></li>
                            </ul>
                        </div>

                        <a href="https://wa.me/6281234567890?text=Halo%20Admin,%20saya%20tertarik%20Paket%201%20seharga%2010,5%20Juta" class="mt-auto block w-full text-center bg-gray-800 text-white font-bold py-3 rounded-lg hover:bg-gray-900 transition">
                            Pilih Paket 1
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:scale-105 transition-transform duration-300 border-2 border-yellow-400 relative flex flex-col h-full">
                    <div class="absolute top-0 left-0 w-full bg-yellow-400 text-red-900 text-center text-xs font-bold py-1 z-10">
                        REKOMENDASI
                    </div>
                    <div class="h-64 flex-shrink-0 overflow-hidden bg-gray-200 mt-6 relative group cursor-pointer" onclick="openModal('/images/paket2.jpeg')">
                        <img src="/images/paket2.jpeg" alt="Paket Usaha 2" class="w-full h-full object-cover group-hover:opacity-90 transition">
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300 bg-black bg-opacity-30">
                            <span class="text-white font-bold border border-white px-3 py-1 rounded"><i class="fas fa-search-plus mr-2"></i>Lihat Detail</span>
                        </div>
                    </div>
                    
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-2xl font-bold text-gray-800">Paket 2</h3>
                        <div class="my-4">
                            <span class="text-4xl font-extrabold text-red-600">Rp 12,5 Jt</span>
                            <span class="text-gray-500 block text-sm mt-1">Upgrade Peralatan Lebih Besar</span>
                        </div>
                        
                        <div class="flex-grow overflow-y-auto max-h-64 pr-2 mb-6 custom-scrollbar">
                            <p class="text-sm font-bold text-gray-700 mb-2 underline">Kelebihan Paket Ini:</p>
                            <ul class="space-y-2 text-sm text-gray-600">
                                <li class="flex items-start"><i class="fas fa-check-circle text-yellow-500 mt-1 mr-2 flex-shrink-0"></i> <span class="font-semibold">Kompor High Pressure</span></li>
                                <li class="flex items-start"><i class="fas fa-check-circle text-yellow-500 mt-1 mr-2 flex-shrink-0"></i> <span class="font-semibold">Wajan Lebih Besar (24 Inch)</span></li>
                                <li class="flex items-start"><i class="fas fa-check-circle text-yellow-500 mt-1 mr-2 flex-shrink-0"></i> <span class="font-semibold">Cooler Box Lebih Besar (26 Ltr)</span></li>
                                <li class="flex items-start"><i class="fas fa-check-circle text-yellow-500 mt-1 mr-2 flex-shrink-0"></i> <span class="font-semibold">Ayam Marinasi 15 Ekor</span></li>
                                <li class="flex items-start border-t pt-2 mt-2"><i class="fas fa-check text-green-500 mt-1 mr-2 flex-shrink-0"></i> <span>Gerobak Fried Chicken</span></li>
                                <li class="flex items-start"><i class="fas fa-check text-green-500 mt-1 mr-2 flex-shrink-0"></i> <span>Meja Pengaduk Penepungan</span></li>
                                <li class="flex items-start"><i class="fas fa-check text-green-500 mt-1 mr-2 flex-shrink-0"></i> <span>Tepung Breader 10 Kg</span></li>
                                <li class="flex items-start"><i class="fas fa-check text-green-500 mt-1 mr-2 flex-shrink-0"></i> <span>Minyak Padat 15 Kg</span></li>
                                <li class="flex items-start"><i class="fas fa-check text-green-500 mt-1 mr-2 flex-shrink-0"></i> <span>Peralatan Masak & Packaging Lengkap</span></li>
                            </ul>
                        </div>

                        <a href="https://wa.me/6281234567890?text=Halo%20Admin,%20saya%20tertarik%20Paket%202%20seharga%2012,5%20Juta" class="mt-auto block w-full text-center bg-red-600 text-white font-bold py-3 rounded-lg hover:bg-red-700 transition shadow-lg">
                            Pilih Paket 2
                        </a>
                    </div>
                </div>

            </div>
        </div>

        {{-- Perbaikan: mt-12 diubah jadi mt-8 agar jarak ke footer tidak terlalu jauh --}}
        <div class="mt-8 text-center bg-yellow-50 p-4 rounded-lg border border-yellow-200 max-w-4xl mx-auto">
            <p class="text-gray-700 font-medium">
                <i class="fas fa-info-circle text-yellow-500 mr-2"></i> 
                Harga belum termasuk ongkos kirim booth ke lokasi dan sewa tempat.
            </p>
        </div>

    </div>

    <div id="imageModal" class="fixed inset-0 z-50 hidden overflow-auto bg-black bg-opacity-90 flex items-center justify-center p-4" onclick="closeModal()">
        <span class="absolute top-5 right-5 text-white text-4xl font-bold cursor-pointer hover:text-red-500 transition">&times;</span>
        <img class="max-w-full max-h-[90vh] rounded-lg shadow-2xl animate-fade-in-down" id="modalImage">
        <p class="absolute bottom-5 text-gray-300 text-sm">Klik di mana saja untuk menutup</p>
    </div>

    <script>
        function openModal(imageSrc) {
            const modal = document.getElementById('imageModal');
            const modalImg = document.getElementById('modalImage');
            modal.classList.remove('hidden');
            modal.classList.add('flex'); 
            modalImg.src = imageSrc;
            document.body.style.overflow = 'hidden'; 
        }

        function closeModal() {
            const modal = document.getElementById('imageModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto'; 
        }
    </script>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1; 
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #d1d5db; 
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #9ca3af; 
        }
        @keyframes fade-in-down {
            0% { opacity: 0; transform: translateY(-20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-down {
            animation: fade-in-down 0.3s ease-out;
        }
    </style>
</section>
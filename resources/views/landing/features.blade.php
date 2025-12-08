<section id="kemitraan" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-12">
            <h2 class="text-base text-red-600 font-bold tracking-wide uppercase">Info Kemitraan</h2>
            <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                Kenapa Memilih Ayam Super?
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-20">
            {{-- (BAGIAN FITUR KEUNGGULAN TETAP SAMA SEPERTI SEBELUMNYA) --}}
            <div class="p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition border-t-4 border-red-500">
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Modal Terjangkau</h3>
                <p class="mt-2 text-gray-600 text-sm">Paket usaha fleksibel mulai dari booth sederhana hingga ruko eksklusif. Balik modal cepat.</p>
            </div>
            <div class="p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition border-t-4 border-yellow-500">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Bahan Baku Premium</h3>
                <p class="mt-2 text-gray-600 text-sm">Suplai ayam marinasi dan bumbu rahasia langsung dari pusat. Rasa konsisten dan lezat.</p>
            </div>
            <div class="p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition border-t-4 border-blue-500">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Sistem Web Canggih</h3>
                <p class="mt-2 text-gray-600 text-sm">Pesan bahan baku, cek pengiriman, dan kelola usaha lewat website ini secara real-time.</p>
            </div>
        </div>

        <div class="text-center mb-12">
            <h2 class="text-3xl font-extrabold text-gray-900">Pilih Paket Usaha Anda</h2>
            <div class="w-24 h-1 bg-yellow-400 mx-auto mt-2"></div>
            <p class="mt-4 text-gray-600">Investasi sekali, untung berkali-kali.</p>
        </div>

        {{-- GRID DIPUSATKAN (justify-center) karena cuma 2 item --}}
        <div class="flex flex-col md:flex-row justify-center gap-8 items-start">
            
            {{-- PAKET 1 (Silver / Standar) --}}
            <div class="w-full md:w-1/3 bg-white rounded-2xl shadow-lg overflow-hidden hover:scale-105 transition-transform duration-300 border border-gray-200 flex flex-col h-full">
                <div class="h-56 overflow-hidden bg-gray-200 relative group cursor-pointer" onclick="openLightbox('{{ asset('images/paket1.jpeg') }}')">
                    {{-- GAMBAR PAKET 1 --}}
                    <img src="{{ asset('images/paket1.jpeg') }}" alt="Paket Standar" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                    
                    {{-- Overlay "Klik untuk Perbesar" --}}
                    <div class="absolute inset-0 bg-black/30 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                        <i class="fas fa-search-plus text-white text-3xl"></i>
                    </div>

                    <div class="absolute top-0 right-0 bg-red-600 text-white font-bold px-4 py-2 rounded-bl-xl">
                        HEMAT
                    </div>
                </div>
                <div class="p-6 flex-grow flex flex-col">
                    <h3 class="text-2xl font-bold text-gray-800">Paket Usaha Silver</h3>
                    <div class="my-4">
                        <span class="text-4xl font-extrabold text-red-600">Rp 10,5 Jt</span>
                        <span class="text-gray-500">/ All in</span>
                    </div>
                    <p class="text-gray-500 text-sm mb-6">Booth portabel minimalis. Cocok untuk lokasi bazar, kantin, atau teras rumah.</p>
                    
                    <ul class="space-y-3 mb-8 flex-grow text-sm">
                        <li class="flex items-center text-gray-700">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i> Booth Aluminium Portable (Bongkar Pasang)
                        </li>
                        <li class="flex items-center text-gray-700">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i> Peralatan Masak Dasar (Wajan, Spatula)
                        </li>
                        <li class="flex items-center text-gray-700">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i> Bahan Baku Awal (50 Porsi)
                        </li>
                        <li class="flex items-center text-gray-700">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i> X-Banner & Daftar Menu
                        </li>
                    </ul>

                    <a href="https://wa.me/6281234567890?text=Halo%20Admin,%20saya%20tertarik%20Paket%20Silver" class="block w-full text-center bg-gray-800 text-white font-bold py-3 rounded-lg hover:bg-gray-900 transition">
                        Pilih Paket Silver
                    </a>
                </div>
            </div>

            {{-- PAKET 2 (Gold / Premium) --}}
            <div class="w-full md:w-1/3 bg-white rounded-2xl shadow-xl overflow-hidden hover:scale-105 transition-transform duration-300 border-2 border-yellow-400 relative flex flex-col h-full">
                <div class="absolute top-0 left-0 w-full bg-yellow-400 text-red-900 text-center text-xs font-bold py-1 z-10">
                    PALING LARIS
                </div>
                <div class="h-56 overflow-hidden bg-gray-200 mt-6 relative group cursor-pointer" onclick="openLightbox('{{ asset('images/paket2.jpeg') }}')">
                    {{-- GAMBAR PAKET 2 --}}
                    <img src="{{ asset('images/paket2.jpeg') }}" alt="Paket Gold" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                    
                    {{-- Overlay "Klik untuk Perbesar" --}}
                    <div class="absolute inset-0 bg-black/30 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                        <i class="fas fa-search-plus text-white text-3xl"></i>
                    </div>
                </div>
                <div class="p-6 flex-grow flex flex-col">
                    <h3 class="text-2xl font-bold text-gray-800">Paket Usaha Gold</h3>
                    <div class="my-4">
                        <span class="text-4xl font-extrabold text-red-600">Rp 12,5 Jt</span>
                        <span class="text-gray-500">/ All in</span>
                    </div>
                    <p class="text-gray-500 text-sm mb-6">Booth kontainer kekinian dengan peralatan lengkap. Cocok untuk lokasi strategis.</p>
                    
                    <ul class="space-y-3 mb-8 flex-grow text-sm">
                        <li class="flex items-center text-gray-700">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i> Booth Semi-Kontainer / Kayu Jati Belanda
                        </li>
                        <li class="flex items-center text-gray-700">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i> Deep Fryer Gas (Penggorengan Otomatis)
                        </li>
                        <li class="flex items-center text-gray-700">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i> Bahan Baku Awal (100 Porsi)
                        </li>
                        <li class="flex items-center text-gray-700">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i> Seragam Karyawan & Neon Box
                        </li>
                    </ul>

                    <a href="https://wa.me/6281234567890?text=Halo%20Admin,%20saya%20tertarik%20Paket%20Gold" class="block w-full text-center bg-red-600 text-white font-bold py-3 rounded-lg hover:bg-red-700 transition shadow-lg">
                        Pilih Paket Gold
                    </a>
                </div>
            </div>

        </div>

        <div class="mt-12 text-center bg-yellow-50 p-4 rounded-lg border border-yellow-200">
            <p class="text-gray-700 font-medium">
                <i class="fas fa-info-circle text-yellow-500 mr-2"></i> 
                Harga belum termasuk ongkos kirim booth ke lokasi dan sewa tempat.
            </p>
        </div>

    </div>

    {{-- ELEMENT LIGHTBOX (POPUP GAMBAR) --}}
    <div id="lightbox" class="fixed inset-0 z-50 bg-black/90 hidden items-center justify-center p-4 transition-opacity duration-300" onclick="closeLightbox()">
        <div class="relative max-w-4xl max-h-full">
            <button onclick="closeLightbox()" class="absolute -top-10 right-0 text-white text-4xl hover:text-red-500 transition">
                &times;
            </button>
            <img id="lightbox-img" src="" alt="Preview Paket" class="max-w-full max-h-[90vh] rounded-lg shadow-2xl border-4 border-white">
        </div>
    </div>

    {{-- SCRIPT LIGHTBOX SEDERHANA --}}
    <script>
        function openLightbox(imageSrc) {
            const lightbox = document.getElementById('lightbox');
            const img = document.getElementById('lightbox-img');
            
            img.src = imageSrc;
            lightbox.classList.remove('hidden');
            lightbox.classList.add('flex');
        }

        function closeLightbox() {
            const lightbox = document.getElementById('lightbox');
            lightbox.classList.add('hidden');
            lightbox.classList.remove('flex');
        }
        
        // Tutup pakai tombol ESC keyboard
        document.addEventListener('keydown', function(event) {
            if (event.key === "Escape") {
                closeLightbox();
            }
        });
    </script>
</section>
<section id="menu" class="py-12 md:py-20 bg-white">
    <div class="container mx-auto px-4">
        
        <div class="text-center mb-8 md:mb-12">
            <h2 class="text-3xl md:text-4xl font-extrabold text-red-700 uppercase mb-2">Menu Favorit</h2>
            <div class="w-24 h-1 bg-yellow-400 mx-auto"></div>
            <p class="text-gray-600 mt-4 text-sm md:text-base">Geser untuk melihat menu lezat lainnya!</p>
        </div>

        <div id="menu-slider" class="flex overflow-x-auto gap-5 md:gap-8 pb-10 snap-x snap-mandatory scroll-pl-4 no-scrollbar scroll-smooth px-2">
            
            <div class="min-w-[85vw] sm:min-w-[300px] md:min-w-[350px] flex-none snap-center bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 group relative">
                <div class="h-56 md:h-64 overflow-hidden relative rounded-t-3xl">
                    <img src="https://placehold.co/400x300/orange/white?text=Paket+Hemat" alt="Paket Hemat" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                    <div class="absolute top-4 left-4 bg-green-500 text-white text-[10px] font-bold px-3 py-1 rounded-full shadow-md uppercase tracking-wider">HEMAT</div>
                    
                    <button onclick="toggleLove(1)" id="btn-love-1" class="absolute top-4 right-4 bg-white/80 backdrop-blur-sm p-2 rounded-full text-gray-400 hover:text-red-500 hover:bg-white transition shadow-sm group-active:scale-90">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
                <div class="p-6">
                    <div class="flex items-center space-x-1 mb-2">
                        <i class="fas fa-star text-yellow-400 text-xs"></i>
                        <span class="text-xs font-bold text-gray-600">4.8</span>
                        <span class="text-xs text-gray-400">(<span id="count-love-1">120</span> menyukai)</span>
                    </div>
                    <h3 class="text-xl font-extrabold text-gray-900 mb-2 leading-tight group-hover:text-red-700 transition">Paket Hemat Pelajar</h3>
                    <p class="text-gray-500 text-sm leading-relaxed line-clamp-2">Sayap/Paha Bawah Crispy + Nasi + Es Teh Manis.</p>
                </div>
            </div>

            <div class="min-w-[85vw] sm:min-w-[300px] md:min-w-[350px] flex-none snap-center bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 group relative">
                <div class="h-56 md:h-64 overflow-hidden relative rounded-t-3xl">
                    <img src="https://placehold.co/400x300/d32f2f/white?text=Ayam+Geprek" alt="Ayam Geprek" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                    <div class="absolute top-4 left-4 bg-yellow-400 text-red-900 text-[10px] font-bold px-3 py-1 rounded-full shadow-md uppercase tracking-wider">BEST SELLER</div>
                    
                    <button onclick="toggleLove(2)" id="btn-love-2" class="absolute top-4 right-4 bg-white/80 backdrop-blur-sm p-2 rounded-full text-gray-400 hover:text-red-500 hover:bg-white transition shadow-sm group-active:scale-90">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
                <div class="p-6">
                    <div class="flex items-center space-x-1 mb-2">
                        <i class="fas fa-star text-yellow-400 text-xs"></i>
                        <span class="text-xs font-bold text-gray-600">4.9</span>
                        <span class="text-xs text-gray-400">(<span id="count-love-2">350</span> menyukai)</span>
                    </div>
                    <h3 class="text-xl font-extrabold text-gray-900 mb-2 leading-tight group-hover:text-red-700 transition">Ayam Geprek Level</h3>
                    <p class="text-gray-500 text-sm leading-relaxed line-clamp-2">Ayam crispy digeprek dengan sambal bawang super pedas.</p>
                </div>
            </div>

            <div class="min-w-[85vw] sm:min-w-[300px] md:min-w-[350px] flex-none snap-center bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 group relative">
                <div class="h-56 md:h-64 overflow-hidden relative rounded-t-3xl">
                    <img src="https://placehold.co/400x300/brown/white?text=BBQ+Wings" alt="BBQ Wings" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                    <div class="absolute top-4 left-4 bg-purple-600 text-white text-[10px] font-bold px-3 py-1 rounded-full shadow-md uppercase tracking-wider">FAVORIT</div>
                    
                    <button onclick="toggleLove(3)" id="btn-love-3" class="absolute top-4 right-4 bg-white/80 backdrop-blur-sm p-2 rounded-full text-gray-400 hover:text-red-500 hover:bg-white transition shadow-sm group-active:scale-90">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
                <div class="p-6">
                    <div class="flex items-center space-x-1 mb-2">
                        <i class="fas fa-star text-yellow-400 text-xs"></i>
                        <span class="text-xs font-bold text-gray-600">4.7</span>
                        <span class="text-xs text-gray-400">(<span id="count-love-3">85</span> menyukai)</span>
                    </div>
                    <h3 class="text-xl font-extrabold text-gray-900 mb-2 leading-tight group-hover:text-red-700 transition">Chicken Wings BBQ</h3>
                    <p class="text-gray-500 text-sm leading-relaxed line-clamp-2">Sayap ayam gurih dengan saus BBQ manis dan smoky.</p>
                </div>
            </div>

            <div class="min-w-[85vw] sm:min-w-[300px] md:min-w-[350px] flex-none snap-center bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 group relative">
                <div class="h-56 md:h-64 overflow-hidden relative rounded-t-3xl">
                    <img src="https://placehold.co/400x300/purple/white?text=Sambal+Matah" alt="Sambal Matah" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                    <div class="absolute top-4 left-4 bg-red-600 text-white text-[10px] font-bold px-3 py-1 rounded-full shadow-md uppercase tracking-wider">PEDAS</div>
                    
                    <button onclick="toggleLove(4)" id="btn-love-4" class="absolute top-4 right-4 bg-white/80 backdrop-blur-sm p-2 rounded-full text-gray-400 hover:text-red-500 hover:bg-white transition shadow-sm group-active:scale-90">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
                <div class="p-6">
                    <div class="flex items-center space-x-1 mb-2">
                        <i class="fas fa-star text-yellow-400 text-xs"></i>
                        <span class="text-xs font-bold text-gray-600">4.8</span>
                        <span class="text-xs text-gray-400">(<span id="count-love-4">210</span> menyukai)</span>
                    </div>
                    <h3 class="text-xl font-extrabold text-gray-900 mb-2 leading-tight group-hover:text-red-700 transition">Ayam Sambal Matah</h3>
                    <p class="text-gray-500 text-sm leading-relaxed line-clamp-2">Ayam crispy disajikan dengan sambal matah segar khas Bali.</p>
                </div>
            </div>

            <div class="min-w-[85vw] sm:min-w-[300px] md:min-w-[350px] flex-none snap-center bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 group relative">
                <div class="h-56 md:h-64 overflow-hidden relative rounded-t-3xl">
                    <img src="https://placehold.co/400x300/green/white?text=Burger+Ayam" alt="Burger Ayam" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                    <div class="absolute top-4 left-4 bg-blue-500 text-white text-[10px] font-bold px-3 py-1 rounded-full shadow-md uppercase tracking-wider">BARU</div>
                    
                    <button onclick="toggleLove(5)" id="btn-love-5" class="absolute top-4 right-4 bg-white/80 backdrop-blur-sm p-2 rounded-full text-gray-400 hover:text-red-500 hover:bg-white transition shadow-sm group-active:scale-90">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
                <div class="p-6">
                    <div class="flex items-center space-x-1 mb-2">
                        <i class="fas fa-star text-yellow-400 text-xs"></i>
                        <span class="text-xs font-bold text-gray-600">4.6</span>
                        <span class="text-xs text-gray-400">(<span id="count-love-5">45</span> menyukai)</span>
                    </div>
                    <h3 class="text-xl font-extrabold text-gray-900 mb-2 leading-tight group-hover:text-red-700 transition">Burger Ayam Crispy</h3>
                    <p class="text-gray-500 text-sm leading-relaxed line-clamp-2">Burger isi ayam crispy, selada, dan saus spesial.</p>
                </div>
            </div>

            <div class="min-w-[85vw] sm:min-w-[300px] md:min-w-[350px] flex-none snap-center bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 group relative">
                <div class="h-56 md:h-64 overflow-hidden relative rounded-t-3xl">
                    <img src="https://placehold.co/400x300/blue/white?text=Paket+Keluarga" alt="Paket Keluarga" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                    <div class="absolute top-4 left-4 bg-indigo-600 text-white text-[10px] font-bold px-3 py-1 rounded-full shadow-md uppercase tracking-wider">FAMILY</div>
                    
                    <button onclick="toggleLove(6)" id="btn-love-6" class="absolute top-4 right-4 bg-white/80 backdrop-blur-sm p-2 rounded-full text-gray-400 hover:text-red-500 hover:bg-white transition shadow-sm group-active:scale-90">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
                <div class="p-6">
                    <div class="flex items-center space-x-1 mb-2">
                        <i class="fas fa-star text-yellow-400 text-xs"></i>
                        <span class="text-xs font-bold text-gray-600">4.9</span>
                        <span class="text-xs text-gray-400">(<span id="count-love-6">500</span> menyukai)</span>
                    </div>
                    <h3 class="text-xl font-extrabold text-gray-900 mb-2 leading-tight group-hover:text-red-700 transition">Paket Keluarga</h3>
                    <p class="text-gray-500 text-sm leading-relaxed line-clamp-2">4 Ayam crispy + 2 Nasi + 2 Kentang + 2 Es Teh Jumbo.</p>
                </div>
            </div>

        </div>
        
        <div class="text-center mt-8 md:mt-12 flex justify-center items-center gap-3 md:gap-4">
            <button onclick="scrollMenu('left')" class="bg-gray-100 hover:bg-gray-200 text-gray-600 w-10 h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center transition shadow-sm active:scale-95">
                <i class="fas fa-arrow-left"></i>
            </button>

            <button onclick="scrollMenu('right')" class="bg-red-700 text-white font-bold px-6 py-2 md:px-8 md:py-3 text-sm md:text-base rounded-full hover:bg-red-800 transition shadow-lg flex items-center active:scale-95">
                Lihat Menu Lainnya <i class="fas fa-arrow-right ml-2"></i>
            </button>
        </div>
    </div>

    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>

    <script>
        // Fungsi Scroll Menu
        function scrollMenu(direction) {
            const container = document.getElementById('menu-slider');
            const scrollAmount = window.innerWidth < 768 ? 280 : 350; 
            if (direction === 'left') {
                container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
            } else {
                container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            }
        }

        // Fungsi Toggle Love (Simulasi)
        function toggleLove(id) {
            const btn = document.getElementById(`btn-love-${id}`);
            const countSpan = document.getElementById(`count-love-${id}`);
            let currentCount = parseInt(countSpan.innerText.replace(/,/g, '')); // Ambil angka saat ini

            // Cek apakah sudah dilike (cek warna merah)
            if (btn.classList.contains('text-red-600')) {
                // Kalau sudah like -> jadi UNLIKE
                btn.classList.remove('text-red-600'); // Hapus warna merah
                btn.classList.add('text-gray-400');   // Balik ke abu-abu
                btn.innerHTML = '<i class="fas fa-heart"></i>'; // Icon outline/biasa
                
                currentCount = currentCount - 1; // Kurangi angka
            } else {
                // Kalau belum like -> jadi LIKE
                btn.classList.remove('text-gray-400');
                btn.classList.add('text-red-600');    // Jadi merah
                btn.innerHTML = '<i class="fas fa-heart fa-beat"></i>'; // Tambah animasi detak
                
                currentCount = currentCount + 1; // Tambah angka
            }

            // Update angka di layar
            countSpan.innerText = currentCount;
        }
    </script>
</section>
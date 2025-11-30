<section id="menu" class="py-12 md:py-20 bg-white">
    <div class="container mx-auto px-4">
        
        <div class="text-center mb-8 md:mb-12">
            <h2 class="text-3xl md:text-4xl font-extrabold text-red-700 uppercase mb-2">Menu Favorit</h2>
            <div class="w-24 h-1 bg-yellow-400 mx-auto"></div>
            <p class="text-gray-600 mt-4 text-sm md:text-base">Bantu kami menilai menu dengan memberikan Like atau Dislike!</p>
        </div>

        @php
            $likedMenus = session('liked_menus', []);
            $dislikedMenus = session('disliked_menus', []);
        @endphp

        <div id="menu-slider" class="flex overflow-x-auto gap-5 md:gap-8 pb-10 snap-x snap-mandatory scroll-pl-4 no-scrollbar scroll-smooth px-2">
            
            @foreach($menus as $menu)
                {{-- LOGIKA HITUNG RATING (PHP) --}}
                @php
                    $totalVotes = $menu->loves + $menu->dislikes;
                    // Rumus: (Like / Total) * 5. Jika total 0, maka rating 0.
                    $rating = $totalVotes > 0 ? ($menu->loves / $totalVotes) * 5 : 0;
                    // Format 1 angka di belakang koma (misal: 4.5)
                    $ratingFormatted = number_format($rating, 1);
                @endphp

            <div class="min-w-[85vw] sm:min-w-[300px] md:min-w-[350px] flex-none snap-center bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 group relative">
                <div class="h-56 md:h-64 overflow-hidden relative rounded-t-3xl">
                    <img src="{{ $menu->image }}" alt="{{ $menu->name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                    
                    @if($menu->badge)
                        <div class="absolute top-4 left-4 bg-{{ $menu->badge_color ?? 'red' }}-600 text-white text-[10px] font-bold px-3 py-1 rounded-full shadow-md uppercase tracking-wider">
                            {{ $menu->badge }}
                        </div>
                    @endif
                    
                    {{-- TOMBOL INTERAKSI (Hanya ada di sini biar ga dobel) --}}
                    <div class="absolute top-4 right-4 flex flex-col gap-2">
                        {{-- Like --}}
                        <button onclick="toggleLove({{ $menu->id }})" id="btn-love-{{ $menu->id }}" 
                            class="bg-white/90 backdrop-blur-sm p-2 rounded-full shadow-sm transition active:scale-90 flex items-center justify-center w-9 h-9 {{ in_array($menu->id, $likedMenus) ? 'text-red-600' : 'text-gray-400 hover:text-red-500' }}"
                            title="Suka (Like)">
                            <i class="fas fa-heart"></i>
                        </button>

                        {{-- Dislike --}}
                        <button onclick="toggleDislike({{ $menu->id }})" id="btn-dislike-{{ $menu->id }}" 
                            class="bg-white/90 backdrop-blur-sm p-2 rounded-full shadow-sm transition active:scale-90 flex items-center justify-center w-9 h-9 {{ in_array($menu->id, $dislikedMenus) ? 'text-slate-800' : 'text-gray-400 hover:text-slate-800' }}"
                            title="Tidak Suka (Dislike)">
                            <i class="fas fa-thumbs-down"></i>
                        </button>
                    </div>
                </div>

                <div class="p-6">
                    {{-- Statistik Rating Dinamis --}}
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center space-x-1 bg-yellow-50 px-2 py-1 rounded-lg border border-yellow-100">
                            <i class="fas fa-star text-yellow-400 text-xs"></i>
                            {{-- ID ini penting untuk update Javascript --}}
                            <span id="rating-text-{{ $menu->id }}" class="text-xs font-bold text-gray-700">{{ $ratingFormatted }}</span>
                            <span class="text-[10px] text-gray-400 ml-1">/ 5.0</span>
                        </div>
                        
                        {{-- Info Jumlah Vote Kecil --}}
                        <div class="text-[10px] text-gray-400">
                            (<span id="total-votes-{{ $menu->id }}">{{ $totalVotes }}</span> ulasan)
                        </div>
                    </div>

                    <h3 class="text-xl font-extrabold text-gray-900 mb-2 leading-tight group-hover:text-red-700 transition">{{ $menu->name }}</h3>
                    <p class="text-gray-500 text-sm leading-relaxed line-clamp-2">{{ $menu->description }}</p>
                </div>
            </div>
            @endforeach

        </div>
        
        <div class="text-center mt-8 md:mt-12 flex justify-center items-center gap-3 md:gap-4">
            <button onclick="scrollMenu('left')" class="bg-gray-100 hover:bg-gray-200 text-gray-600 w-10 h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center transition shadow-sm active:scale-95"><i class="fas fa-arrow-left"></i></button>
            <button onclick="scrollMenu('right')" class="bg-red-700 text-white font-bold px-6 py-2 md:px-8 md:py-3 text-sm md:text-base rounded-full hover:bg-red-800 transition shadow-lg flex items-center active:scale-95"><i class="fas fa-arrow-right ml-2"></i></button>
        </div>
    </div>

    <style>.no-scrollbar::-webkit-scrollbar { display: none; } .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }</style>

    <script>
        function scrollMenu(direction) {
            const container = document.getElementById('menu-slider');
            const scrollAmount = window.innerWidth < 768 ? 280 : 350; 
            if (direction === 'left') container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
            else container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        }

        // FUNGSI HITUNG RATING (MATEMATIKA)
        function updateRatingUI(id, likes, dislikes) {
            const ratingSpan = document.getElementById(`rating-text-${id}`);
            const totalVotesSpan = document.getElementById(`total-votes-${id}`);
            
            // Pastikan angka dibaca sebagai Integer
            likes = parseInt(likes);
            dislikes = parseInt(dislikes);

            const total = likes + dislikes;
            let rating = 0.0;

            if (total > 0) {
                rating = (likes / total) * 5;
            }

            // Update UI
            if(ratingSpan) ratingSpan.innerText = rating.toFixed(1); 
            if(totalVotesSpan) totalVotesSpan.innerText = total;
        }

        // FUNGSI LIKE
        function toggleLove(id) {
            const btnLove = document.getElementById(`btn-love-${id}`);
            const btnDislike = document.getElementById(`btn-dislike-${id}`);

            if (!btnLove) return;
            
            // Simpan icon asli untuk jaga-jaga
            const originalIcon = btnLove.innerHTML;
            btnLove.disabled = true; 

            fetch(`/menu/${id}/love`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    // 1. Update Tampilan Tombol Berdasarkan Status dari Server
                    if (data.is_liked) {
                        // JADI MERAH (Aktif)
                        btnLove.classList.remove('text-gray-400', 'hover:text-red-500');
                        btnLove.classList.add('text-red-600');
                        btnLove.innerHTML = '<i class="fas fa-heart fa-beat"></i>';
                        setTimeout(() => { btnLove.innerHTML = '<i class="fas fa-heart"></i>'; }, 1000);
                    } else {
                        // JADI ABU-ABU (Cancel Like)
                        btnLove.classList.remove('text-red-600');
                        btnLove.classList.add('text-gray-400', 'hover:text-red-500');
                        btnLove.innerHTML = '<i class="fas fa-heart"></i>';
                    }

                    // 2. Pastikan Tombol Lawan (Dislike) Mati/Abu-abu
                    if(btnDislike) {
                        btnDislike.classList.remove('text-slate-800');
                        btnDislike.classList.add('text-gray-400', 'hover:text-slate-800');
                    }

                    // 3. Hitung Ulang Rating (Tanpa Error Update Count manual)
                    updateRatingUI(id, data.likes, data.dislikes);
                }
            })
            .catch(err => {
                console.error(err);
                btnLove.innerHTML = originalIcon;
            })
            .finally(() => { btnLove.disabled = false; });
        }

        // FUNGSI DISLIKE
        function toggleDislike(id) {
            const btnDislike = document.getElementById(`btn-dislike-${id}`);
            const btnLove = document.getElementById(`btn-love-${id}`);

            if (!btnDislike) return;

            const originalIcon = btnDislike.innerHTML;
            btnDislike.disabled = true;

            fetch(`/menu/${id}/dislike`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    // 1. Update Tampilan Tombol Dislike
                    if (data.is_disliked) {
                        // JADI HITAM (Aktif)
                        btnDislike.classList.remove('text-gray-400', 'hover:text-slate-800');
                        btnDislike.classList.add('text-slate-800');
                    } else {
                        // JADI ABU-ABU (Cancel Dislike)
                        btnDislike.classList.remove('text-slate-800');
                        btnDislike.classList.add('text-gray-400', 'hover:text-slate-800');
                    }

                    // 2. Pastikan Tombol Lawan (Like) Mati/Abu-abu
                    if(btnLove) {
                        btnLove.classList.remove('text-red-600');
                        btnLove.classList.add('text-gray-400', 'hover:text-red-500');
                        // Reset icon love biar ga ada efek beat yg nyangkut
                        if(!btnLove.innerHTML.includes('fa-beat')) {
                             btnLove.innerHTML = '<i class="fas fa-heart"></i>';
                        }
                    }

                    // 3. Hitung Ulang Rating
                    updateRatingUI(id, data.likes, data.dislikes);
                }
            })
            .catch(err => {
                console.error(err);
                btnDislike.innerHTML = originalIcon;
            })
            .finally(() => { btnDislike.disabled = false; });
        }
    </script>
</section>
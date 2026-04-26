<section id="menu" class="py-8 bg-white">
    <div class="container mx-auto px-4">
        
        <div class="text-center mb-8 md:mb-12">
            <h2 class="text-3xl md:text-4xl font-extrabold text-red-700 uppercase mb-2">Menu Favorit</h2>
            <div class="w-24 h-1 bg-yellow-400 mx-auto"></div>
            <p class="text-gray-600 mt-4 text-sm md:text-base">Menu lezat kami akan lewat di depan Anda, pilih yang Anda suka!</p>
        </div>

        @php
            $likedMenus = session('liked_menus', []);
            $dislikedMenus = session('disliked_menus', []);
        @endphp

        <div id="menu-slider" class="flex overflow-x-hidden gap-5 md:gap-8 pb-10 px-2">
            @foreach($menus as $menu)
                {{-- LOGIKA HITUNG RATING (SUDAH DIPERBAIKI MENGGUNAKAN HATES) --}}
                @php
                    $totalVotes = $menu->loves + $menu->hates; 
                    $rating = $totalVotes > 0 ? ($menu->loves / $totalVotes) * 5 : 0;
                    $ratingFormatted = number_format($rating, 1);
                @endphp

            <div class="menu-item min-w-[85vw] sm:min-w-[300px] md:min-w-[350px] flex-none snap-center bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 group relative">
                <div class="h-56 md:h-64 overflow-hidden relative rounded-t-3xl">
                    <img src="{{ str_contains($menu->image, 'http') ? $menu->image : asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                    
                    @if($menu->badge)
                        <div class="absolute top-4 left-4 bg-{{ $menu->badge_color ?? 'red' }}-600 text-white text-[10px] font-bold px-3 py-1 rounded-full shadow-md uppercase tracking-wider">
                            {{ $menu->badge }}
                        </div>
                    @endif
                    
                    {{-- TOMBOL INTERAKSI --}}
                    <div class="absolute top-4 right-4 flex flex-col gap-2">
                        {{-- Like --}}
                        <button onclick="toggleLove({{ $menu->id }})" id="btn-love-{{ $menu->id }}" 
                            class="bg-white/90 backdrop-blur-sm p-2 rounded-full shadow-sm transition active:scale-90 flex items-center justify-center w-9 h-9 {{ in_array($menu->id, $likedMenus) ? 'text-red-600' : 'text-gray-400 hover:text-red-500' }}">
                            <i class="fas fa-heart"></i>
                        </button>

                        {{-- Dislike --}}
                        <button onclick="toggleDislike({{ $menu->id }})" id="btn-dislike-{{ $menu->id }}" 
                            class="bg-white/90 backdrop-blur-sm p-2 rounded-full shadow-sm transition active:scale-90 flex items-center justify-center w-9 h-9 {{ in_array($menu->id, $dislikedMenus) ? 'text-slate-800' : 'text-gray-400 hover:text-slate-800' }}">
                            <i class="fas fa-thumbs-down"></i>
                        </button>
                    </div>
                </div>

                <div class="p-6">
                    {{-- Statistik Rating --}}
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center space-x-1 bg-yellow-50 px-2 py-1 rounded-lg border border-yellow-100">
                            <i class="fas fa-star text-yellow-400 text-xs"></i>
                            <span id="rating-text-{{ $menu->id }}" class="text-xs font-bold text-gray-700">{{ $ratingFormatted }}</span>
                            <span class="text-[10px] text-gray-400 ml-1">/ 5.0</span>
                        </div>
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
    </div>

    <style>.no-scrollbar::-webkit-scrollbar { display: none; } .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }</style>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const slider = document.getElementById('menu-slider');
            let isPaused = false; 

            // FUNGSI AUTO SCROLL (ROTASI)
            function autoScroll() {
                if (isPaused || !slider) return;

                const firstCard = slider.firstElementChild;
                if (!firstCard) return;

                const gap = window.innerWidth < 768 ? 20 : 32; 
                const scrollAmount = firstCard.offsetWidth + gap;

                slider.scrollBy({ left: scrollAmount, behavior: 'smooth' });

                setTimeout(() => {
                    slider.appendChild(firstCard); 
                    slider.scrollLeft -= scrollAmount; 
                    slider.scrollTo({ left: 0, behavior: 'auto' });
                }, 600); 
            }

            let scrollInterval = setInterval(autoScroll, 3500);

            slider.addEventListener('mouseenter', () => isPaused = true);
            slider.addEventListener('mouseleave', () => isPaused = false);
        });

        // FUNGSI HITUNG RATING (MATEMATIKA) - SESUAIKAN DENGAN LOVES DAN HATES
        function updateRatingUI(id, loves, hates) {
            const ratingSpan = document.getElementById(`rating-text-${id}`);
            const totalVotesSpan = document.getElementById(`total-votes-${id}`);
            
            loves = parseInt(loves);
            hates = parseInt(hates);
            const total = loves + hates;
            let rating = 0.0;

            if (total > 0) {
                rating = (loves / total) * 5;
            }

            if(ratingSpan) ratingSpan.innerText = rating.toFixed(1); 
            if(totalVotesSpan) totalVotesSpan.innerText = total;
        }

        // FUNGSI LIKE
        function toggleLove(id) {
            const btnLove = document.getElementById(`btn-love-${id}`);
            const btnDislike = document.getElementById(`btn-dislike-${id}`);

            if (!btnLove) return;
            const originalIcon = btnLove.innerHTML;
            btnLove.disabled = true;

            fetch(`/menu/${id}/love`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    if (data.is_liked) {
                        btnLove.classList.remove('text-gray-400', 'hover:text-red-500');
                        btnLove.classList.add('text-red-600');
                        btnLove.innerHTML = '<i class="fas fa-heart fa-beat"></i>';
                        setTimeout(() => { btnLove.innerHTML = '<i class="fas fa-heart"></i>'; }, 1000);
                    } else {
                        btnLove.classList.remove('text-red-600');
                        btnLove.classList.add('text-gray-400', 'hover:text-red-500');
                        btnLove.innerHTML = '<i class="fas fa-heart"></i>';
                    }

                    if(btnDislike) {
                        btnDislike.classList.remove('text-slate-800');
                        btnDislike.classList.add('text-gray-400', 'hover:text-slate-800');
                    }
                    
                    // FIX: Masukkan parameter loves dan hates yang dikirim dari controller
                    updateRatingUI(id, data.loves, data.hates);
                }
            })
            .catch(err => { console.error(err); btnLove.innerHTML = originalIcon; })
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
                    if (data.is_disliked) {
                        btnDislike.classList.remove('text-gray-400', 'hover:text-slate-800');
                        btnDislike.classList.add('text-slate-800');
                    } else {
                        btnDislike.classList.remove('text-slate-800');
                        btnDislike.classList.add('text-gray-400', 'hover:text-slate-800');
                    }

                    if(btnLove) {
                        btnLove.classList.remove('text-red-600');
                        btnLove.classList.add('text-gray-400', 'hover:text-red-500');
                        if(!btnLove.innerHTML.includes('fa-heart')) { btnLove.innerHTML = '<i class="fas fa-heart"></i>'; }
                    }
                    
                    // FIX: Masukkan parameter loves dan hates yang dikirim dari controller
                    updateRatingUI(id, data.loves, data.hates);
                }
            })
            .catch(err => { console.error(err); btnDislike.innerHTML = originalIcon; })
            .finally(() => { btnDislike.disabled = false; });
        }
    </script>
</section>
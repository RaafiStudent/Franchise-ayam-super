<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📊 Laporan Popularitas Menu
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Kartu Ringkasan Atas --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                {{-- Kartu 1: Menu Terfavorit --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-gray-500 text-sm">Menu Paling Disukai</div>
                    <div class="text-2xl font-bold text-gray-800 truncate">
                        {{ $menus->first()->name ?? '-' }}
                    </div>
                    <div class="text-xs text-green-600 font-bold flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" /></svg>
                        {{ $menus->first()->loves ?? 0 }} Likes
                    </div>
                </div>
                
                {{-- Kartu 2: Total Varian --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-gray-500 text-sm">Total Varian Menu</div>
                    <div class="text-2xl font-bold text-gray-800">{{ $menus->count() }}</div>
                    <div class="text-xs text-blue-600">Item Tersedia</div>
                </div>

                {{-- Kartu 3: Total Voting --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-yellow-500">
                    <div class="text-gray-500 text-sm">Total Partisipasi User</div>
                    <div class="text-2xl font-bold text-gray-800">
                        {{ $menus->sum('loves') + $menus->sum('dislikes') }}
                    </div>
                    <div class="text-xs text-yellow-600">Suara Masuk (Like + Dislike)</div>
                </div>
            </div>

            {{-- Tabel Statistik Utama --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Peringkat Menu Berdasarkan Like</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full leading-normal">
                            <thead>
                                <tr class="bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <th class="px-5 py-3 border-b-2 border-gray-200">Rank</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200">Menu</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 text-center">👍 Suka</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 text-center">👎 Gak Suka</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 text-center">⭐ Rating</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($menus as $index => $menu)
                                    @php
                                        // Hitung Rating di PHP untuk Laporan
                                        $total = $menu->loves + $menu->dislikes;
                                        $rating = $total > 0 ? ($menu->loves / $total) * 5 : 0;
                                        $ratingFormatted = number_format($rating, 1);
                                    @endphp
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-5 py-5 border-b border-gray-200 text-sm">
                                        @if($index == 0) 
                                            <span class="text-2xl" title="Juara 1">🥇</span> 
                                        @elseif($index == 1) 
                                            <span class="text-2xl" title="Juara 2">🥈</span>
                                        @elseif($index == 2) 
                                            <span class="text-2xl" title="Juara 3">🥉</span>
                                        @else
                                            <span class="font-bold text-gray-500 pl-2">#{{ $index + 1 }}</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 text-sm">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 w-12 h-12">
                                                <img class="w-full h-full rounded-lg object-cover border"
                                                    src="{{ $menu->image }}"
                                                    alt="{{ $menu->name }}" />
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-gray-900 whitespace-no-wrap font-bold">
                                                    {{ $menu->name }}
                                                </p>
                                                @if($menu->badge)
                                                <span class="bg-gray-200 text-gray-600 py-0.5 px-2 rounded-full text-[10px]">
                                                    {{ $menu->badge }}
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 text-center">
                                        <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-xs font-bold">
                                            {{ $menu->loves }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 text-center">
                                        <span class="bg-red-100 text-red-800 py-1 px-3 rounded-full text-xs font-bold">
                                            {{ $menu->dislikes }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 text-center">
                                        <div class="flex items-center justify-center space-x-1 text-yellow-500 font-bold">
                                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                            <span>{{ $ratingFormatted }}</span>
                                        </div>
                                        <div class="text-[10px] text-gray-400">({{ $total }} vote)</div>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 text-center text-sm">
                                        @if($rating >= 4.5)
                                            <span class="text-green-600 font-bold flex items-center justify-center gap-1 bg-green-50 px-2 py-1 rounded-lg border border-green-200">
                                                <i class="fas fa-fire"></i> Populer
                                            </span>
                                        @elseif($rating >= 3.0)
                                            <span class="text-blue-600 font-semibold bg-blue-50 px-2 py-1 rounded-lg border border-blue-200">
                                                ✅ Aman
                                            </span>
                                        @else
                                            <span class="text-red-500 font-semibold flex items-center justify-center gap-1 bg-red-50 px-2 py-1 rounded-lg border border-red-200">
                                                ⚠️ Evaluasi
                                            </span>
                                        @endif
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
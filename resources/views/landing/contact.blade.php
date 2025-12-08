<section id="kontak" class="py-10 md:py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <h2 class="text-4xl font-extrabold text-red-700 uppercase mb-2">Hubungi Kami</h2>
            <div class="w-24 h-1 bg-yellow-400 mx-auto"></div>
            <p class="mt-4 text-gray-600">Kami siap mendengar masukan dan melayani pesanan Anda.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <div class="space-y-8">
                <div class="bg-white p-8 rounded-2xl shadow-lg border-l-8 border-red-700">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Outlet Pusat</h3>
                    
                    <div class="flex items-start space-x-4 mb-4">
                        <div class="bg-red-100 p-3 rounded-full text-red-700 flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div>
                            <p class="font-bold text-gray-800">Alamat</p>
                            <p class="text-gray-600 leading-relaxed">
                                Jl. Puter Gg. Bango No 20A, RT 05/RW 02<br>
                                Randugunting, Tegal Selatan<br>
                                Kota Tegal, Kode Pos 52131
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4 mb-4">
                        <div class="bg-red-100 p-3 rounded-full text-red-700 flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        </div>
                        <div>
                            <p class="font-bold text-gray-800">Telepon / WhatsApp</p>
                            <p class="text-gray-600">+62 812 3456 7890</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="bg-red-100 p-3 rounded-full text-red-700 flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="font-bold text-gray-800">Jam Operasional</p>
                            <p class="text-gray-600">Setiap Hari: 10.00 - 22.00 WIB</p>
                        </div>
                    </div>
                </div>
                
                {{-- Area Peta (Gunakan Link Google Maps Asli jika ada, ini dummy) --}}
                <div class="relative w-full h-64 rounded-2xl shadow-inner overflow-hidden group border border-gray-200">
                    <iframe class="w-full h-full border-0" 
                            src="https://maps.google.com/maps?q=tegal&t=&z=13&ie=UTF8&iwloc=&output=embed" 
                            allowfullscreen="" loading="lazy">
                    </iframe>

                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 backdrop-blur-[1px]">
                        <a href="https://goo.gl/maps/placeholder" 
                           target="_blank" 
                           class="bg-red-600 text-white font-bold py-2 px-6 rounded-full shadow-lg hover:bg-red-700 transition transform hover:scale-105 flex items-center gap-2">
                            <i class="fas fa-location-arrow"></i> Buka di Google Maps
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow-xl">
                <h3 class="text-2xl font-bold text-gray-800 mb-6">Kirim Saran & Kritik</h3>

                {{-- [PERBAIKAN 1]: Tambahkan Alert Pesan Sukses --}}
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                        <strong class="font-bold">Berhasil!</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                {{-- [PERBAIKAN 2]: Ubah Action ke Route yang benar --}}
                <form action="{{ route('contact.send') }}" method="POST"> 
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Nama Lengkap</label>
                        <input type="text" name="name" required class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:border-red-600 focus:outline-none focus:ring-1 focus:ring-red-600 transition" placeholder="Nama Anda">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Email / No. HP</label>
                        <input type="text" name="contact" required class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:border-red-600 focus:outline-none focus:ring-1 focus:ring-red-600 transition" placeholder="Kontak Anda">
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 font-bold mb-2">Pesan</label>
                        <textarea name="message" required class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:border-red-600 focus:outline-none focus:ring-1 focus:ring-red-600 transition h-32" placeholder="Tulis pesan anda..."></textarea>
                    </div>
                    <button type="submit" class="w-full bg-red-700 text-white font-bold py-3 rounded-lg hover:bg-red-800 shadow-lg transform active:scale-95 transition duration-200">
                        Kirim Pesan
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
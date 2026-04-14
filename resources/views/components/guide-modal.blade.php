@if(session('show_guide'))
<div x-data="{ 
    show: true, 
    step: 1,
    {{-- Update Max Step: Admin 6 Slide (Sesuai Menu), Mitra 4 Slide --}}
    maxStep: {{ Auth::user()->role === 'admin' ? 6 : 4 }},
    next() { if(this.step < this.maxStep) this.step++ },
    prev() { if(this.step > 1) this.step-- },
    finish() { this.show = false }
}" 
x-show="show" 
style="display: none;" 
class="fixed inset-0 z-[999] flex items-center justify-center bg-black/75 backdrop-blur-sm p-4"
x-transition:enter="transition ease-out duration-300"
x-transition:enter-start="opacity-0"
x-transition:enter-end="opacity-100">

    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden relative border border-gray-100" @click.away="show = false">
        
        {{-- Header Warna Dinamis --}}
        <div class="{{ Auth::user()->role === 'admin' ? 'bg-gray-900' : 'bg-red-600' }} h-36 flex items-center justify-center relative overflow-hidden">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
            
            <div class="z-10 text-center text-white p-4">
                <div class="bg-white/20 w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-2 backdrop-blur-sm border border-white/30">
                    @if(Auth::user()->role === 'admin')
                        <i class="fas fa-user-astronaut text-2xl"></i>
                    @else
                        <i class="fas fa-shopping-basket text-2xl"></i>
                    @endif
                </div>
                <h2 class="text-xl font-bold tracking-wide uppercase">
                    {{ Auth::user()->role === 'admin' ? 'TOUR PANEL ADMIN' : 'PANDUAN BELANJA MITRA' }}
                </h2>
                <p class="text-xs opacity-90 mt-1">
                    {{ Auth::user()->role === 'admin' ? 'Pelajari fitur dari kiri ke kanan menu.' : 'Simak cara belanja yang mudah.' }}
                </p>
            </div>

            <button @click="show = false" class="absolute top-4 right-4 text-white/70 hover:text-white transition">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <div class="p-8 h-[340px] overflow-y-auto">
            
            {{-- ================================================= --}}
            {{--                   KONTEN ADMIN                    --}}
            {{-- ================================================= --}}
            @if(Auth::user()->role === 'admin')
                
                {{-- Slide 1: Dashboard --}}
                <div x-show="step === 1" x-transition>
                    <h3 class="text-lg font-bold text-gray-800 border-b pb-2 mb-3">
                        <span class="bg-gray-200 text-gray-700 px-2 rounded text-sm mr-2">1</span> Dashboard Utama
                    </h3>
                    <p class="text-gray-600 text-sm mb-3">Halaman "Ibu Jari" bisnis Anda. Fokus pada 3 kartu statistik & status Mitra:</p>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex gap-3 bg-gray-50 p-2 rounded border border-gray-100">
                            <i class="fas fa-wallet text-green-500 mt-1"></i>
                            <div><strong>Omset Hari Ini:</strong> Hanya menghitung uang yang statusnya sudah <span class="text-green-600 font-bold">LUNAS</span>.</div>
                        </div>
                        <div class="flex gap-3 bg-gray-50 p-2 rounded border border-gray-100">
                            <i class="fas fa-users text-blue-500 mt-1"></i>
                            <div><strong>Validasi Mitra:</strong> Tombol <span class="text-green-600 font-bold">Active</span> (Hijau) artinya Mitra boleh belanja. Tombol <span class="text-red-500 font-bold">Banned</span> (Merah) untuk memblokir Mitra nakal.</div>
                        </div>
                    </div>
                </div>

                {{-- Slide 2: Laporan Keuangan --}}
                <div x-show="step === 2" x-transition>
                    <h3 class="text-lg font-bold text-gray-800 border-b pb-2 mb-3">
                        <span class="bg-gray-200 text-gray-700 px-2 rounded text-sm mr-2">2</span> Laporan Keuangan
                    </h3>
                    <p class="text-gray-600 text-sm mb-3">Analisis jangka panjang (Bulanan/Tahunan). Jangan cuma lihat omset harian!</p>
                    
                    <ul class="space-y-2 text-sm text-gray-700">
                        <li><i class="fas fa-chart-area text-purple-500 mr-2"></i> <strong>Grafik Tren:</strong> Melihat apakah bisnis sedang naik atau turun.</li>
                        <li><i class="fas fa-file-pdf text-red-500 mr-2"></i> <strong>Download PDF:</strong> Untuk arsip pembukuan fisik Anda.</li>
                        <li><i class="fas fa-bullseye text-orange-500 mr-2"></i> <strong>Indikator:</strong> Membandingkan total pesanan sukses vs batal.</li>
                    </ul>
                </div>

                {{-- Slide 3: Laporan Menu --}}
                <div x-show="step === 3" x-transition>
                    <h3 class="text-lg font-bold text-gray-800 border-b pb-2 mb-3">
                        <span class="bg-gray-200 text-gray-700 px-2 rounded text-sm mr-2">3</span> Laporan Menu
                    </h3>
                    <p class="text-gray-600 text-sm mb-3">Mengetahui selera pasar. Data ini diambil dari feedback pengunjung</p>
                    
                    <div class="grid grid-cols-2 gap-3 text-xs">
                        <div class="bg-green-50 p-2 rounded border border-green-100">
                            <i class="fas fa-thumbs-up text-green-600 mb-1"></i><br>
                            <strong>Like/Suka:</strong><br>Menu favorit Mitra. Pertahankan stoknya!
                        </div>
                        <div class="bg-red-50 p-2 rounded border border-red-100">
                            <i class="fas fa-thumbs-down text-red-600 mb-1"></i><br>
                            <strong>Dislike:</strong><br>Menu yang kurang laku atau rasanya perlu diperbaiki.
                        </div>
                        <div class="col-span-2 bg-yellow-50 p-2 rounded border border-yellow-100 flex items-center gap-2">
                            <i class="fas fa-star text-yellow-500"></i>
                            <span><strong>Rating Bintang:</strong> Skor rata-rata kepuasan (Maksimal 5.0).</span>
                        </div>
                    </div>
                </div>

                {{-- Slide 4: Produk --}}
                <div x-show="step === 4" x-transition>
                    <h3 class="text-lg font-bold text-gray-800 border-b pb-2 mb-3">
                        <span class="bg-gray-200 text-gray-700 px-2 rounded text-sm mr-2">4</span> Produk & Stok
                    </h3>
                    <p class="text-gray-600 text-sm mb-3">Gudang digital Anda. Pastikan stok selalu update agar Mitra tidak kecewa.</p>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded bg-yellow-100 text-yellow-600 flex items-center justify-center"><i class="fas fa-edit"></i></span>
                            <div><strong>Tombol Kuning (Edit):</strong> Klik untuk mengubah harga atau menambah jumlah stok saat barang datang.</div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded bg-red-100 text-red-600 flex items-center justify-center"><i class="fas fa-trash"></i></span>
                            <div><strong>Tombol Merah (Hapus):</strong> Menghapus menu selamanya dari aplikasi. Hati-hati!</div>
                        </div>
                    </div>
                </div>

                {{-- Slide 5: Kelola Pesanan --}}
                <div x-show="step === 5" x-transition>
                    <h3 class="text-lg font-bold text-gray-800 border-b pb-2 mb-3">
                        <span class="bg-gray-200 text-gray-700 px-2 rounded text-sm mr-2">5</span> Kelola Pesanan (PENTING)
                    </h3>
                    <p class="text-gray-600 text-sm mb-2">Pusat operasional pengiriman barang. Ikuti alur ini:</p>
                    
                    <ol class="list-decimal pl-4 space-y-2 text-sm text-gray-700">
                        <li>Cari status <span class="bg-green-100 text-green-700 px-1 rounded text-xs font-bold">LUNAS</span>. Jangan kirim jika masih "Belum Lunas".</li>
                        <li><strong>Input Resi & Kurir:</strong> Masukkan nama supir/ekspedisi dan plat nomor/resi di kolom input.</li>
                        <li>Klik tombol biru <strong>KIRIM SEKARANG</strong> <i class="fas fa-paper-plane text-blue-600"></i>.</li>
                        <li>Status akan berubah jadi <strong>Shipped</strong> dan Mitra bisa melacaknya.</li>
                    </ol>
                </div>

                {{-- Slide 6: Kotak Masuk --}}
                <div x-show="step === 6" x-transition>
                    <h3 class="text-lg font-bold text-gray-800 border-b pb-2 mb-3">
                        <span class="bg-gray-200 text-gray-700 px-2 rounded text-sm mr-2">6</span> Kotak Masuk
                    </h3>
                    <p class="text-gray-600 text-sm mb-4">Menerima kritik & saran langsung dari Mitra.</p>
                    
                    <div class="bg-gray-50 p-3 rounded border border-gray-200 mb-3 text-sm">
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-bold">raafi (mitra1@gmail.com)</span>
                            <span class="text-xs text-gray-500">04 Dec</span>
                        </div>
                        <p class="italic text-gray-600">"Ayamnya enak banget boss..."</p>
                    </div>

                    <div class="flex items-center gap-2 text-sm text-red-600">
                        <i class="fas fa-trash-alt"></i> 
                        <span>Gunakan tombol Sampah Merah untuk menghapus pesan yang sudah dibaca.</span>
                    </div>
                </div>

            {{-- ================================================= --}}
            {{--                   KONTEN MITRA                    --}}
            {{-- ================================================= --}}
            @else

                {{-- Slide 1: Cara Memesan --}}
                <div x-show="step === 1" x-transition>
                    <h3 class="text-xl font-bold text-gray-800 border-b pb-2 mb-4">
                        <i class="fas fa-cart-plus text-red-600 mr-2"></i> 1. Cara Memesan Stok
                    </h3>
                    <p class="text-gray-600 mb-4">Kehabisan bahan baku? Ikuti langkah mudah ini:</p>
                    <ol class="list-decimal pl-5 space-y-3 text-sm text-gray-700">
                        <li>Buka halaman <strong>Dashboard</strong> atau Menu Produk.</li>
                        <li>Pilih bahan yang mau dibeli (Pastikan stok tersedia).</li>
                        <li>Klik tombol <strong>+ Pesan</strong>. Barang akan masuk ke Keranjang (pojok kanan atas).</li>
                    </ol>
                </div>

                {{-- Slide 2: Checkout & Pembayaran --}}
                <div x-show="step === 2" x-transition>
                    <h3 class="text-xl font-bold text-gray-800 border-b pb-2 mb-4">
                        <i class="fas fa-credit-card text-blue-600 mr-2"></i> 2. Checkout & Bayar
                    </h3>
                    <p class="text-gray-600 text-sm mb-3">Setelah memilih barang, klik ikon Keranjang lalu <strong>Checkout</strong>.</p>
                    
                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                        <h4 class="font-bold text-blue-800 text-sm mb-2">Penting soal Pembayaran:</h4>
                        <p class="text-xs text-blue-700 leading-relaxed">
                            Sistem menggunakan Payment Gateway (Midtrans). Status pesanan Anda akan otomatis menjadi <strong>LUNAS (Paid)</strong> jika Anda membayar sesuai instruksi. Tidak perlu kirim bukti transfer manual ke Admin.
                        </p>
                    </div>
                </div>

                {{-- Slide 3: Pantau Pesanan --}}
                <div x-show="step === 3" x-transition>
                    <h3 class="text-xl font-bold text-gray-800 border-b pb-2 mb-4">
                        <i class="fas fa-truck text-purple-600 mr-2"></i> 3. Melacak Kiriman
                    </h3>
                    <p class="text-gray-600 text-sm mb-4">Buka menu <strong>Riwayat Pesanan</strong> untuk melihat update:</p>
                    <div class="grid grid-cols-2 gap-3 text-xs">
                        <div class="bg-yellow-100 p-2 rounded text-center">
                            <strong>Pending</strong><br>Menunggu Pembayaran
                        </div>
                        <div class="bg-blue-100 p-2 rounded text-center">
                            <strong>Processing</strong><br>Sedang Disiapkan Admin
                        </div>
                        <div class="bg-purple-100 p-2 rounded text-center col-span-2">
                            <strong>Shipped (Dikirim)</strong><br>
                            Barang sedang jalan. Nomor Resi & Kurir akan muncul di sini.
                        </div>
                    </div>
                </div>

                {{-- Slide 4: Konfirmasi Terima --}}
                <div x-show="step === 4" x-transition>
                    <h3 class="text-xl font-bold text-gray-800 border-b pb-2 mb-4">
                        <i class="fas fa-check-double text-green-600 mr-2"></i> 4. Konfirmasi Terima
                    </h3>
                    <p class="text-gray-600 text-sm mb-4">
                        Jika barang fisik sudah sampai di toko Anda, <strong>WAJIB</strong> melakukan konfirmasi agar transaksi selesai.
                    </p>
                    <div class="flex items-center justify-center p-4 bg-gray-50 rounded border border-dashed border-gray-300">
                        <button class="bg-green-100 text-green-600 px-4 py-2 rounded-full font-bold text-sm shadow-sm pointer-events-none opacity-80">
                            <i class="fas fa-check"></i> Tombol Terima Barang
                        </button>
                    </div>
                    <p class="text-center text-xs text-gray-500 mt-2">Tombol ini hanya muncul jika status pesanan sudah "Dikirim".</p>
                </div>

            @endif

        </div>

        {{-- Footer Navigasi --}}
        <div class="bg-gray-50 p-6 flex flex-col gap-4">
            {{-- Dots Indicator --}}
            <div class="flex justify-center gap-2">
                <template x-for="i in maxStep">
                    <div class="h-2 rounded-full transition-all duration-300" 
                         :class="i === step ? ({{ Auth::user()->role === 'admin' ? "'bg-gray-800 w-8'" : "'bg-red-600 w-8'" }}) : 'bg-gray-300 w-2'"></div>
                </template>
            </div>

            {{-- Tombol --}}
            <div class="flex justify-between items-center w-full">
                <button x-show="step > 1" @click="prev()" class="text-gray-500 hover:text-gray-800 font-medium px-4 py-2 rounded-lg hover:bg-gray-200 transition">
                    Kembali
                </button>
                <div x-show="step === 1" class="w-10"></div> 

                <button x-show="step < maxStep" @click="next()" class="{{ Auth::user()->role === 'admin' ? 'bg-gray-900 hover:bg-black' : 'bg-red-600 hover:bg-red-700' }} text-white px-6 py-2 rounded-full text-sm font-bold shadow-lg transition transform hover:scale-105">
                    Lanjut <i class="fas fa-arrow-right ml-1"></i>
                </button>

                <button x-show="step === maxStep" @click="finish()" class="bg-green-600 text-white px-8 py-2 rounded-full text-sm font-bold shadow-lg hover:bg-green-700 transition transform hover:scale-105">
                    Mengerti, Gasspoll! 🚀
                </button>
            </div>
        </div>

    </div>
</div>
@endif
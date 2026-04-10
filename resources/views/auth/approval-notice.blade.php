<x-guest-layout>
    <div class="mb-6 text-center">
        <div class="flex justify-center mb-6 relative">
            {{-- Efek animasi radar (ping) di belakang ikon agar terlihat hidup --}}
            <div class="absolute inline-flex w-20 h-20 bg-yellow-400 rounded-full opacity-20 animate-ping"></div>
            <div class="bg-yellow-100 p-4 rounded-full relative z-10 shadow-sm border-2 border-white">
                <i class="fas fa-user-clock text-5xl text-yellow-500"></i>
            </div>
        </div>
        
        <h2 class="text-2xl font-black text-gray-800 mb-2 uppercase tracking-wide">Pendaftaran Berhasil!</h2>
        
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-5 mt-4 shadow-inner">
            <p class="text-gray-700 font-medium text-sm leading-relaxed">
                Terima kasih telah mendaftar sebagai Mitra <span class="font-bold text-red-700">Ayam Super!</span>
            </p>
            <div class="my-3 flex justify-center">
                <span class="bg-yellow-400 text-yellow-900 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-sm">
                    Status: Pending Review
                </span>
            </div>
            <p class="text-xs text-gray-600">
                Tim Admin kami sedang memverifikasi data Anda. Anda bisa mengecek status secara berkala menggunakan tombol di bawah ini.
            </p>
        </div>
    </div>

    <div class="mt-8 flex flex-col space-y-3 border-t border-gray-100 pt-6">
        
        {{-- TOMBOL CEK STATUS (Mengarah ke dashboard untuk di-cek ulang oleh middleware) --}}
        <a href="{{ route('dashboard') }}" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 px-6 rounded-lg shadow-md transition flex items-center justify-center text-center text-sm">
            <i class="fas fa-sync-alt mr-2"></i> Cek Status Pendaftaran
        </a>

        {{-- TOMBOL LOGOUT --}}
        <form method="POST" action="{{ route('logout') }}" class="w-full">
            @csrf
            <button type="submit" class="w-full bg-white hover:bg-red-50 text-red-600 font-semibold py-3 px-6 rounded-lg border-2 border-red-100 transition flex items-center justify-center text-center text-sm">
                <i class="fas fa-sign-out-alt mr-2"></i> Kembali ke Halaman Utama
            </button>
        </form>

    </div>
</x-guest-layout>
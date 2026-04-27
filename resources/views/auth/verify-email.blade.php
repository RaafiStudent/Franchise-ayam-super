<x-guest-layout>
    <div class="mb-6 text-center">
        <div class="flex justify-center mb-4">
            <div class="bg-blue-100 p-4 rounded-full shadow-sm border-2 border-white">
                <i class="fas fa-envelope-open-text text-4xl text-blue-600"></i>
            </div>
        </div>
        <h2 class="text-2xl font-black text-gray-800 mb-2 uppercase tracking-wide">Cek Email Anda</h2>
        <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 mt-2">
            <p class="text-gray-600 text-sm leading-relaxed">
                Terima kasih telah mendaftar! Sebelum memulai, mohon verifikasi alamat email Anda dengan mengklik link yang baru saja kami kirimkan ke email Anda.
            </p>
        </div>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-bold text-sm text-green-600 bg-green-50 p-3 rounded-lg text-center border border-green-200">
            {{ __('Link verifikasi baru telah dikirim ke email Anda.') }}
        </div>
    @endif

    <div class="mt-6 flex flex-col space-y-3 border-t border-gray-100 pt-6">
        <form method="POST" action="{{ route('verification.send') }}" class="w-full">
            @csrf
            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg shadow-md transition flex items-center justify-center text-sm border-yellow-400 border-b-4 active:border-0">
                <i class="fas fa-paper-plane mr-2"></i> Kirim Ulang Email Verifikasi
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="w-full text-center mt-2">
            @csrf
            <button type="submit" class="text-sm text-gray-500 hover:text-red-600 font-semibold underline transition">
                {{ __('Keluar / Ganti Akun') }}
            </button>
        </form>
    </div>
</x-guest-layout>
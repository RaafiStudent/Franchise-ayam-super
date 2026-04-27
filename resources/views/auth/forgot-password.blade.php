<x-guest-layout>
    <div class="mb-8 text-center border-b-2 border-yellow-200 pb-4">
        <h2 class="text-3xl font-black text-red-700 uppercase drop-shadow-sm">Lupa Password?</h2>
        <p class="text-gray-500 text-sm font-medium mt-2">Jangan panik. Masukkan alamat email Anda yang terdaftar, dan kami akan mengirimkan link untuk membuat password baru.</p>
    </div>

    <x-auth-session-status class="mb-4 text-green-600 font-bold bg-green-50 p-3 rounded-lg border border-green-200 text-center" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Alamat Email')" class="text-red-800 font-bold"/>
            <x-text-input id="email" class="block mt-1 w-full border-2 border-gray-300 focus:border-yellow-500 focus:ring-yellow-500 rounded-lg" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-8">
            <a class="underline text-sm text-gray-500 hover:text-red-600 font-semibold" href="{{ route('login') }}">
                Kembali ke Login
            </a>
            <x-primary-button class="bg-red-600 hover:bg-red-700 text-white border-yellow-400 border-b-4 active:border-0 shadow-md">
                {{ __('Kirim Link Reset') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
<x-guest-layout>
    <div class="mb-8 text-center border-b-2 border-yellow-200 pb-4">
        <h2 class="text-3xl font-black text-red-700 uppercase drop-shadow-sm">Buat Password Baru</h2>
        <p class="text-gray-500 text-sm font-medium mt-2">Silakan ketikkan password baru untuk akun Anda.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <x-input-label for="email" :value="__('Email')" class="text-red-800 font-bold"/>
            <x-text-input id="email" class="block mt-1 w-full border-2 bg-gray-100 border-gray-200 text-gray-500 rounded-lg cursor-not-allowed" type="email" name="email" :value="old('email', $request->email)" required readonly />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4" x-data="{ showPw1: false }">
            <x-input-label for="password" :value="__('Password Baru')" class="text-red-800 font-bold"/>
            <div class="relative">
                <input id="password" :type="showPw1 ? 'text' : 'password'" name="password" required autocomplete="new-password" class="block mt-1 w-full border-2 border-gray-300 focus:border-yellow-500 focus:ring-yellow-500 rounded-lg pr-12" />
                <button type="button" @click="showPw1 = !showPw1" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-red-600 transition-colors focus:outline-none mt-0.5">
                    <i class="fas" :class="showPw1 ? 'fa-eye-slash' : 'fa-eye'"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4" x-data="{ showPw2: false }">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password Baru')" class="text-red-800 font-bold"/>
            <div class="relative">
                <input id="password_confirmation" :type="showPw2 ? 'text' : 'password'" name="password_confirmation" required autocomplete="new-password" class="block mt-1 w-full border-2 border-gray-300 focus:border-yellow-500 focus:ring-yellow-500 rounded-lg pr-12" />
                <button type="button" @click="showPw2 = !showPw2" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-red-600 transition-colors focus:outline-none mt-0.5">
                    <i class="fas" :class="showPw2 ? 'fa-eye-slash' : 'fa-eye'"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-8">
            <x-primary-button class="w-full justify-center bg-red-600 hover:bg-red-700 text-white border-yellow-400 border-b-4 active:border-0 shadow-md">
                {{ __('Simpan Password Baru') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
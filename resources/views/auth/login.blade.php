<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    {{-- JUDUL LOGIN YANG BARU: Gaul, Asik, Sopan --}}
    <div class="text-center mb-6">
        <h2 class="text-2xl font-black text-red-700 uppercase tracking-wide">
            Halo, Selamat Datang! 👋
        </h2>
        <p class="text-sm text-gray-500 mt-1 font-medium">
            Portal SCM khusus Admin, Mitra & Owner. Yuk, masuk!
        </p>
    </div>

    {{-- NOTIFIKASI ERROR (Untuk Akun Banned / Diblokir) --}}
    @if (session('error'))
        <div x-data="{ show: true }" x-show="show" class="mb-6 bg-red-50 border-l-4 border-red-600 p-4 rounded-r shadow-md relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 text-red-100 opacity-50">
                <i class="fas fa-ban text-6xl"></i>
            </div>
            
            <div class="relative flex items-start">
                <div class="flex-shrink-0 mt-0.5 bg-red-100 p-2 rounded-full flex items-center justify-center">
                    <i class="fas fa-user-lock text-red-600 text-lg"></i>
                </div>
                <div class="ml-4 pr-6">
                    <h3 class="text-sm font-bold text-red-800 uppercase tracking-wide">Akses Ditolak!</h3>
                    <p class="text-sm text-red-700 mt-1 font-medium">{{ session('error') }}</p>
                </div>
            </div>

            <button @click="show = false" class="absolute top-3 right-3 text-red-400 hover:text-red-700 transition">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" class="text-red-900 font-bold"/>
            <x-text-input id="email" class="block mt-1 w-full border-2 border-gray-200 focus:border-yellow-500 focus:ring-yellow-500 rounded-lg" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- FITUR IKON MATA PADA PASSWORD --}}
        <div class="mt-4" x-data="{ showPw: false }">
            <x-input-label for="password" :value="__('Password')" class="text-red-900 font-bold"/>
            <div class="relative">
                <input id="password" :type="showPw ? 'text' : 'password'" name="password" required autocomplete="current-password" class="block mt-1 w-full border-2 border-gray-200 focus:border-yellow-500 focus:ring-yellow-500 rounded-lg pr-12" />
                <button type="button" @click="showPw = !showPw" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-red-600 transition-colors focus:outline-none mt-0.5">
                    <i class="fas" :class="showPw ? 'fa-eye-slash' : 'fa-eye'"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Ingat Saya') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-6">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-500 hover:text-red-600 font-semibold" href="{{ route('password.request') }}">
                    {{ __('Lupa Password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3 w-full justify-center sm:w-auto">
                {{ __('Masuk Sekarang') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
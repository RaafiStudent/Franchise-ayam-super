<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <h2 class="text-2xl font-black text-center text-red-700 mb-6 uppercase tracking-wide">
        Login Mitra
    </h2>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" class="text-red-900 font-bold"/>
            <x-text-input id="email" class="block mt-1 w-full border-2 border-gray-200 focus:border-yellow-500 focus:ring-yellow-500 rounded-lg" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-red-900 font-bold"/>

            <x-text-input id="password" class="block mt-1 w-full border-2 border-gray-200 focus:border-yellow-500 focus:ring-yellow-500 rounded-lg"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

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
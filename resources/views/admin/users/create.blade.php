<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-red-800">{{ __('Tambah User Baru') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            {{-- 1. NOTIFIKASI ERROR (Jika Gagal Validasi) --}}
            @if ($errors->any())
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-r shadow-sm">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-exclamation-triangle mr-2 text-lg"></i>
                        <p class="font-bold">Gagal Menambahkan User!</p>
                    </div>
                    <ul class="list-disc list-inside text-sm ml-6">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- 2. NOTIFIKASI SUKSES (Biasanya muncul jika redirect kembali ke sini, meski di controller kita lempar ke index) --}}
            @if (session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-r shadow-sm">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2 text-lg"></i>
                        <p class="font-bold">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            {{-- FORM TAMBAH USER --}}
            <form action="{{ route('admin.users.store') }}" method="POST" class="bg-white p-8 rounded-lg shadow-md border border-gray-100">
                @csrf
                <div class="grid grid-cols-1 gap-6">
                    
                    <div>
                        <x-input-label for="name" :value="__('Nama Lengkap')" />
                        {{-- Fitur value="{{ old('name') }}" agar ketikan tidak hilang saat gagal --}}
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ old('name') }}" required autofocus />
                        {{-- Teks error kecil di bawah input --}}
                        @error('name') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" value="{{ old('email') }}" required />
                        @error('email') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="role" :value="__('Role')" />
                            <select name="role" class="block mt-1 w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm">
                                <option value="mitra" {{ old('role') == 'mitra' ? 'selected' : '' }}>Mitra</option>
                                <option value="owner" {{ old('role') == 'owner' ? 'selected' : '' }}>Owner</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('role') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <x-input-label for="status" :value="__('Status')" />
                            <select name="status" class="block mt-1 w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm">
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                            @error('status') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                        <p class="text-[10px] text-gray-400 mt-1">*Minimal 8 karakter</p>
                        @error('password') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                        <p class="text-[10px] text-gray-400 mt-1">*Harus sama persis dengan password di atas</p>
                    </div>

                </div>

                <div class="mt-8 flex justify-end gap-3 items-center pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium transition px-4 py-2">
                        Batal
                    </a>
                    <x-primary-button class="bg-red-700 hover:bg-red-800 px-6 py-2">
                        <i class="fas fa-save mr-2"></i> Simpan User
                    </x-primary-button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
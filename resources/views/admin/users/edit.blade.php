<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.users.index') }}" class="text-gray-500 hover:text-red-700 transition">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h2 class="font-bold text-xl text-red-800">{{ __('Edit Data User') }}</h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            {{-- NOTIFIKASI ERROR (Jika Gagal Validasi) --}}
            @if ($errors->any())
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-r shadow-sm">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-exclamation-triangle mr-2 text-lg"></i>
                        <p class="font-bold">Gagal Memperbarui User!</p>
                    </div>
                    <ul class="list-disc list-inside text-sm ml-6">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- FORM EDIT USER --}}
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="bg-white p-8 rounded-lg shadow-md border border-gray-100">
                @csrf
                @method('PUT') {{-- Method PUT wajib digunakan untuk proses Update di Laravel --}}

                <div class="grid grid-cols-1 gap-6">
                    
                    <div>
                        <x-input-label for="name" :value="__('Nama Lengkap')" />
                        {{-- Value diambil dari database ($user->name) --}}
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ old('name', $user->name) }}" required autofocus />
                        @error('name') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" value="{{ old('email', $user->email) }}" required />
                        @error('email') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="role" :value="__('Role')" />
                            <select name="role" class="block mt-1 w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm">
                                <option value="mitra" {{ old('role', $user->role) == 'mitra' ? 'selected' : '' }}>Mitra</option>
                                <option value="owner" {{ old('role', $user->role) == 'owner' ? 'selected' : '' }}>Owner</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('role') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <x-input-label for="status" :value="__('Status')" />
                            <select name="status" class="block mt-1 w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm">
                                <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="pending" {{ old('status', $user->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                            @error('status') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <h3 class="text-sm font-bold text-red-700 mb-2"><i class="fas fa-key mr-1"></i> Area Reset Password</h3>
                        <p class="text-xs text-gray-500 mb-4 bg-gray-50 p-2 border-l-2 border-gray-400">
                            <strong>Penting:</strong> Biarkan kolom password di bawah ini <u>KOSONG</u> jika Anda tidak ingin merubah kata sandi user ini.
                        </p>

                        <div class="mb-4">
                            <x-input-label for="password" :value="__('Password Baru (Opsional)')" />
                            <x-text-input id="password" class="block mt-1 w-full bg-gray-50 focus:bg-white" type="password" name="password" />
                            <p class="text-[10px] text-gray-400 mt-1">*Minimal 8 karakter. Isi hanya jika ingin mereset sandi.</p>
                            @error('password') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password Baru')" />
                            <x-text-input id="password_confirmation" class="block mt-1 w-full bg-gray-50 focus:bg-white" type="password" name="password_confirmation" />
                        </div>
                    </div>

                </div>

                <div class="mt-8 flex justify-end gap-3 items-center pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium transition px-4 py-2">
                        Batal
                    </a>
                    <x-primary-button class="bg-red-700 hover:bg-red-800 px-6 py-2">
                        <i class="fas fa-save mr-2"></i> Simpan Perubahan
                    </x-primary-button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
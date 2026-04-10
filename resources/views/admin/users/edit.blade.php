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

            {{-- UI NOTIFIKASI ERROR (Jika Gagal Edit, cth: email kembar/password beda) --}}
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm">
                    <div class="flex items-center mb-2">
                        <div class="flex-shrink-0 bg-red-100 rounded-full p-2 mr-3">
                            <i class="fas fa-exclamation-triangle text-red-600"></i>
                        </div>
                        <p class="font-bold text-red-800">Gagal Memperbarui Data!</p>
                    </div>
                    <ul class="list-disc list-inside text-sm text-red-700 ml-11">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- FORM EDIT USER --}}
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="bg-white p-8 rounded-lg shadow-md border border-gray-100">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-6">
                    
                    <div>
                        <x-input-label for="name" :value="__('Nama Lengkap')" />
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
                        </div>

                        <div>
                            <x-input-label for="status" :value="__('Status Akun')" />
                            <select name="status" class="block mt-1 w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm">
                                <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }} class="text-green-600 font-bold">Active (Aktif)</option>
                                <option value="pending" {{ old('status', $user->status) == 'pending' ? 'selected' : '' }} class="text-yellow-600 font-bold">Pending (Menunggu)</option>
                                {{-- INI FITUR BLOKIR BARU --}}
                                <option value="banned" {{ old('status', $user->status) == 'banned' ? 'selected' : '' }} class="text-red-600 font-bold">Banned (Blokir)</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <h3 class="text-sm font-bold text-red-700 mb-2"><i class="fas fa-key mr-1"></i> Area Reset Password</h3>
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-3 mb-4 rounded-r text-xs text-blue-700 flex items-start">
                            <i class="fas fa-info-circle mt-0.5 mr-2"></i>
                            <p><strong>Opsional:</strong> Biarkan kolom sandi di bawah ini <u>KOSONG</u> jika Anda hanya ingin merubah Nama, Email, atau Status.</p>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="password" :value="__('Sandi Baru (Opsional)')" />
                            <x-text-input id="password" class="block mt-1 w-full bg-gray-50 focus:bg-white" type="password" name="password" />
                            @error('password') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <x-input-label for="password_confirmation" :value="__('Konfirmasi Sandi Baru')" />
                            <x-text-input id="password_confirmation" class="block mt-1 w-full bg-gray-50 focus:bg-white" type="password" name="password_confirmation" />
                        </div>
                    </div>

                </div>

                <div class="mt-8 flex justify-end gap-3 items-center pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium transition px-4 py-2">
                        Batal
                    </a>
                    <button type="submit" class="bg-red-700 hover:bg-red-800 text-white font-bold px-6 py-2 rounded-md shadow-sm transition">
                        <i class="fas fa-save mr-2"></i> Simpan Perubahan
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
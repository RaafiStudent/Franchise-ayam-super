<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-red-800">{{ __('Tambah User Baru') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

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

            <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" x-data="{ role: '{{ old('role', 'mitra') }}' }" class="bg-white p-8 rounded-xl shadow-md border border-gray-100">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <div class="col-span-1 md:col-span-2">
                        <x-input-label for="name" :value="__('Nama Lengkap')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ old('name') }}" required autofocus />
                        @error('name') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" value="{{ old('email') }}" required />
                        @error('email') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <x-input-label for="role" :value="__('Hak Akses (Role)')" />
                        <select name="role" x-model="role" class="block mt-1 w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm">
                            <option value="mitra">Mitra Cabang</option>
                            <option value="owner">Owner (Pemilik)</option>
                            <option value="admin">Administrator</option>
                        </select>
                        @error('role') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    <div x-show="role === 'mitra'" x-transition class="col-span-1 md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6 bg-yellow-50 p-6 rounded-lg border border-yellow-200 mt-2 mb-2">
                        <div class="col-span-1 md:col-span-2 flex items-center mb-2">
                            <i class="fas fa-id-card text-yellow-600 text-xl mr-2"></i>
                            <h3 class="font-bold text-yellow-800">Kelengkapan Data Mitra</h3>
                        </div>

                        <div>
                            <x-input-label for="no_hp" :value="__('No Handphone (WA)')" />
                            <x-text-input id="no_hp" class="block mt-1 w-full" type="text" name="no_hp" value="{{ old('no_hp') }}" placeholder="Contoh: 08123456789" />
                        </div>

                        <div>
                            <x-input-label for="ktp_image" :value="__('Upload Foto KTP')" />
                            <input id="ktp_image" type="file" name="ktp_image" accept="image/*" class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 border border-gray-300 rounded-md bg-white"/>
                            <p class="text-[10px] text-gray-500 mt-1">*Format: JPG/PNG, Maks: 2MB.</p>
                        </div>

                        <div>
                            <x-input-label for="provinsi" :value="__('Provinsi')" />
                            <select name="provinsi" id="provinsi" class="block mt-1 w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm">
                                <option value="">Pilih Provinsi...</option>
                                <option value="Jawa Tengah" {{ old('provinsi') == 'Jawa Tengah' ? 'selected' : '' }}>Jawa Tengah</option>
                                <option value="Jawa Barat" {{ old('provinsi') == 'Jawa Barat' ? 'selected' : '' }}>Jawa Barat</option>
                                <option value="Jawa Timur" {{ old('provinsi') == 'Jawa Timur' ? 'selected' : '' }}>Jawa Timur</option>
                                <option value="DKI Jakarta" {{ old('provinsi') == 'DKI Jakarta' ? 'selected' : '' }}>DKI Jakarta</option>
                            </select>
                        </div>

                        <div>
                            <x-input-label for="kota" :value="__('Kota / Kabupaten')" />
                            <x-text-input id="kota" class="block mt-1 w-full" type="text" name="kota" value="{{ old('kota') }}" placeholder="Contoh: Semarang" />
                        </div>

                        <div class="col-span-1 md:col-span-2">
                            <x-input-label for="alamat_lengkap" :value="__('Alamat Lengkap')" />
                            <textarea id="alamat_lengkap" name="alamat_lengkap" rows="3" class="block mt-1 w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm">{{ old('alamat_lengkap') }}</textarea>
                        </div>
                    </div>

                    <div>
                        <x-input-label for="status" :value="__('Status Akun')" />
                        <select name="status" class="block mt-1 w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Menunggu Persetujuan</option>
                            <option value="banned" {{ old('status') == 'banned' ? 'selected' : '' }}>Blokir (Banned)</option>
                        </select>
                    </div>

                    <div class="col-span-1 md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6 mt-2">
                        <div>
                            <x-input-label for="password" :value="__('Password')" />
                            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                            <p class="text-[10px] text-gray-400 mt-1">*Minimal 8 karakter</p>
                            @error('password') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex justify-end gap-3 items-center pt-5 border-t border-gray-100">
                    <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-500 hover:text-gray-800 font-medium transition px-4 py-2">
                        Batal
                    </a>
                    <button type="submit" class="bg-red-700 hover:bg-red-800 text-white font-semibold px-6 py-2.5 rounded-lg shadow-md transition flex items-center">
                        <i class="fas fa-save mr-2"></i> Simpan Pengguna
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
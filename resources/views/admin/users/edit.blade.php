<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.users.index') }}" class="text-gray-500 hover:text-red-700 transition">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <h2 class="font-bold text-xl text-red-800">{{ __('Edit Data Pengguna') }}</h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if ($errors->any())
                <div x-data="{ show: true }" x-show="show" class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm">
                    <div class="flex justify-between items-start">
                        <div class="flex">
                            <div class="flex-shrink-0 bg-red-100 rounded-full p-2 h-10 w-10 flex items-center justify-center">
                                <i class="fas fa-times text-red-600"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-bold text-red-800">Gagal Memperbarui Data!</h3>
                                <div class="mt-1 text-sm text-red-700">
                                    <ul class="list-disc list-inside space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <button @click="show = false" class="text-red-400 hover:text-red-600 transition">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            @endif

            {{-- Form dengan Alpine.js untuk mendeteksi role saat pertama kali halaman dimuat --}}
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data" x-data="{ role: '{{ old('role', $user->role) }}' }" class="bg-white p-8 rounded-xl shadow-md border border-gray-100">
                @csrf
                @method('PUT') 

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <div class="col-span-1 md:col-span-2">
                        <x-input-label for="name" :value="__('Nama Lengkap')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ old('name', $user->name) }}" required autofocus />
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Alamat Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" value="{{ old('email', $user->email) }}" required />
                    </div>

                    <div>
                        <x-input-label for="role" :value="__('Hak Akses (Role)')" />
                        <select name="role" disabled class="block mt-1 w-full border-gray-300 bg-gray-100 text-gray-500 cursor-not-allowed focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm">
                            <option value="mitra" {{ $user->role == 'mitra' ? 'selected' : '' }}>Mitra Cabang</option>
                            <option value="owner" {{ $user->role == 'owner' ? 'selected' : '' }}>Owner (Pemilik)</option>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrator</option>
                        </select>
                        <p class="text-[10px] text-red-500 mt-1 font-bold">*Role tidak dapat diubah demi keamanan sistem.</p>
                    </div>

                    <div x-show="role === 'mitra'" x-transition class="col-span-1 md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6 bg-yellow-50 p-6 rounded-lg border border-yellow-200 mt-2 mb-2">
                        <div class="col-span-1 md:col-span-2 flex items-center mb-2">
                            <i class="fas fa-id-card text-yellow-600 text-xl mr-2"></i>
                            <h3 class="font-bold text-yellow-800">Kelengkapan Data Mitra</h3>
                        </div>

                        <div>
                            <x-input-label for="no_hp" :value="__('No Handphone (WA)')" />
                            <x-text-input id="no_hp" class="block mt-1 w-full" type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}" />
                        </div>

                        <div>
                            <x-input-label for="ktp_image" :value="__('Upload Foto KTP Baru')" />
                            <input id="ktp_image" type="file" name="ktp_image" accept="image/*" class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 border border-gray-300 rounded-md bg-white"/>
                            <p class="text-[10px] text-gray-500 mt-1">*Kosongkan jika tidak ingin mengganti foto KTP lama.</p>
                            
                            @if($user->ktp_image)
                                <div class="mt-3">
                                    <p class="text-xs font-semibold text-gray-600 mb-1">KTP Saat Ini:</p>
                                    <a href="{{ asset('storage/' . $user->ktp_image) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $user->ktp_image) }}" alt="KTP {{ $user->name }}" class="h-20 w-auto object-cover rounded border border-gray-300 shadow-sm hover:opacity-75 transition">
                                    </a>
                                </div>
                            @endif
                        </div>

                        <div>
                            <x-input-label for="provinsi" :value="__('Provinsi')" />
                            <select name="provinsi" id="provinsi" class="block mt-1 w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm">
                                <option value="">Pilih Provinsi...</option>
                                <option value="Jawa Tengah" {{ old('provinsi', $user->provinsi) == 'Jawa Tengah' ? 'selected' : '' }}>Jawa Tengah</option>
                                <option value="Jawa Barat" {{ old('provinsi', $user->provinsi) == 'Jawa Barat' ? 'selected' : '' }}>Jawa Barat</option>
                                <option value="Jawa Timur" {{ old('provinsi', $user->provinsi) == 'Jawa Timur' ? 'selected' : '' }}>Jawa Timur</option>
                                <option value="DKI Jakarta" {{ old('provinsi', $user->provinsi) == 'DKI Jakarta' ? 'selected' : '' }}>DKI Jakarta</option>
                            </select>
                        </div>

                        <div>
                            <x-input-label for="kota" :value="__('Kota / Kabupaten')" />
                            <x-text-input id="kota" class="block mt-1 w-full" type="text" name="kota" value="{{ old('kota', $user->kota) }}" />
                        </div>

                        <div class="col-span-1 md:col-span-2">
                            <x-input-label for="alamat_lengkap" :value="__('Alamat Lengkap')" />
                            <textarea id="alamat_lengkap" name="alamat_lengkap" rows="3" class="block mt-1 w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm">{{ old('alamat_lengkap', $user->alamat_lengkap) }}</textarea>
                        </div>
                    </div>

                    <div class="col-span-1 md:col-span-2">
                        <x-input-label for="status" :value="__('Status Akun')" />
                        <select name="status" class="block mt-1 w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm">
                            <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="pending" {{ old('status', $user->status) == 'pending' ? 'selected' : '' }}>Menunggu Persetujuan</option>
                            <option value="banned" {{ old('status', $user->status) == 'banned' ? 'selected' : '' }}>Blokir (Banned)</option>
                        </select>
                    </div>

                    <div class="col-span-1 md:col-span-2 mt-4 pt-6 border-t border-gray-100">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="bg-red-100 p-2 rounded text-red-700"><i class="fas fa-lock"></i></div>
                            <h3 class="text-md font-bold text-gray-800">Ubah Kata Sandi</h3>
                        </div>
                        <p class="text-xs text-gray-500 mb-4 bg-gray-50 p-3 rounded-lg border border-gray-200">
                            <strong>Info:</strong> Biarkan kolom di bawah ini <u>tetap kosong</u> jika Anda tidak ingin mengubah kata sandi pengguna ini.
                        </p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="password" :value="__('Kata Sandi Baru')" />
                                <x-text-input id="password" class="block mt-1 w-full bg-gray-50 focus:bg-white" type="password" name="password" placeholder="Opsional" />
                                @error('password') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <x-input-label for="password_confirmation" :value="__('Ulangi Kata Sandi Baru')" />
                                <x-text-input id="password_confirmation" class="block mt-1 w-full bg-gray-50 focus:bg-white" type="password" name="password_confirmation" placeholder="Opsional" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex justify-end gap-3 items-center pt-5 border-t border-gray-100">
                    <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-500 hover:text-gray-800 font-medium transition px-4 py-2">
                        Batal
                    </a>
                    <button type="submit" class="bg-red-700 hover:bg-red-800 text-white font-semibold px-6 py-2.5 rounded-lg shadow-md transition flex items-center">
                        <i class="fas fa-check-circle mr-2"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
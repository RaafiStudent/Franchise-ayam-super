<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="p-4">
        @csrf

        <div class="mb-6 text-center">
            <h2 class="text-2xl font-bold text-red-700">Daftar Mitra Baru</h2>
            <p class="text-gray-600 text-sm">Lengkapi data diri dan upload KTP untuk bergabung.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="name" :value="__('Nama Lengkap')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="no_hp" :value="__('No Handphone (WA)')" />
                <x-text-input id="no_hp" class="block mt-1 w-full" type="number" name="no_hp" :value="old('no_hp')" required />
                <x-input-error :messages="$errors->get('no_hp')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="mt-4">
            <x-input-label for="alamat_lengkap" :value="__('Alamat Lengkap (Jalan, RT/RW)')" />
            <textarea id="alamat_lengkap" name="alamat_lengkap" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500" rows="2" required>{{ old('alamat_lengkap') }}</textarea>
            <x-input-error :messages="$errors->get('alamat_lengkap')" class="mt-2" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <div>
                <x-input-label for="provinsi" :value="__('Provinsi')" />
                <select id="provinsi_select" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500" required>
                    <option value="">Pilih Provinsi...</option>
                </select>
                <input type="hidden" name="provinsi" id="provinsi_name"> 
            </div>
            
            <div>
                <x-input-label for="kota" :value="__('Kota / Kabupaten')" />
                <select id="kota_select" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500" disabled required>
                    <option value="">Pilih Kota...</option>
                </select>
                <input type="hidden" name="kota" id="kota_name">
            </div>
        </div>

        <div class="mt-4">
            <x-input-label for="ktp_image" :value="__('Upload Foto KTP')" />
            <input id="ktp_image" type="file" name="ktp_image" class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100" required accept="image/*">
            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Maks 2MB.</p>
            <x-input-error :messages="$errors->get('ktp_image')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="catatan" :value="__('Catatan Tambahan (Opsional)')" />
            <textarea id="catatan" name="catatan" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500">{{ old('catatan') }}</textarea>
        </div>

        <div class="flex items-center justify-end mt-6">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Sudah punya akun?') }}
            </a>

            <x-primary-button class="ms-4 bg-red-700 hover:bg-red-800">
                {{ __('Daftar Sekarang') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const provinsiSelect = document.getElementById('provinsi_select');
            const kotaSelect = document.getElementById('kota_select');
            const provinsiNameInput = document.getElementById('provinsi_name');
            const kotaNameInput = document.getElementById('kota_name');

            // 1. Ambil Data Provinsi
            fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')
                .then(response => response.json())
                .then(provinces => {
                    provinces.forEach(province => {
                        const option = document.createElement('option');
                        option.value = province.id; // ID untuk request kota
                        option.text = province.name; // Nama untuk ditampilkan
                        provinsiSelect.add(option);
                    });
                });

            // 2. Saat Provinsi Dipilih
            provinsiSelect.addEventListener('change', function() {
                const provinceId = this.value;
                const provinceName = this.options[this.selectedIndex].text;
                
                // Simpan Nama Provinsi ke Input Hidden (untuk dikirim ke Controller)
                provinsiNameInput.value = provinceName;

                // Reset Kota
                kotaSelect.innerHTML = '<option value="">Pilih Kota...</option>';
                kotaSelect.disabled = true;

                if (provinceId) {
                    kotaSelect.disabled = false;
                    fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provinceId}.json`)
                        .then(response => response.json())
                        .then(regencies => {
                            regencies.forEach(regency => {
                                const option = document.createElement('option');
                                option.value = regency.name; // Kita langsung pakai Namanya saja
                                option.text = regency.name;
                                kotaSelect.add(option);
                            });
                        });
                }
            });

            // 3. Saat Kota Dipilih
            kotaSelect.addEventListener('change', function() {
                // Simpan Nama Kota ke Input Hidden
                kotaNameInput.value = this.value;
            });
        });
    </script>
</x-guest-layout>
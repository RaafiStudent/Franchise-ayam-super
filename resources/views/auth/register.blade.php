<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-8 text-center border-b-2 border-yellow-200 pb-4">
            <h2 class="text-3xl font-black text-red-700 uppercase drop-shadow-sm">Gabung Mitra</h2>
            <p class="text-gray-500 text-sm font-medium mt-1">Mulai suksesmu bersama Ayam Super!</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="name" :value="__('Nama Lengkap')" class="text-red-800 font-bold"/>
                <x-text-input id="name" class="block mt-1 w-full border-2 focus:border-yellow-500 focus:ring-yellow-500 rounded-lg" type="text" name="name" :value="old('name')" required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="email" :value="__('Email')" class="text-red-800 font-bold"/>
                <x-text-input id="email" class="block mt-1 w-full border-2 focus:border-yellow-500 focus:ring-yellow-500 rounded-lg" type="email" name="email" :value="old('email')" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="no_hp" :value="__('No Handphone (WA)')" class="text-red-800 font-bold"/>
                <x-text-input id="no_hp" class="block mt-1 w-full border-2 focus:border-yellow-500 focus:ring-yellow-500 rounded-lg" type="number" name="no_hp" :value="old('no_hp')" required />
                <x-input-error :messages="$errors->get('no_hp')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password" :value="__('Password')" class="text-red-800 font-bold"/>
                <x-text-input id="password" class="block mt-1 w-full border-2 focus:border-yellow-500 focus:ring-yellow-500 rounded-lg" type="password" name="password" required />
            </div>

            <div>
                <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="text-red-800 font-bold"/>
                <x-text-input id="password_confirmation" class="block mt-1 w-full border-2 focus:border-yellow-500 focus:ring-yellow-500 rounded-lg" type="password" name="password_confirmation" required />
            </div>
        </div>

        <div class="mt-4">
            <x-input-label for="alamat_lengkap" :value="__('Alamat Lengkap')" class="text-red-800 font-bold"/>
            <textarea id="alamat_lengkap" name="alamat_lengkap" class="block mt-1 w-full border-2 border-gray-300 rounded-lg shadow-sm focus:border-yellow-500 focus:ring-yellow-500" rows="2" required>{{ old('alamat_lengkap') }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4 bg-yellow-50 p-3 rounded-lg border border-yellow-200">
            <div>
                <x-input-label for="provinsi" :value="__('Provinsi')" class="text-red-800 font-bold"/>
                <select id="provinsi_select" class="block mt-1 w-full border-2 border-gray-300 rounded-lg shadow-sm focus:border-yellow-500 focus:ring-yellow-500" required>
                    <option value="">Pilih Provinsi...</option>
                </select>
                <input type="hidden" name="provinsi" id="provinsi_name"> 
            </div>
            
            <div>
                <x-input-label for="kota" :value="__('Kota / Kabupaten')" class="text-red-800 font-bold"/>
                <select id="kota_select" class="block mt-1 w-full border-2 border-gray-300 rounded-lg shadow-sm focus:border-yellow-500 focus:ring-yellow-500" disabled required>
                    <option value="">Pilih Kota...</option>
                </select>
                <input type="hidden" name="kota" id="kota_name">
            </div>
        </div>

        <div class="mt-4">
            <x-input-label for="ktp_image" :value="__('Upload Foto KTP')" class="text-red-800 font-bold"/>
            <input id="ktp_image" type="file" name="ktp_image" class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-red-100 file:text-red-700 hover:file:bg-red-200" required accept="image/*">
        </div>

        <div class="flex items-center justify-end mt-8">
            <a class="underline text-sm text-gray-600 hover:text-red-700 font-medium" href="{{ route('login') }}">
                {{ __('Sudah punya akun?') }}
            </a>

            <x-primary-button class="ms-4 bg-red-600 hover:bg-red-700 text-white border-yellow-400 border-b-4 active:border-0">
                {{ __('Daftar Sekarang') }}
            </x-primary-button>
        </div>
    </form>
    
    <script>
        // ... (Script Wilayah Indonesia tetap sama) ...
        document.addEventListener("DOMContentLoaded", function() {
            const provinsiSelect = document.getElementById('provinsi_select');
            const kotaSelect = document.getElementById('kota_select');
            const provinsiNameInput = document.getElementById('provinsi_name');
            const kotaNameInput = document.getElementById('kota_name');

            fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')
                .then(response => response.json())
                .then(provinces => {
                    provinces.forEach(province => {
                        const option = document.createElement('option');
                        option.value = province.id; 
                        option.text = province.name; 
                        provinsiSelect.add(option);
                    });
                });

            provinsiSelect.addEventListener('change', function() {
                const provinceId = this.value;
                const provinceName = this.options[this.selectedIndex].text;
                provinsiNameInput.value = provinceName;
                kotaSelect.innerHTML = '<option value="">Pilih Kota...</option>';
                kotaSelect.disabled = true;

                if (provinceId) {
                    kotaSelect.disabled = false;
                    fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provinceId}.json`)
                        .then(response => response.json())
                        .then(regencies => {
                            regencies.forEach(regency => {
                                const option = document.createElement('option');
                                option.value = regency.name; 
                                option.text = regency.name;
                                kotaSelect.add(option);
                            });
                        });
                }
            });

            kotaSelect.addEventListener('change', function() {
                kotaNameInput.value = this.value;
            });
        });
    </script>
</x-guest-layout>
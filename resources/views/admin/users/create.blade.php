<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-red-800">{{ __('Tambah User Baru') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('admin.users.store') }}" method="POST" class="bg-white p-8 rounded-lg shadow-md">
                @csrf
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <x-input-label for="name" :value="__('Nama Lengkap')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" required />
                    </div>
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" required />
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="role" :value="__('Role')" />
                            <select name="role" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500">
                                <option value="mitra">Mitra</option>
                                <option value="owner">Owner</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div>
                            <x-input-label for="status" :value="__('Status')" />
                            <select name="status" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500">
                                <option value="active">Active</option>
                                <option value="pending">Pending</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                    </div>
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                    </div>
                </div>
                <div class="mt-6 flex justify-end">
                    <x-primary-button class="bg-red-700 hover:bg-red-800">Simpan User</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
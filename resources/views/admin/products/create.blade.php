<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Produk Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Produk</label>
                            <input type="text" name="name" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-red-300" required placeholder="Contoh: Ayam Marinasi 1 Ekor">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
                            <textarea name="description" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-red-300" rows="3"></textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Harga Mitra (Rp)</label>
                                <input type="number" name="price" class="w-full border rounded px-3 py-2" required placeholder="50000">
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Stok Awal</label>
                                <input type="number" name="stock" class="w-full border rounded px-3 py-2" required placeholder="100">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Foto Produk</label>
                            <input type="file" name="image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-red-50 file:text-red-700 hover:file:bg-red-100" required>
                        </div>

                        <div class="flex justify-end mt-6">
                            <a href="{{ route('admin.products.index') }}" class="text-gray-500 mr-4 mt-2">Batal</a>
                            <button type="submit" class="bg-red-700 hover:bg-red-800 text-white font-bold py-2 px-4 rounded">
                                Simpan Produk
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
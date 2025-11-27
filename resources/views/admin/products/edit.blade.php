<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900">
                    
                    {{-- Form mengarah ke Route UPDATE --}}
                    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') {{-- PENTING: Method PUT untuk Update data --}}
                        
                        {{-- Nama Produk --}}
                        <div class="mb-5">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Produk</label>
                            {{-- value="{{ old(..., $product->name) }}" artinya: Isi dengan data lama --}}
                            <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring focus:ring-red-200" required>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-5">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi Singkat</label>
                            <textarea name="description" class="w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring focus:ring-red-200" rows="3">{{ old('description', $product->description) }}</textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-5">
                            {{-- Harga --}}
                            <div class="mb-5">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Harga Mitra (Rp)</label>
                                <input type="number" name="price" value="{{ old('price', $product->price) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring focus:ring-red-200" required>
                            </div>

                            {{-- Stok --}}
                            <div class="mb-5">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Stok Gudang</label>
                                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring focus:ring-red-200" required>
                            </div>
                        </div>

                        {{-- Foto --}}
                        <div class="mb-5">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Foto Produk (Opsional)</label>
                            
                            {{-- Tampilkan foto lama --}}
                            @if($product->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $product->image) }}" class="w-32 h-32 object-cover rounded border">
                                    <p class="text-xs text-gray-500 mt-1">Foto saat ini</p>
                                </div>
                            @endif

                            <input type="file" name="image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                            <p class="text-xs text-gray-400 mt-1">*Biarkan kosong jika tidak ingin mengganti foto.</p>
                        </div>

                        {{-- Tombol --}}
                        <div class="flex justify-end mt-8 border-t pt-4">
                            <a href="{{ route('admin.products.index') }}" class="text-gray-500 mr-4 mt-2 hover:text-gray-700">Batal</a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded shadow-lg transition">
                                Update Produk
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
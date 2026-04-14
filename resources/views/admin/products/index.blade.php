<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen Produk / Stok') }}
            </h2>
            <a href="{{ route('admin.products.create') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded shadow-lg transition duration-300">
                + Tambah Produk
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Notif Sukses --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead class="bg-gray-100 uppercase text-gray-600 text-sm font-bold">
                            <tr>
                                <th class="py-3 px-6 text-left">Foto</th>
                                <th class="py-3 px-6 text-left">Info Produk</th>
                                <th class="py-3 px-6 text-center">Harga Mitra</th>
                                <th class="py-3 px-6 text-center">Stok Gudang</th>
                                <th class="py-3 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @forelse($products as $product)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="py-3 px-6 text-left">
                                    <img src="{{ asset('storage/' . $product->image) }}" class="w-20 h-20 object-cover rounded border border-gray-300">
                                </td>
                                <td class="py-3 px-6 text-left">
                                    <span class="font-bold text-lg block text-gray-800">{{ $product->name }}</span>
                                    <span class="text-xs text-gray-500 truncate max-w-xs block">{{ $product->description ?? '-' }}</span>
                                </td>
                                <td class="py-3 px-6 text-center font-bold text-red-600">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <span class="bg-blue-100 text-blue-800 py-1 px-3 rounded-full text-xs font-bold">
                                        {{ $product->stock }} Pcs
                                    </span>
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <div class="flex item-center justify-center gap-2">
                                        {{-- Tombol Edit --}}
                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="w-8 h-8 rounded-full bg-yellow-100 text-yellow-600 hover:bg-yellow-200 flex items-center justify-center" title="Edit Produk">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        {{-- Tombol Hapus --}}
                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="w-8 h-8 rounded-full bg-red-100 text-red-600 hover:bg-red-200 flex items-center justify-center" title="Hapus Produk">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-10 text-gray-400">
                                    Belum ada produk. Silakan tambah produk baru.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
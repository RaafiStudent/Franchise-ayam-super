<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kotak Masuk (Saran & Kritik)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Alert Sukses --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if($messages->isEmpty())
                        <div class="text-center py-10 text-gray-500">
                            <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                            <p>Belum ada pesan masuk.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200 text-sm">
                                <thead>
                                    <tr class="bg-gray-100 text-gray-600 uppercase leading-normal">
                                        <th class="py-3 px-6 text-left">Tanggal</th>
                                        <th class="py-3 px-6 text-left">Pengirim</th>
                                        <th class="py-3 px-6 text-left">Pesan</th>
                                        <th class="py-3 px-6 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 font-light">
                                    @foreach($messages as $msg)
                                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                                        {{-- Tanggal --}}
                                        <td class="py-3 px-6 text-left whitespace-nowrap align-top">
                                            <div class="flex flex-col">
                                                <span class="font-bold">{{ $msg->created_at->format('d M Y') }}</span>
                                                <span class="text-xs text-gray-400">{{ $msg->created_at->format('H:i') }} WIB</span>
                                            </div>
                                        </td>

                                        {{-- Pengirim --}}
                                        <td class="py-3 px-6 text-left align-top">
                                            <div class="font-bold text-gray-800">{{ $msg->name }}</div>
                                            <div class="text-xs text-blue-500 mt-1">
                                                <i class="fas fa-address-card mr-1"></i> {{ $msg->contact }}
                                            </div>
                                        </td>

                                        {{-- Isi Pesan --}}
                                        <td class="py-3 px-6 text-left align-top">
                                            <div class="p-3 bg-gray-50 rounded-lg border border-gray-100 italic text-gray-600">
                                                "{{ $msg->message }}"
                                            </div>
                                        </td>

                                        {{-- Aksi --}}
                                        <td class="py-3 px-6 text-center align-middle">
                                            <form action="{{ route('admin.messages.destroy', $msg->id) }}" method="POST" onsubmit="return confirm('Hapus pesan ini?');"></form>
                                                @csrf
                                                @method('DELETE')
                                                <button class="w-8 h-8 rounded-full bg-red-100 text-red-600 hover:bg-red-200 flex items-center justify-center transition" title="Hapus Pesan">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        <div class="mt-4">
                            {{ $messages->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
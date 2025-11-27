<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard - Kelola Mitra') }}
        </h2>
    </x-slot>

    {{-- Script ringan untuk FontAwesome (Icon) --}}
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    </head>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Notifikasi Sukses / Error --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    <strong class="font-bold">Berhasil!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    <strong class="font-bold">Perhatian!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Daftar Permintaan & Status Mitra</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead>
                                <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">Nama Mitra</th>
                                    <th class="py-3 px-6 text-left">Lokasi</th>
                                    <th class="py-3 px-6 text-center">KTP</th>
                                    <th class="py-3 px-6 text-center">Status</th>
                                    <th class="py-3 px-6 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                @foreach($mitras as $mitra)
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    {{-- Kolom 1: Nama & Kontak --}}
                                    <td class="py-3 px-6 text-left whitespace-nowrap">
                                        <div class="flex items-center">
                                            <span class="font-medium text-gray-800">{{ $mitra->name }}</span>
                                        </div>
                                        <div class="text-xs text-gray-500">{{ $mitra->email }}</div>
                                        <div class="text-xs text-gray-500">{{ $mitra->no_hp }}</div>
                                    </td>

                                    {{-- Kolom 2: Lokasi --}}
                                    <td class="py-3 px-6 text-left">
                                        <span class="font-semibold block uppercase">{{ $mitra->kota }}, {{ $mitra->provinsi }}</span>
                                        <div class="text-xs text-gray-400 max-w-[200px] truncate" title="{{ $mitra->alamat_lengkap }}">
                                            {{ $mitra->alamat_lengkap }}
                                        </div>
                                    </td>

                                    {{-- Kolom 3: Foto KTP --}}
                                    <td class="py-3 px-6 text-center">
                                        @if($mitra->ktp_image)
                                            <a href="{{ asset('storage/'.$mitra->ktp_image) }}" target="_blank" class="text-blue-500 underline hover:text-blue-700 font-bold text-xs">
                                                Lihat Foto
                                            </a>
                                        @else
                                            <span class="text-red-400 text-xs italic">Belum Upload</span>
                                        @endif
                                    </td>

                                    {{-- Kolom 4: Badge Status --}}
                                    <td class="py-3 px-6 text-center">
                                        @if($mitra->status == 'pending')
                                            <span class="bg-yellow-200 text-yellow-700 py-1 px-3 rounded-full text-xs font-bold shadow-sm">Pending</span>
                                        @elseif($mitra->status == 'active')
                                            <span class="bg-green-200 text-green-700 py-1 px-3 rounded-full text-xs font-bold shadow-sm">Active</span>
                                        @else
                                            <span class="bg-red-200 text-red-700 py-1 px-3 rounded-full text-xs font-bold shadow-sm">Banned</span>
                                        @endif
                                    </td>

                                    {{-- Kolom 5: Tombol Aksi (Dengan Popup Konfirmasi) --}}
                                    <td class="py-3 px-6 text-center">
                                        <div class="flex item-center justify-center gap-2">
                                            
                                            {{-- TOMBOL APPROVE / UN-BAN --}}
                                            {{-- Muncul jika statusnya PENDING atau BANNED --}}
                                            @if($mitra->status == 'pending' || $mitra->status == 'banned')
                                                <form action="{{ route('admin.mitra.approve', $mitra->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin MENGAKTIFKAN / MEMULIHKAN akun ini? Mitra akan bisa login kembali.');">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="w-8 h-8 rounded-full bg-green-100 text-green-600 hover:bg-green-200 hover:scale-110 transition transform flex items-center justify-center shadow" title="Terima / Pulihkan">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            {{-- TOMBOL REJECT / BLOKIR --}}
                                            {{-- Muncul jika statusnya PENDING atau ACTIVE --}}
                                            @if($mitra->status == 'pending' || $mitra->status == 'active')
                                                <form action="{{ route('admin.mitra.reject', $mitra->id) }}" method="POST" onsubmit="return confirm('PERINGATAN: Akun ini akan DIBEKUKAN. Mitra tidak akan bisa login dashboard. Yakin ingin melanjutkan?');">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="w-8 h-8 rounded-full bg-red-100 text-red-600 hover:bg-red-200 hover:scale-110 transition transform flex items-center justify-center shadow" title="Blokir / Tolak">
                                                        <i class="fas fa-ban"></i>
                                                    </button>
                                                </form>
                                            @endif

                                        </div>
                                    </td>
                                </tr>
                                @endforeach

                                {{-- Jika Data Kosong --}}
                                @if($mitras->isEmpty())
                                    <tr>
                                        <td colspan="5" class="text-center py-6 text-gray-400">
                                            Belum ada data mitra yang mendaftar.
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
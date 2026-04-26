<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <h2 class="font-extrabold text-2xl text-slate-800 leading-tight tracking-tight">
                {{ __('Manajemen User') }}
            </h2>
            {{-- Tombol Tambah User dipindah ke pojok kanan header biar rapi --}}
            <a href="{{ route('admin.users.create') }}" class="bg-gradient-to-r from-red-600 to-red-500 hover:from-red-700 hover:to-red-600 text-white px-5 py-2.5 rounded-xl transition-all shadow-md shadow-red-500/30 font-bold text-sm flex items-center gap-2 active:scale-95 w-fit">
                <i class="fas fa-plus-circle"></i> Tambah User
            </a>
        </div>
    </x-slot>

    <div class="py-8 pb-20">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- ALERT SUCCESS PREMIUM --}}
            @if(session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-xl shadow-sm mb-6 flex items-center gap-3 animate-bounce-in">
                    <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center shrink-0">
                        <i class="fas fa-check text-emerald-600"></i>
                    </div>
                    <span class="font-bold text-sm">{{ session('success') }}</span>
                </div>
            @endif

            {{-- MAIN CONTAINER PREMIUM --}}
            <div class="bg-white rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 overflow-hidden">
                <div class="p-6 md:p-8">

                    {{-- TABEL PREMIUM --}}
                    <div class="overflow-x-auto rounded-2xl border border-slate-100">
                        <table class="min-w-full bg-white text-sm text-left">
                            <thead>
                                <tr class="bg-slate-50/80 text-slate-500 text-[10px] uppercase tracking-widest font-black border-b border-slate-100">
                                    <th class="py-5 px-6 rounded-tl-2xl">Pengguna</th>
                                    <th class="py-5 px-6">Kontak</th>
                                    <th class="py-5 px-6 text-center">Akses Role</th>
                                    <th class="py-5 px-6 text-center">Status</th>
                                    <th class="py-5 px-6 text-center rounded-tr-2xl">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50 font-medium">
                                @forelse($users as $user)
                                <tr class="hover:bg-slate-50/50 transition-colors group">
                                    
                                    {{-- Kolom 1: Nama & Avatar --}}
                                    <td class="py-4 px-6 align-middle">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm shrink-0 border
                                                {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-700 border-purple-200' : 
                                                  ($user->role == 'owner' ? 'bg-amber-100 text-amber-700 border-amber-200' : 
                                                  'bg-blue-100 text-blue-700 border-blue-200') }}">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="font-extrabold text-slate-800 text-sm">{{ $user->name }}</span>
                                                <span class="text-[10px] font-bold text-slate-400">ID: #USR-{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Kolom 2: Email & Lokasi --}}
                                    <td class="py-4 px-6 align-middle">
                                        <div class="flex flex-col gap-1">
                                            <div class="flex items-center gap-2 text-slate-600">
                                                <i class="fas fa-envelope text-slate-400 w-4 text-center text-xs"></i>
                                                <span class="font-semibold text-sm">{{ $user->email }}</span>
                                            </div>
                                            @if($user->kota)
                                            <div class="flex items-center gap-2 text-slate-500">
                                                <i class="fas fa-map-marker-alt text-slate-400 w-4 text-center text-xs"></i>
                                                <span class="text-xs">{{ $user->kota }}</span>
                                            </div>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- Kolom 3: Role Badge --}}
                                    <td class="py-4 px-6 text-center align-middle">
                                        @if($user->role == 'admin')
                                            <span class="inline-flex items-center bg-purple-50 text-purple-600 py-1.5 px-3 rounded-lg text-[10px] font-black uppercase tracking-widest border border-purple-200/60 shadow-sm">
                                                <i class="fas fa-user-shield mr-1.5"></i> Admin
                                            </span>
                                        @elseif($user->role == 'owner')
                                            <span class="inline-flex items-center bg-amber-50 text-amber-600 py-1.5 px-3 rounded-lg text-[10px] font-black uppercase tracking-widest border border-amber-200/60 shadow-sm">
                                                <i class="fas fa-crown mr-1.5"></i> Owner
                                            </span>
                                        @else
                                            <span class="inline-flex items-center bg-blue-50 text-blue-600 py-1.5 px-3 rounded-lg text-[10px] font-black uppercase tracking-widest border border-blue-200/60 shadow-sm">
                                                <i class="fas fa-store mr-1.5"></i> Mitra
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Kolom 4: Status Badge --}}
                                    <td class="py-4 px-6 text-center align-middle">
                                        @if($user->status == 'active')
                                            <span class="bg-emerald-50 text-emerald-600 py-1.5 px-4 rounded-full text-xs font-bold border border-emerald-200/60 shadow-sm">
                                                ACTIVE
                                            </span>
                                        @elseif($user->status == 'pending')
                                            <span class="bg-slate-100 text-slate-500 py-1.5 px-4 rounded-full text-xs font-bold border border-slate-200 shadow-sm">
                                                PENDING
                                            </span>
                                        @else
                                            <span class="bg-red-50 text-red-600 py-1.5 px-4 rounded-full text-xs font-bold border border-red-200/60 shadow-sm">
                                                BANNED
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Kolom 5: Action Buttons --}}
                                    <td class="py-4 px-6 align-middle">
                                        <div class="flex items-center justify-center gap-2">
                                            {{-- Edit Button --}}
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center transition-colors shadow-sm" title="Edit User">
                                                <i class="fas fa-edit text-sm"></i>
                                            </a>
                                            
                                            {{-- Delete Button with Modal Confirmation --}}
                                            @if(Auth::id() !== $user->id) {{-- Cegah admin hapus dirinya sendiri --}}
                                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini secara permanen?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white flex items-center justify-center transition-colors shadow-sm" title="Hapus User">
                                                        <i class="fas fa-trash-alt text-sm"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-16">
                                        <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <i class="fas fa-users-slash text-4xl text-slate-300"></i>
                                        </div>
                                        <h3 class="text-lg font-bold text-slate-700 mb-1">Belum Ada Pengguna</h3>
                                        <p class="text-sm text-slate-400">Silakan tambahkan user baru ke dalam sistem.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- === PAGINATION LINKS === --}}
                    @if(method_exists($users, 'links'))
                    <div class="mt-6">
                        {{ $users->links() }}
                    </div>
                    @endif
                    {{-- =========================================== --}}

                </div>
            </div>
        </div>
    </div>
    
    {{-- CSS Khusus untuk animasi halus --}}
    <style>
        .animate-bounce-in { animation: bounceIn 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards; }
        @keyframes bounceIn {
            0% { transform: scale(0.9); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
    </style>
</x-app-layout>
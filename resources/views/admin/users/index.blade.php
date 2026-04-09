<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-red-800 leading-tight">{{ __('Manajemen User') }}</h2>
            <a href="{{ route('admin.users.create') }}" class="bg-red-700 hover:bg-red-800 text-white px-4 py-2 rounded-lg text-sm transition">
                <i class="fas fa-plus mr-2"></i> Tambah User
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 uppercase text-xs">
                            <th class="p-4 border">Nama</th>
                            <th class="p-4 border">Email</th>
                            <th class="p-4 border">Role</th>
                            <th class="p-4 border">Status</th>
                            <th class="p-4 border text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="p-4 border font-medium">{{ $user->name }}</td>
                            <td class="p-4 border text-gray-600">{{ $user->email }}</td>
                            <td class="p-4 border text-center">
                                <span class="px-2 py-1 rounded text-[10px] font-bold uppercase 
                                    {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-700' : ($user->role == 'owner' ? 'bg-yellow-100 text-yellow-700' : 'bg-blue-100 text-blue-700') }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="p-4 border text-center">
                                <span class="px-2 py-1 rounded text-[10px] font-bold uppercase {{ $user->status == 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $user->status }}
                                </span>
                            </td>
                            <td class="p-4 border text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-600 hover:text-blue-800"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin hapus user ini?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">{{ $users->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
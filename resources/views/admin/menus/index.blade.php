<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-extrabold text-2xl text-slate-800 leading-tight">
                {{ __('Manajemen Katalog Menu') }}
            </h2>
            <a href="{{ route('admin.menus.create') }}" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2.5 rounded-xl font-bold text-sm shadow-lg shadow-red-200 transition-all active:scale-95">
                <i class="fas fa-plus mr-2"></i> Tambah Menu Baru
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($menus as $menu)
                <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden group hover:shadow-md transition-all">
                    <div class="h-48 overflow-hidden relative">
                        <img src="{{ asset('storage/' . $menu->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @if($menu->badge)
                        <span class="absolute top-4 right-4 bg-red-600 text-white text-[10px] font-black px-3 py-1 rounded-full shadow-sm">
                            {{ $menu->badge }}
                        </span>
                        @endif
                    </div>
                    <div class="p-6">
                        <h3 class="font-black text-slate-800 text-lg mb-2">{{ $menu->name }}</h3>
                        <p class="text-xs text-slate-400 leading-relaxed mb-6 line-clamp-2 italic">"{{ $menu->description }}"</p>
                        
                        <div class="flex items-center justify-between pt-4 border-t border-slate-50">
                            <div class="flex gap-4">
                                <span class="text-[10px] font-bold text-emerald-500"><i class="fas fa-thumbs-up mr-1"></i> {{ $menu->loves }}</span>
                                <span class="text-[10px] font-bold text-slate-300"><i class="fas fa-thumbs-down mr-1"></i> {{ $menu->hates }}</span>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('admin.menus.edit', $menu->id) }}" class="text-blue-500 hover:bg-blue-50 p-2 rounded-lg transition-colors"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.menus.destroy', $menu->id) }}" method="POST" onsubmit="return confirm('Hapus menu ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:bg-red-50 p-2 rounded-lg transition-colors"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-8">{{ $menus->links() }}</div>
        </div>
    </div>
</x-app-layout>
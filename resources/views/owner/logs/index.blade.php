<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-red-800 leading-tight">
            {{ __('Audit Log - Aktivitas Sistem') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <h3 class="text-lg font-bold text-gray-700 mb-4 border-b pb-2">Riwayat Tindakan Admin</h3>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-xs uppercase text-gray-600">
                                <th class="p-4 border">Waktu</th>
                                <th class="p-4 border">Pelaku (Admin)</th>
                                <th class="p-4 border">Tindakan</th>
                                <th class="p-4 border">Target Akun</th>
                                <th class="p-4 border">Keterangan Detail</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-200">
                            @forelse($logs as $log)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 text-gray-500 whitespace-nowrap">
                                    {{ $log->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="p-4 font-bold text-gray-800">
                                    {{ $log->user->name ?? 'Admin Terhapus' }}
                                </td>
                                <td class="p-4">
                                    <span class="px-2 py-1 rounded text-[10px] font-bold text-white uppercase
                                        {{ str_contains($log->action, 'CREATE') ? 'bg-green-500' : (str_contains($log->action, 'DELETE') ? 'bg-red-600' : 'bg-blue-600') }}">
                                        {{ str_replace('_', ' ', $log->action) }}
                                    </span>
                                </td>
                                <td class="p-4 font-medium text-gray-700">
                                    {{ $log->target_user }}
                                </td>
                                <td class="p-4 text-gray-600 italic">
                                    {{ $log->description }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-6 text-center text-gray-500 italic">
                                    Belum ada catatan aktivitas log di dalam sistem.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $logs->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-red-800 leading-tight">Audit Log - Aktivitas Sistem</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-xs uppercase text-gray-600">
                            <th class="p-4 border">Waktu</th>
                            <th class="p-4 border">Pelaku (Admin)</th>
                            <th class="p-4 border">Tindakan</th>
                            <th class="p-4 border">Target</th>
                            <th class="p-4 border">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @foreach($logs as $log)
                        <tr>
                            <td class="p-4 border text-gray-500">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                            <td class="p-4 border font-bold">{{ $log->user->name }}</td>
                            <td class="p-4 border">
                                <span class="px-2 py-1 rounded text-[10px] font-bold text-white 
                                    {{ str_contains($log->action, 'CREATE') ? 'bg-green-500' : (str_contains($log->action, 'DELETE') ? 'bg-red-600' : 'bg-blue-600') }}">
                                    {{ $log->action }}
                                </span>
                            </td>
                            <td class="p-4 border">{{ $log->target_user }}</td>
                            <td class="p-4 border text-gray-600 italic">{{ $log->description }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
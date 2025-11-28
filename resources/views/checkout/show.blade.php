<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pembayaran Invoice: ') }} {{ $order->invoice_number }}
        </h2>
    </x-slot>

    {{-- SCRIPT PENTING MIDTRANS --}}
    <head>
        <script type="text/javascript"
            src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('midtrans.client_key') }}"></script>
    </head>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl p-8 text-center">
                
                <div class="mb-8">
                    <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-file-invoice-dollar text-3xl text-red-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800">Konfirmasi Pembayaran</h3>
                    <p class="text-gray-500">Mohon selesaikan pembayaran Anda.</p>
                </div>

                {{-- Rincian Singkat --}}
                <div class="bg-gray-50 rounded-xl p-6 mb-8 border border-gray-100 text-left">
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Total Item</span>
                        <span class="font-bold">{{ $order->items->sum('quantity') }} pcs</span>
                    </div>
                    <div class="flex justify-between border-t pt-4 mt-2">
                        <span class="text-gray-800 font-bold text-lg">Total Tagihan</span>
                        <span class="text-red-600 font-extrabold text-2xl">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>

                {{-- Tombol Bayar --}}
                <button id="pay-button" class="w-full bg-blue-600 text-white font-bold py-4 rounded-xl shadow-lg hover:bg-blue-700 transition transform hover:scale-105 mb-4">
                    PILIH METODE PEMBAYARAN
                </button>
                
                <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-gray-600 text-sm">Kembali ke Dashboard</a>

            </div>
        </div>
    </div>

    {{-- SCRIPT JAVASCRIPT POPUP --}}
    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            // Memicu Popup Snap Midtrans
            window.snap.pay('{{ $order->snap_token }}', {
                onSuccess: function(result){
                    alert("Pembayaran Berhasil!");
                    window.location.href = "{{ route('dashboard') }}";
                },
                onPending: function(result){
                    alert("Menunggu Pembayaran!");
                    window.location.href = "{{ route('dashboard') }}";
                },
                onError: function(result){
                    alert("Pembayaran Gagal!");
                },
                onClose: function(){
                    alert('Anda menutup popup tanpa menyelesaikan pembayaran');
                }
            });
        });
    </script>
</x-app-layout>
<!DOCTYPE html>
<html>
<head>
    <title>Invoice #ORDER-{{ $order->id }}</title>
    <style>
        body { font-family: sans-serif; font-size: 10pt; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #ddd; padding-bottom: 10px; }
        .header h1 { margin: 0; color: #d32f2f; }
        .header p { margin: 2px 0; font-size: 9pt; }
        
        .meta-info { width: 100%; margin-bottom: 20px; }
        .meta-info td { vertical-align: top; }
        .meta-title { font-weight: bold; color: #555; }

        table.items { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.items th { background-color: #f3f3f3; border: 1px solid #ddd; padding: 8px; text-align: left; }
        table.items td { border: 1px solid #ddd; padding: 8px; }
        
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        
        .status-paid { color: green; border: 1px solid green; padding: 5px 10px; display: inline-block; font-weight: bold; }
        .status-unpaid { color: red; border: 1px solid red; padding: 5px 10px; display: inline-block; font-weight: bold; }
        
        .footer { margin-top: 30px; text-align: center; font-size: 8pt; color: #777; border-top: 1px solid #eee; padding-top: 10px; }
    </style>
</head>
<body>

    <div class="header">
        <h1>AYAM SUPER FRIED CHICKEN</h1>
        <p>Jl. Puter Gg. Bango No 20A, Randugunting, Tegal Selatan, Kota Tegal</p>
        <p>Email: admin@ayamsuper.com | WA: +62 812 3456 7890</p>
    </div>

    <table class="meta-info">
        <tr>
            <td width="60%">
                <span class="meta-title">DITAGIHKAN KEPADA:</span><br>
                <strong>{{ $order->user->name }}</strong><br>
                {{ $order->user->alamat_lengkap }}<br>
                {{ $order->user->kota }}, {{ $order->user->provinsi }}<br>
                HP: {{ $order->user->no_hp }}
            </td>
            <td width="40%" class="text-right">
                <span class="meta-title">FAKTUR PENJUALAN</span><br>
                <h3>#ORDER-{{ $order->id }}</h3>
                Tanggal: {{ $order->created_at->format('d M Y, H:i') }} WIB<br>
                <br>
                
                {{-- STATUS PEMBAYARAN --}}
                @if($order->payment_status == 'paid')
                    <span class="status-paid">LUNAS</span>
                @else
                    <span class="status-unpaid">BELUM LUNAS</span>
                @endif
                <br><br>

                {{-- STATUS PESANAN (BARU) --}}
                <strong>STATUS BARANG:</strong><br>
                @if($order->order_status == 'completed')
                    <span style="color: green; font-weight: bold; font-size: 12pt;">SELESAI (DITERIMA)</span>
                @elseif($order->order_status == 'shipped')
                    <span style="color: blue; font-weight: bold;">SEDANG DIKIRIM</span>
                @elseif($order->order_status == 'processing')
                    <span style="color: orange; font-weight: bold;">SEDANG DIKEMAS</span>
                @else
                    <span style="color: gray;">MENUNGGU</span>
                @endif
            </td>
        </tr>
    </table>

    <table class="items">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="50%">Nama Produk</th>
                <th width="15%" class="text-center">Qty</th>
                <th width="15%" class="text-right">Harga</th>
                <th width="15%" class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->product->name }}</td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="4" class="text-right font-bold">TOTAL TAGIHAN</td>
                <td class="text-right" style="font-size: 12pt; color: #d32f2f; font-weight: bold;">
                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                </td>
            </tr>
        </tfoot>
    </table>

    @if($order->order_status == 'shipped' || $order->order_status == 'completed')
    <div style="margin-top: 20px; border: 1px dashed #ccc; padding: 10px; background-color: #f9f9f9;">
        <strong>Info Pengiriman:</strong><br>
        Ekspedisi: {{ $order->courier_name }} <br>
        No. Resi: {{ $order->resi_number }}
    </div>
    @endif

    <div class="footer">
        <p>Terima kasih telah berbelanja di Ayam Super Fried Chicken.</p>
        <p>Bukti ini sah dan diproses oleh komputer.</p>
    </div>

</body>
</html>
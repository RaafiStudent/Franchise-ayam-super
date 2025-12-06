<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice #{{ $order->id }}</title>
    <style>
        /* 1. RESET & FONT UTAMA */
        body {
            font-family: 'Helvetica', 'Arial', sans-serif; /* Font Modern */
            color: #333;
            line-height: 1.6;
            font-size: 10pt;
            margin: 0;
            padding: 0;
        }

        /* 2. HEADER LOGO & JUDUL */
        .header-table {
            width: 100%;
            border-bottom: 2px solid #d32f2f; /* Garis Merah Ayam Super */
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .logo-img {
            max-width: 120px; /* Ukuran Logo */
            height: auto;
        }
        .company-info {
            text-align: right;
        }
        .company-name {
            font-size: 16pt;
            font-weight: bold;
            color: #d32f2f; /* Merah */
            text-transform: uppercase;
            margin: 0;
        }
        .company-address {
            font-size: 9pt;
            color: #555;
            margin: 0;
        }

        /* 3. INFO CUSTOMER & INVOICE */
        .meta-table {
            width: 100%;
            margin-bottom: 30px;
        }
        .bill-to-title {
            font-size: 8pt;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }
        .bill-to-name {
            font-size: 12pt;
            font-weight: bold;
            color: #333;
        }
        .invoice-details {
            text-align: right;
        }
        .invoice-title {
            font-size: 18pt;
            font-weight: bold;
            color: #333;
            letter-spacing: 2px;
        }
        .invoice-number {
            font-size: 12pt;
            color: #d32f2f;
            font-weight: bold;
        }

        /* 4. TABEL BARANG (STRIPED) */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .items-table th {
            background-color: #d32f2f; /* Header Merah */
            color: white;
            padding: 10px;
            text-align: left;
            font-size: 9pt;
            text-transform: uppercase;
        }
        .items-table td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        /* Zebra Striping (Baris Genap Abu-abu tipis) */
        .items-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }

        /* 5. TOTAL & STATUS */
        .total-section {
            width: 100%;
            margin-top: 10px;
        }
        .total-table {
            width: 40%;
            float: right;
            border-collapse: collapse;
        }
        .total-table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        .grand-total {
            background-color: #d32f2f;
            color: white;
            font-weight: bold;
            font-size: 12pt;
        }

        /* 6. STATUS STAMPS */
        .status-box {
            border: 2px solid;
            padding: 5px 15px;
            font-weight: bold;
            font-size: 10pt;
            text-transform: uppercase;
            display: inline-block;
            transform: rotate(-10deg); /* Miring dikit biar kayak stempel */
            margin-top: 20px;
        }
        .paid-stamp { border-color: green; color: green; }
        .unpaid-stamp { border-color: red; color: red; }

        /* 7. FOOTER */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 40px;
            text-align: center;
            font-size: 8pt;
            color: #aaa;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    {{-- HEADER: LOGO & ALAMAT --}}
    <table class="header-table">
        <tr>
            <td width="30%">
                {{-- Pastikan file public/images/logo.png ada. Gunakan public_path() --}}
                <img src="{{ public_path('images/logo.png') }}" class="logo-img" alt="Logo">
            </td>
            <td width="70%" class="company-info">
                <h1 class="company-name">Ayam Super Fried Chicken</h1>
                <p class="company-address">
                    Jl. Puter Gg. Bango No 20A, Tegal Selatan, Kota Tegal<br>
                    WA: +62 812-3456-7890 | Email: admin@ayamsuper.com
                </p>
            </td>
        </tr>
    </table>

    {{-- INFO CUSTOMER & INVOICE --}}
    <table class="meta-table">
        <tr>
            <td width="50%">
                <div class="bill-to-title">DITAGIHKAN KEPADA:</div>
                <div class="bill-to-name">{{ $order->user->name }}</div>
                <div>{{ $order->user->alamat_lengkap }}</div>
                <div>{{ $order->user->kota }}, {{ $order->user->provinsi }}</div>
                <div>HP: {{ $order->user->no_hp }}</div>
            </td>
            <td width="50%" class="invoice-details">
                <div class="invoice-title">INVOICE</div>
                <div class="invoice-number">#ORDER-{{ $order->id }}</div>
                <br>
                <div><strong>Tanggal Order:</strong> {{ $order->created_at->format('d M Y') }}</div>
                <div>
                    @if($order->payment_status == 'paid')
                        <div class="status-box paid-stamp">LUNAS</div>
                    @else
                        <div class="status-box unpaid-stamp">BELUM LUNAS</div>
                    @endif
                </div>
            </td>
        </tr>
    </table>

    {{-- TABEL BARANG --}}
    <table class="items-table">
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="50%">Deskripsi Item</th>
                <th width="10%" class="text-center">Qty</th>
                <th width="15%" class="text-right">Harga</th>
                <th width="20%" class="text-right">Total</th>
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
    </table>

    {{-- TOTAL HARGA --}}
    <div class="total-section">
        <table class="total-table">
            <tr>
                <td><strong>Subtotal</strong></td>
                <td class="text-right">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="grand-total">TOTAL TAGIHAN</td>
                <td class="grand-total text-right">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
            </tr>
        </table>
        <div style="clear: both;"></div>
    </div>

    {{-- INFO PENGIRIMAN (JIKA ADA) --}}
    @if($order->order_status == 'shipped' || $order->order_status == 'completed')
    <div style="margin-top: 30px; background: #f0f8ff; padding: 15px; border: 1px solid #b0c4de; border-radius: 5px;">
        <strong>🚚 Informasi Pengiriman:</strong><br>
        <span style="font-size: 11pt;">
            Kurir: <strong>{{ $order->courier_name }}</strong> &nbsp;|&nbsp; 
            No. Resi: <strong>{{ $order->resi_number }}</strong>
        </span>
        @if($order->order_status == 'completed')
            <br><span style="color: green; font-weight: bold;">(BARANG SUDAH DITERIMA)</span>
        @endif
    </div>
    @endif

    {{-- FOOTER --}}
    <div class="footer">
        Terima kasih atas kepercayaan Anda bermitra dengan Ayam Super Fried Chicken.<br>
        Bukti ini sah dan digenerate otomatis oleh sistem komputer.
    </div>

</body>
</html>
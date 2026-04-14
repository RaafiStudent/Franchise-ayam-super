<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice #{{ $order->id }}</title>
    <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #ORDER-{{ $order->id }}</title>
    <style>
        /* 1. RESET & FONT */
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #1e293b;
            line-height: 1.5;
            font-size: 10pt;
            margin: 0;
            padding: 40px;
        }

        /* 2. AKSEN WARNA */
        .text-red { color: #a51a1a; }
        .bg-red { background-color: #a51a1a !important; }
        .text-slate { color: #64748b; }

        /* 3. HEADER */
        .header-table {
            width: 100%;
            margin-bottom: 40px;
        }
        .company-name {
            font-size: 18pt;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: -1px;
            margin: 0;
        }
        .company-info {
            font-size: 8pt;
            color: #64748b;
            margin-top: 5px;
        }

        /* 4. INFO SECTION */
        .info-table {
            width: 100%;
            margin-bottom: 40px;
        }
        .section-title {
            font-size: 8pt;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #94a3b8;
            margin-bottom: 8px;
        }
        .info-content {
            font-size: 10pt;
            font-weight: 700;
            color: #1e293b;
        }

        /* 5. TABLE BARANG */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .items-table th {
            padding: 12px 15px;
            text-align: left;
            font-size: 8pt;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 2px solid #e2e8f0;
            color: #64748b;
        }
        .items-table td {
            padding: 15px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }
        .item-name {
            font-weight: 700;
            color: #1e293b;
            display: block;
        }
        .item-qty {
            font-size: 9pt;
            color: #64748b;
        }

        /* 6. SUMMARY SECTION */
        .summary-table {
            width: 35%;
            margin-left: auto;
            border-collapse: collapse;
        }
        .summary-table td {
            padding: 8px 0;
        }
        .total-row td {
            border-top: 2px solid #f1f5f9;
            padding-top: 15px;
        }
        .grand-total {
            font-size: 14pt;
            font-weight: 900;
            color: #a51a1a;
        }

        /* 7. STATUS BADGE */
        .badge {
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 8pt;
            font-weight: 900;
            text-transform: uppercase;
            display: inline-block;
        }
        .badge-paid { background-color: #ecfdf5; color: #059669; }
        .badge-unpaid { background-color: #fef2f2; color: #dc2626; }

        /* 8. FOOTER */
        .footer {
            position: fixed;
            bottom: 30px;
            left: 40px;
            right: 40px;
            text-align: center;
            font-size: 8pt;
            color: #94a3b8;
            border-top: 1px solid #f1f5f9;
            padding-top: 20px;
        }

        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body>

    {{-- HEADER --}}
    <table class="header-table">
        <tr>
            <td width="50%">
                {{-- Gunakan base64 untuk logo agar lebih aman di DomPDF --}}
                <h1 class="company-name text-red">Ayam<span style="color: #1e293b">Super.</span></h1>
                <div class="company-info">
                    Sistem Manajemen Rantai Pasok (SCM)<br>
                    Kota Tegal, Jawa Tengah, Indonesia
                </div>
            </td>
            <td width="50%" class="text-right">
                <div style="font-size: 24pt; font-weight: 900; color: #e2e8f0; margin-bottom: -10px;">INVOICE</div>
                <div class="info-content text-red" style="font-size: 12pt;">#ORDER-{{ $order->id }}</div>
            </td>
        </tr>
    </table>

    {{-- INFO CUSTOMER --}}
    <table class="info-table">
        <tr>
            <td width="33%">
                <div class="section-title">Tagihan Untuk</div>
                <div class="info-content">{{ $order->user->name }}</div>
                <div class="company-info">
                    {{ $order->user->no_hp }}<br>
                    Cabang Mitra Ayam Super
                </div>
            </td>
            <td width="33%">
                <div class="section-title">Tanggal Terbit</div>
                <div class="info-content">{{ $order->created_at->translatedFormat('d F Y') }}</div>
                <div class="company-info">Waktu: {{ $order->created_at->format('H:i') }} WIB</div>
            </td>
            <td width="33%" class="text-right">
                <div class="section-title">Status Pembayaran</div>
                <div class="badge {{ $order->payment_status == 'paid' ? 'badge-paid' : 'badge-unpaid' }}">
                    {{ $order->payment_status == 'paid' ? 'LUNAS / PAID' : 'BELUM BAYAR / UNPAID' }}
                </div>
            </td>
        </tr>
    </table>

    {{-- TABEL ITEM --}}
    <table class="items-table">
        <thead>
            <tr>
                <th width="45%">Deskripsi Item Produk</th>
                <th width="15%" class="text-center">Jumlah</th>
                <th width="20%" class="text-right">Harga Satuan</th>
                <th width="20%" class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>
                    <span class="item-name">{{ $item->product->name }}</span>
                    <span class="company-info">Bahan Baku Berkualitas</span>
                </td>
                <td class="text-center font-bold text-slate">{{ $item->quantity }}</td>
                <td class="text-right text-slate">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                <td class="text-right info-content">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- SUMMARY --}}
    <table class="summary-table">
        <tr>
            <td class="text-slate font-bold">Subtotal</td>
            <td class="text-right info-content">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="text-slate font-bold">Biaya Layanan</td>
            <td class="text-right text-emerald-600 font-bold">GRATIS</td>
        </tr>
        <tr class="total-row">
            <td class="text-red font-black" style="font-weight: 900;">TOTAL AKHIR</td>
            <td class="text-right grand-total">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
        </tr>
    </table>

    {{-- PENGIRIMAN (OPTIONAL) --}}
    @if($order->resi_number)
    <div style="margin-top: 50px; padding: 20px; background-color: #f8fafc; border-radius: 15px; border: 1px solid #e2e8f0;">
        <div class="section-title" style="color: #1e293b;"><i class="fas fa-truck"></i> Informasi Logistik</div>
        <table width="100%">
            <tr>
                <td width="50%">
                    <div style="font-size: 8pt; color: #64748b;">Kurir Pengirim</div>
                    <div class="info-content">{{ $order->courier_name ?? 'Internal Delivery' }}</div>
                </td>
                <td width="50%" class="text-right">
                    <div style="font-size: 8pt; color: #64748b;">Nomor Resi</div>
                    <div class="info-content text-red">{{ $order->resi_number }}</div>
                </td>
            </tr>
        </table>
    </div>
    @endif

    <div class="footer">
        <strong>Ayam Super Fried Chicken</strong> &bull; Tegal, Jawa Tengah<br>
        Dokumen ini sah dan diterbitkan secara digital. Terima kasih telah menjadi mitra setia kami.
    </div>

</body>
</html>
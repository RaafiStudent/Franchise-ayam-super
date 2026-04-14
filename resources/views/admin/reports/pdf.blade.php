<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Analisis Bisnis - {{ ucfirst($filter) }}</title>
    <style>
        /* 1. RESET & FONT */
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #1e293b;
            line-height: 1.5;
            font-size: 9pt;
            margin: 0;
            padding: 30px;
        }

        /* 2. ELEMEN GRAFIS BACKGROUND */
        .wave-top-left {
            position: fixed; top: -50px; left: -50px;
            width: 150px; height: 150px;
            background-color: #fef2f2; border-radius: 50%; z-index: -10;
        }

        .text-red { color: #a51a1a; }
        .text-slate { color: #64748b; }

        /* 3. HEADER */
        .header-table { width: 100%; margin-bottom: 30px; border-bottom: 2px solid #f1f5f9; padding-bottom: 20px; }
        .report-title { font-size: 18pt; font-weight: 800; text-transform: uppercase; margin: 0; }
        .company-info { font-size: 8pt; color: #64748b; }

        /* 4. SUMMARY CARDS (KOTAK RINGKASAN) */
        .summary-table { width: 100%; margin-bottom: 30px; }
        .card { background-color: #f8fafc; padding: 15px; border-radius: 10px; border: 1px solid #e2e8f0; }
        .card-label { font-size: 7pt; font-weight: 800; color: #94a3b8; text-transform: uppercase; }
        .card-value { font-size: 12pt; font-weight: 800; color: #1e293b; }

        /* 5. TABEL DATA */
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .items-table th {
            padding: 10px; background-color: #f8fafc; text-align: left;
            font-size: 7pt; font-weight: 800; text-transform: uppercase;
            color: #64748b; border-bottom: 2px solid #e2e8f0;
        }
        .items-table td { padding: 10px; border-bottom: 1px solid #f1f5f9; }

        .footer {
            position: fixed; bottom: 30px; left: 30px; right: 30px;
            text-align: center; font-size: 7pt; color: #94a3b8;
            border-top: 1px solid #f1f5f9; padding-top: 15px;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
    </style>
</head>
<body>

    <div class="wave-top-left"></div>

    {{-- HEADER --}}
    <table class="header-table">
        <tr>
            <td>
                <div class="report-title">Laporan <span class="text-red">Analisis Bisnis</span></div>
                <div class="company-info">Ayam Super Fried Chicken SCM &bull; Periode: <strong>{{ strtoupper($filter) }}</strong></div>
            </td>
            <td class="text-right">
                <div style="font-size: 8pt; color: #94a3b8;">Dicetak Pada:</div>
                <div class="font-bold">{{ date('d F Y, H:i') }} WIB</div>
            </td>
        </tr>
    </table>

    {{-- RINGKASAN PERFORMA --}}
    <table class="summary-table" cellspacing="10">
        <tr>
            <td width="50%">
                <div class="card" style="border-left: 4px solid #10b981;">
                    <div class="card-label">Total Omset Pendapatan</div>
                    <div class="card-value text-red">Rp {{ number_format($totalOmset, 0, ',', '.') }}</div>
                </div>
            </td>
            <td width="50%">
                <div class="card" style="border-left: 4px solid #f59e0b;">
                    <div class="card-label">Total Transaksi Berhasil</div>
                    <div class="card-value">{{ $totalTransaksi }} Pesanan</div>
                </div>
            </td>
        </tr>
    </table>

    {{-- TABEL TRANSAKSI --}}
    <div style="font-size: 8pt; font-weight: 800; color: #94a3b8; margin-bottom: 10px; text-transform: uppercase;">
        Daftar Riwayat Transaksi Riil
    </div>
    <table class="items-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="35%">Nama Mitra</th>
                <th width="25%">Tanggal & Waktu</th>
                <th width="15%">Status</th>
                <th width="20%" class="text-right">Total Belanja</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $index => $item)
            <tr>
                <td class="text-center text-slate">{{ $index + 1 }}</td>
                <td>
                    <div class="font-bold">{{ $item->user->name }}</div>
                    <div style="font-size: 7pt; color: #94a3b8;">ID: #ORDER-{{ $item->id }}</div>
                </td>
                <td class="text-slate">{{ $item->created_at->translatedFormat('d M Y, H:i') }}</td>
                <td>
                    <span style="font-weight: bold; color: {{ $item->payment_status == 'paid' ? '#059669' : '#dc2626' }}; font-size: 7pt;">
                        {{ strtoupper($item->payment_status) }}
                    </span>
                </td>
                <td class="text-right font-bold">Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <strong>Ayam Super Fried Chicken SCM System</strong><br>
        Laporan ini digenerate secara otomatis oleh sistem. Segala bentuk manipulasi data di luar sistem bukan tanggung jawab pengembang.
    </div>

</body>
</html>
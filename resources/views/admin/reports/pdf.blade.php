<!DOCTYPE html>
<html>
<head>
    <title>Laporan Keuangan</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background-color: #ddd; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">{{ $title }}</h2>
    <p>Dicetak Tanggal: {{ date('d-m-Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Mitra</th>
                <th>Total Belanja</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $index => $o)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $o->created_at->format('d/m/Y') }}</td>
                <td>{{ $o->user->name }}</td>
                <td>Rp {{ number_format($o->total_price, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" style="text-align: right; font-weight: bold;">TOTAL OMSET</td>
                <td style="font-weight: bold;">Rp {{ number_format($totalOmset, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
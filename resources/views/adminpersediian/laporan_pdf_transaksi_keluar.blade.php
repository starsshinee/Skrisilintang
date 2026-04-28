<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi Keluar</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 30px; }
        .stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px; }
        .stat-box { border: 2px solid #EF4444; padding: 15px; border-radius: 8px; text-align: center; }
        .stat-value { font-size: 24px; font-weight: bold; color: #EF4444; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #FEF2F2; color: #EF4444; font-weight: bold; }
        .total-row { font-weight: bold; background: #FEF2F2; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN TRANSAKSI KELUAR PERSEDIAAN</h1>
        <p>Periode: {{ $stats['periode'] }} | {{ now()->translatedFormat('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No. Transaksi</th>
                <th>Tanggal</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Jumlah Keluar</th>
                <th>Harga Satuan</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi as $item)
            <tr>
                <td>{{ $item->nomor_transaksi }}</td>
                <td>{{ $item->tanggal_input->format('d/m/Y') }}</td>
                <td>{{ $item->kode_barang }}</td>
                <td>{{ $item->nama_barang }}</td>
                <td style="text-align:right;">{{ number_format($item->jumlah_keluar) }}</td>
                <td style="text-align:right;">Rp {{ number_format($item->harga) }}</td>
                <td style="text-align:right;">Rp {{ number_format($item->total) }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="6" style="text-align:right; font-weight:bold;">TOTAL :</td>
                <td style="text-align:right; font-size:14px;">Rp {{ number_format($stats['total_nilai']) }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
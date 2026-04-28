<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Transaksi Masuk Persediaan</title>
    <style>
        * {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            padding: 0;
        }
        body { font-size: 12px; }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .header h1 {
            font-size: 18px;
            margin-bottom: 5px;
            color: #333;
        }
        .header p {
            font-size: 12px;
            color: #666;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table th {
            background: #f8f9fa;
            font-weight: bold;
            text-align: center;
            padding: 12px 8px;
            border: 1px solid #ddd;
            font-size: 11px;
        }
        .table td {
            padding: 10px 8px;
            border: 1px solid #ddd;
            font-size: 11px;
            vertical-align: middle;
        }
        .table tr:nth-child(even) { background: #f9f9f9; }
        .table tr:hover { background: #f0f8ff; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .footer {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            font-size: 11px;
        }
        .total-row {
            background: #e3f2fd !important;
            font-weight: bold;
        }
        @page {
            margin: 20mm;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>LAPORAN TRANSAKSI MASUK PERSEDIAAN</h1>
        <p>Periode: {{ now()->translatedFormat('d F Y') }}</p>
        <p>Dicetak: {{ now()->format('d-m-Y H:i:s') }}</p>
    </div>

    <!-- Tabel -->
    <table class="table">
        <thead>
            <tr>
                <th width="12%">No</th>
                <th width="15%">Kode Transaksi</th>
                <th width="18%">Kode Barang</th>
                <th width="20%">Nama Barang</th>
                <th width="10%">Tanggal</th>
                <th width="10%">Kategori</th>
                <th width="10%" class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksi as $index => $item)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $item->kode_transaksi ?? '-' }}</td>
                <td>{{ $item->kode_barang ?? '-' }}</td>
                <td>{{ $item->nama_barang ?? '-' }}</td>
                <td class="text-center">{{ $item->tanggal_input ? \Carbon\Carbon::parse($item->tanggal_input)->format('d/m/Y') : '-' }}</td>
                <td>{{ $item->kode_kategori ?? '-' }}</td>
                <td class="text-right">{{ number_format($item->total ?? 0, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
        
        <!-- TOTAL -->
        @if($transaksi->count() > 0)
        <tfoot>
            <tr class="total-row">
                <td colspan="6" class="text-right"><strong>TOTAL</strong></td>
                <td class="text-right">
                    <strong>{{ number_format($transaksi->sum('total'), 0, ',', '.') }}</strong>
                </td>
            </tr>
        </tfoot>
        @endif
    </table>

    <!-- Footer -->
    <div class="footer">
        <div>
            <p>Dicetak oleh: {{ auth()->user()->name ?? 'System' }}</p>
        </div>
        <div>
            <p>Hal: 1 dari 1 | {{ $transaksi->count() }} Data</p>
        </div>
    </div>
</body>
</html>
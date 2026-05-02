<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'Helvetica','Arial',sans-serif;font-size:11px;color:#1e293b;line-height:1.5}
        .header{text-align:center;border-bottom:3px solid #1e40af;padding-bottom:12px;margin-bottom:16px}
        .header h1{font-size:16px;color:#1e40af;margin-bottom:2px}
        .header h2{font-size:13px;color:#334155;margin-bottom:4px}
        .header p{font-size:10px;color:#64748b}
        .section{margin-bottom:18px}
        .section-title{font-size:13px;font-weight:bold;color:#1e40af;border-bottom:2px solid #dbeafe;padding-bottom:4px;margin-bottom:8px}
        .stats-row{display:flex;gap:10px;margin-bottom:12px}
        .stat-box{background:#f1f5f9;border:1px solid #e2e8f0;border-radius:6px;padding:8px 12px;flex:1;text-align:center}
        .stat-box .val{font-size:18px;font-weight:bold;color:#1e40af}
        .stat-box .lbl{font-size:9px;color:#64748b;text-transform:uppercase}
        table{width:100%;border-collapse:collapse;margin-bottom:12px}
        th{background:#1e40af;color:#fff;padding:6px 8px;font-size:10px;text-align:left;text-transform:uppercase}
        td{padding:5px 8px;border-bottom:1px solid #e2e8f0;font-size:10px}
        tr:nth-child(even) td{background:#f8fafc}
        .footer{margin-top:20px;padding-top:10px;border-top:1px solid #e2e8f0;font-size:9px;color:#94a3b8;text-align:center}
        .text-right{text-align:right}
    </style>
</head>
<body>
    <div class="header">
        <h1>BPMP PROVINSI GORONTALO</h1>
        <h2>{{ $title }}</h2>
        <p>Periode: {{ $periode }} | Dicetak oleh: {{ $generated_by }} | Tanggal: {{ $generated_at->format('d/m/Y H:i') }}</p>
    </div>

    <div class="section">
        <div class="section-title">Ringkasan Statistik</div>
        <table>
            <tr>
                <td><strong>Total Item Persediaan:</strong></td><td>{{ number_format($stats['total_item']) }}</td>
                <td><strong>Transaksi Masuk:</strong></td><td>{{ $stats['total_masuk'] }}</td>
                <td><strong>Transaksi Keluar:</strong></td><td>{{ $stats['total_keluar'] }}</td>
            </tr>
            <tr>
                <td><strong>Nilai Masuk:</strong></td><td>Rp {{ number_format($stats['nilai_masuk'],0,',','.') }}</td>
                <td><strong>Nilai Keluar:</strong></td><td>Rp {{ number_format($stats['nilai_keluar'],0,',','.') }}</td>
                <td></td><td></td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Data Persediaan</div>
        <table>
            <thead><tr><th>No</th><th>Kode Barang</th><th>Nama Barang</th><th>Kategori</th><th>Jumlah</th><th>Harga Satuan</th></tr></thead>
            <tbody>
            @foreach($persediaan as $i => $item)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $item->kode_barang }}</td>
                    <td>{{ $item->nama_barang }}</td>
                    <td>{{ $item->kategori }}</td>
                    <td>{{ $item->getRawOriginal('jumlah') }}</td>
                    <td>Rp {{ number_format($item->getRawOriginal('harga_satuan') ?? 0,0,',','.') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Transaksi Masuk Persediaan</div>
        <table>
            <thead><tr><th>No</th><th>Tanggal</th><th>Kode Barang</th><th>Nama Barang</th><th>Jumlah</th><th>Total</th></tr></thead>
            <tbody>
            @forelse($transaksi_masuk as $i => $item)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $item->tanggal_input ? $item->tanggal_input->format('d/m/Y') : '-' }}</td>
                    <td>{{ $item->kode_barang }}</td>
                    <td>{{ $item->nama_barang }}</td>
                    <td>{{ $item->jumlah_masuk }}</td>
                    <td>Rp {{ number_format($item->getRawOriginal('total') ?? 0,0,',','.') }}</td>
                </tr>
            @empty
                <tr><td colspan="6" style="text-align:center">Tidak ada data</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Transaksi Keluar Persediaan</div>
        <table>
            <thead><tr><th>No</th><th>Tanggal</th><th>Kode Barang</th><th>Nama Barang</th><th>Jumlah</th><th>Total</th></tr></thead>
            <tbody>
            @forelse($transaksi_keluar as $i => $item)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $item->tanggal_input ? $item->tanggal_input->format('d/m/Y') : '-' }}</td>
                    <td>{{ $item->kode_barang }}</td>
                    <td>{{ $item->nama_barang }}</td>
                    <td>{{ $item->jumlah_keluar }}</td>
                    <td>Rp {{ number_format($item->getRawOriginal('total') ?? 0,0,',','.') }}</td>
                </tr>
            @empty
                <tr><td colspan="6" style="text-align:center">Tidak ada data</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="footer">
        Dokumen ini dicetak secara otomatis oleh Sistem SIPANDU &mdash; BPMP Provinsi Gorontalo &mdash; {{ $generated_at->format('d/m/Y H:i') }}
    </div>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'Helvetica','Arial',sans-serif;font-size:11px;color:#1e293b;line-height:1.5}
        .header{text-align:center;border-bottom:3px solid #ea580c;padding-bottom:12px;margin-bottom:16px}
        .header h1{font-size:16px;color:#ea580c;margin-bottom:2px}
        .header h2{font-size:13px;color:#334155;margin-bottom:4px}
        .header p{font-size:10px;color:#64748b}
        .section{margin-bottom:18px}
        .section-title{font-size:13px;font-weight:bold;color:#ea580c;border-bottom:2px solid #fed7aa;padding-bottom:4px;margin-bottom:8px}
        table{width:100%;border-collapse:collapse;margin-bottom:12px}
        th{background:#ea580c;color:#fff;padding:6px 8px;font-size:10px;text-align:left;text-transform:uppercase}
        td{padding:5px 8px;border-bottom:1px solid #e2e8f0;font-size:10px}
        tr:nth-child(even) td{background:#f8fafc}
        .footer{margin-top:20px;padding-top:10px;border-top:1px solid #e2e8f0;font-size:9px;color:#94a3b8;text-align:center}
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
                <td><strong>Total Aset:</strong></td><td>{{ number_format($stats['total_aset']) }}</td>
                <td><strong>Nilai Aset:</strong></td><td>Rp {{ number_format($stats['total_nilai'],0,',','.') }}</td>
            </tr>
            <tr>
                <td><strong>Transaksi Masuk:</strong></td><td>{{ $stats['total_masuk'] }}</td>
                <td><strong>Transaksi Keluar:</strong></td><td>{{ $stats['total_keluar'] }}</td>
            </tr>
            <tr>
                <td><strong>Total Mutasi:</strong></td><td>{{ $stats['total_mutasi'] }}</td>
                <td></td><td></td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Data Aset Tetap</div>
        <table>
            <thead><tr><th>No</th><th>Kode</th><th>Nama Barang</th><th>Kategori</th><th>Kondisi</th><th>Lokasi</th><th>Jumlah</th><th>Nilai</th></tr></thead>
            <tbody>
            @foreach($aset as $i => $item)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $item->kode_barang }}</td>
                    <td>{{ $item->nama_barang }}</td>
                    <td>{{ $item->kategori }}</td>
                    <td>{{ $item->kondisi }}</td>
                    <td>{{ $item->lokasi }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>Rp {{ number_format($item->nilai_perolehan ?? 0,0,',','.') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Transaksi Masuk Aset Tetap</div>
        <table>
            <thead><tr><th>No</th><th>Tanggal</th><th>Nama Barang</th><th>Kategori</th><th>Nilai Perolehan</th></tr></thead>
            <tbody>
            @forelse($transaksi_masuk as $i => $item)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $item->tanggal_perolehan ? \Carbon\Carbon::parse($item->tanggal_perolehan)->format('d/m/Y') : '-' }}</td>
                    <td>{{ $item->nama_barang }}</td>
                    <td>{{ $item->kategori ?? '-' }}</td>
                    <td>Rp {{ number_format($item->nilai_perolehan ?? 0,0,',','.') }}</td>
                </tr>
            @empty
                <tr><td colspan="5" style="text-align:center">Tidak ada data</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Mutasi Barang</div>
        <table>
            <thead><tr><th>No</th><th>Tanggal</th><th>Nama Barang</th><th>Dari</th><th>Ke</th><th>Keterangan</th></tr></thead>
            <tbody>
            @forelse($mutasi as $i => $item)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $item->tanggal_mutasi ? \Carbon\Carbon::parse($item->tanggal_mutasi)->format('d/m/Y') : '-' }}</td>
                    <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                    <td>{{ $item->lokasi_asal ?? '-' }}</td>
                    <td>{{ $item->lokasi_tujuan ?? '-' }}</td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
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

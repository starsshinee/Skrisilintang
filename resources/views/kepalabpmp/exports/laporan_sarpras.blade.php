<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'Helvetica','Arial',sans-serif;font-size:11px;color:#1e293b;line-height:1.5}
        .header{text-align:center;border-bottom:3px solid #0284c7;padding-bottom:12px;margin-bottom:16px}
        .header h1{font-size:16px;color:#0284c7;margin-bottom:2px}
        .header h2{font-size:13px;color:#334155;margin-bottom:4px}
        .header p{font-size:10px;color:#64748b}
        .section{margin-bottom:18px}
        .section-title{font-size:13px;font-weight:bold;color:#0284c7;border-bottom:2px solid #bae6fd;padding-bottom:4px;margin-bottom:8px}
        table{width:100%;border-collapse:collapse;margin-bottom:12px}
        th{background:#0284c7;color:#fff;padding:6px 8px;font-size:10px;text-align:left;text-transform:uppercase}
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
                <td><strong>Total Gedung:</strong></td><td>{{ $stats['total_gedung'] }}</td>
                <td><strong>Gedung Tersedia:</strong></td><td>{{ $stats['gedung_tersedia'] }}</td>
            </tr>
            <tr>
                <td><strong>Total Kerusakan:</strong></td><td>{{ $stats['total_kerusakan'] }}</td>
                <td><strong>Peminjaman Gedung:</strong></td><td>{{ $stats['total_peminjaman_gedung'] }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Data Gedung</div>
        <table>
            <thead><tr><th>No</th><th>Nama Gedung</th><th>Lokasi</th><th>Kapasitas</th><th>Tarif Sewa</th><th>Ketersediaan</th></tr></thead>
            <tbody>
            @foreach($gedung as $i => $item)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $item->nama_gedung }}</td>
                    <td>{{ $item->lokasi }}</td>
                    <td>{{ $item->kapasitas }} orang</td>
                    <td>Rp {{ number_format($item->tarif_sewa ?? 0,0,',','.') }}</td>
                    <td>{{ $item->ketersediaan }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Data Kerusakan</div>
        <table>
            <thead><tr><th>No</th><th>Tanggal</th><th>Nama Barang</th><th>Kode</th><th>Kondisi</th><th>Lokasi</th></tr></thead>
            <tbody>
            @forelse($kerusakan as $i => $item)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $item->tanggal_input ? $item->tanggal_input->format('d/m/Y') : '-' }}</td>
                    <td>{{ $item->nama_barang }}</td>
                    <td>{{ $item->kode_barang }}</td>
                    <td>{{ $item->kondisi }}</td>
                    <td>{{ $item->lokasi }}</td>
                </tr>
            @empty
                <tr><td colspan="6" style="text-align:center">Tidak ada data</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Peminjaman Gedung</div>
        <table>
            <thead><tr><th>No</th><th>Peminjam</th><th>Gedung</th><th>Tgl Pinjam</th><th>Tgl Kembali</th><th>Status</th></tr></thead>
            <tbody>
            @forelse($peminjaman_gedung as $i => $item)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $item->nama_lengkap }}</td>
                    <td>{{ $item->gedung->nama_gedung ?? '-' }}</td>
                    <td>{{ $item->tanggal_pinjam ? $item->tanggal_pinjam->format('d/m/Y') : '-' }}</td>
                    <td>{{ $item->tanggal_kembali ? $item->tanggal_kembali->format('d/m/Y') : '-' }}</td>
                    <td>{{ ucfirst(str_replace('_',' ',$item->status)) }}</td>
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

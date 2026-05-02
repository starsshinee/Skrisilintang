@extends('adminasettetap.laporan.exports.layout')

@section('content')
<div class="section-title">A. Ringkasan Kinerja (KPI)</div>
<table class="data-table">
    <thead>
        <tr>
            <th>Total Aset</th>
            <th>Transaksi Masuk</th>
            <th>Transaksi Keluar</th>
            <th>Peminjaman Aktif</th>
            <th>Total Pengaduan</th>
            <th>Survey Rata-rata</th>
        </tr>
    </thead>
    <tbody>
        <tr class="text-center" style="font-weight: bold; font-size: 14pt;">
            <td>{{ number_format($stats['total_asset'] ?? 0) }}</td>
            <td>{{ number_format($stats['transaksi_masuk'] ?? 0) }}</td>
            <td>{{ number_format($stats['transaksi_keluar'] ?? 0) }}</td>
            <td>{{ number_format(($stats['peminjaman_barang_aktif'] ?? 0) + ($stats['peminjaman_kendaraan_aktif'] ?? 0)) }}</td>
            <td>{{ number_format($stats['total_pengaduan'] ?? 0) }}</td>
            <td>{{ number_format($stats['survey_rata_rata'] ?? 0, 1) }} / 5</td>
        </tr>
    </tbody>
</table>

<br>
<div class="section-title">B. Top 5 Aset Paling Banyak Dimasukkan</div>
<table class="data-table">
    <thead>
        <tr>
            <th style="width: 10%;">No</th>
            <th style="width: 70%;">Nama Barang</th>
            <th style="width: 20%;">Total Transaksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($summary['top_5_asset_masuk'] ?? [] as $index => $item)
        <tr>
            <td class="text-center">{{ $index + 1 }}</td>
            <td>{{ $item->nama_barang }}</td>
            <td class="text-center">{{ $item->total }} Kali</td>
        </tr>
        @empty
        <tr><td colspan="3" class="text-center">Data tidak tersedia</td></tr>
        @endforelse
    </tbody>
</table>

<br>
<div class="section-title">C. Rekapitulasi Pengaduan berdasarkan Status</div>
<table class="data-table" style="width: 50%;">
    <thead>
        <tr>
            <th>Status</th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>
        @foreach(['baru', 'diproses', 'selesai', 'ditolak'] as $status)
        <tr>
            <td>{{ strtoupper($status) }}</td>
            <td class="text-center">{{ $summary['pengaduan_status'][$status] ?? 0 }} Laporan</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
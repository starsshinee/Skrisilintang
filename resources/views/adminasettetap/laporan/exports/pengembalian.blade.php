@extends('adminasettetap.laporan.exports.layout')

@section('content')
<div class="section-title">A. Pengembalian Barang</div>
<table class="data-table">
    <thead>
        <tr>
            <th style="width: 5%;">No</th>
            <th style="width: 15%;">Tgl Kembali</th>
            <th style="width: 25%;">Peminjam</th>
            <th style="width: 25%;">Barang</th>
            <th style="width: 15%;">Kondisi</th>
            <th style="width: 15%;">Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($pengembalian_barang as $index => $item)
        <tr>
            <td class="text-center">{{ $index + 1 }}</td>
            <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_pengembalian_aktual)->format('d/m/Y') }}</td>
            <td>{{ $item->user->name ?? '-' }}</td>
            <td>{{ $item->peminjamanBarang->nama_barang ?? '-' }}</td>
            <td class="text-center">{{ strtoupper(str_replace('-', ' ', $item->kondisi_barang ?? '')) }}</td>
            <td class="text-center">{{ strtoupper($item->status_verifikasi ?? '') }}</td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center">Tidak ada data pengembalian barang.</td></tr>
        @endforelse
    </tbody>
</table>

<div class="section-title">B. Pengembalian Kendaraan</div>
<table class="data-table">
    <thead>
        <tr>
            <th style="width: 5%;">No</th>
            <th style="width: 15%;">Tgl Kembali</th>
            <th style="width: 25%;">Peminjam</th>
            <th style="width: 25%;">Kendaraan</th>
            <th style="width: 15%;">Kondisi</th>
            <th style="width: 15%;">Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($pengembalian_kendaraan as $index => $item)
        <tr>
            <td class="text-center">{{ $index + 1 }}</td>
            <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_pengembalian_aktual)->format('d/m/Y') }}</td>
            <td>{{ $item->user->name ?? '-' }}</td>
            <td>{{ $item->peminjamanKendaraan->nama_barang ?? '-' }}</td>
            <td class="text-center">{{ strtoupper(str_replace('-', ' ', $item->kondisi_kendaraan ?? '')) }}</td>
            <td class="text-center">{{ strtoupper($item->status_pengembalian ?? '') }}</td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center">Tidak ada data pengembalian kendaraan.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
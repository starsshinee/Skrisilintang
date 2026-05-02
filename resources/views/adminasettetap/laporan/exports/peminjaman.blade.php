@extends('adminasettetap.laporan.exports.layout')

@section('content')
<div class="section-title">A. Peminjaman Barang</div>
<table class="data-table">
    <thead>
        <tr>
            <th style="width: 5%;">No</th>
            <th style="width: 15%;">Tgl Pinjam</th>
            <th style="width: 25%;">Peminjam</th>
            <th style="width: 35%;">Barang yang Dipinjam</th>
            <th style="width: 20%;">Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($peminjaman_barang as $index => $item)
        <tr>
            <td class="text-center">{{ $index + 1 }}</td>
            <td class="text-center">{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</td>
            <td>{{ $item->user->name ?? '-' }}</td>
            <td>{{ $item->nama_barang ?? '-' }}</td>
            <td class="text-center">{{ strtoupper(str_replace('_', ' ', $item->status)) }}</td>
        </tr>
        @empty
        <tr><td colspan="5" class="text-center">Tidak ada data peminjaman barang.</td></tr>
        @endforelse
    </tbody>
</table>

<div class="section-title">B. Peminjaman Kendaraan</div>
<table class="data-table">
    <thead>
        <tr>
            <th style="width: 5%;">No</th>
            <th style="width: 15%;">Tgl Pinjam</th>
            <th style="width: 25%;">Peminjam</th>
            <th style="width: 35%;">Kendaraan</th>
            <th style="width: 20%;">Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($peminjaman_kendaraan as $index => $item)
        <tr>
            <td class="text-center">{{ $index + 1 }}</td>
            <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_peminjaman)->format('d/m/Y') }}</td>
            <td>{{ $item->user->name ?? '-' }}</td>
            <td>{{ $item->kendaraan->merek ?? $item->nama_barang ?? '-' }}</td>
            <td class="text-center">{{ strtoupper(str_replace('_', ' ', $item->status)) }}</td>
        </tr>
        @empty
        <tr><td colspan="5" class="text-center">Tidak ada data peminjaman kendaraan.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
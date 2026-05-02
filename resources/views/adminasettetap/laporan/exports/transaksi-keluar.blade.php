@extends('adminasettetap.laporan.exports.layout')

@section('content')
<table class="data-table">
    <thead>
        <tr>
            <th style="width: 5%;">No</th>
            <th style="width: 15%;">Tgl Keluar</th>
            <th style="width: 30%;">Nama Barang</th>
            <th style="width: 20%;">Penerima / Tujuan</th>
            <th style="width: 30%;">Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @forelse($transaksi as $index => $item)
        <tr>
            <td class="text-center">{{ $index + 1 }}</td>
            <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_input)->format('d/m/Y') }}</td>
            <td>{{ $item->nama_barang }}</td>
            <td>{{ $item->penerima ?? '-' }}</td>
            <td>{{ $item->keterangan ?? '-' }}</td>
        </tr>
        @empty
        <tr><td colspan="5" class="text-center">Tidak ada data transaksi keluar pada periode ini.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
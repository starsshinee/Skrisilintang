@extends('adminasettetap.laporan.exports.layout')

@section('content')
<table class="data-table">
    <thead>
        <tr>
            <th style="width: 5%;">No</th>
            <th style="width: 15%;">Tgl Mutasi</th>
            <th style="width: 25%;">Barang (NUP)</th>
            <th style="width: 20%;">Lokasi Asal</th>
            <th style="width: 20%;">Lokasi Tujuan</th>
            <th style="width: 15%;">Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @forelse($mutasi as $index => $item)
        <tr>
            <td class="text-center">{{ $index + 1 }}</td>
            <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_mutasi)->format('d/m/Y') }}</td>
            <td>{{ $item->barang->nama_barang ?? '-' }} <br><small>NUP: {{ $item->barang->nup ?? '-' }}</small></td>
            <td>{{ $item->lokasi_asal }}</td>
            <td>{{ $item->lokasi_tujuan }}</td>
            <td>{{ $item->keterangan ?? '-' }}</td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center">Tidak ada data mutasi barang pada periode ini.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
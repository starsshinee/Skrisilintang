@extends('adminasettetap.laporan.exports.layout')

@section('content')
<table class="data-table">
    <thead>
        <tr>
            <th style="width: 5%;">No</th>
            <th style="width: 15%;">Tgl Perolehan</th>
            <th style="width: 30%;">Nama Barang</th>
            <th style="width: 20%;">Merk / Tipe</th>
            <th style="width: 15%;">Nilai Perolehan</th>
        </tr>
    </thead>
    <tbody>
        @forelse($transaksi as $index => $item)
        <tr>
            <td class="text-center">{{ $index + 1 }}</td>
            <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_perolehan)->format('d/m/Y') }}</td>
            <td>{{ $item->nama_barang }}</td>
            <td>{{ $item->merk ?? '-' }}</td>
            <td class="text-right">Rp {{ number_format($item->nilai_perolehan ?? 0, 0, ',', '.') }}</td>
        </tr>
        @empty
        <tr><td colspan="5" class="text-center">Tidak ada data transaksi masuk pada periode ini.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
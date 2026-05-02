@extends('adminasettetap.laporan.exports.layout')

@section('content')
<table class="data-table">
    <thead>
        <tr>
            <th style="width: 5%;">No</th>
            <th style="width: 15%;">Tgl Lapor</th>
            <th style="width: 20%;">Pelapor</th>
            <th style="width: 15%;">Kategori</th>
            <th style="width: 30%;">Keluhan / Deskripsi</th>
            <th style="width: 15%;">Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($pengaduan as $index => $item)
        <tr>
            <td class="text-center">{{ $index + 1 }}</td>
            <td class="text-center">{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</td>
            <td>{{ $item->nama_lengkap }}</td>
            <td class="text-center">{{ strtoupper($item->kategori) }}</td>
            <td>{{ $item->deskripsi }}</td>
            <td class="text-center">{{ strtoupper($item->status) }}</td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center">Tidak ada data pengaduan.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
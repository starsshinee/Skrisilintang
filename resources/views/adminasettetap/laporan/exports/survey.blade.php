@extends('adminasettetap.laporan.exports.layout')

@section('content')
<table class="data-table">
    <thead>
        <tr>
            <th style="width: 5%;">No</th>
            <th style="width: 15%;">Tgl Survey</th>
            <th style="width: 20%;">Responden</th>
            <th style="width: 20%;">Tingkat Kepuasan</th>
            <th style="width: 40%;">Kritik & Saran</th>
        </tr>
    </thead>
    <tbody>
        @forelse($survey as $index => $item)
        <tr>
            <td class="text-center">{{ $index + 1 }}</td>
            <td class="text-center">{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</td>
            <td>{{ $item->nama ?? 'Anonim' }}</td>
            <td class="text-center">{{ strtoupper(str_replace('_', ' ', $item->kepuasan)) }}</td>
            <td>{{ $item->kritik_saran ?? '-' }}</td>
        </tr>
        @empty
        <tr><td colspan="5" class="text-center">Tidak ada data survey kepuasan.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
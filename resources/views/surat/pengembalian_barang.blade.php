<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Pengembalian Barang</title>
    <style>
        /* 1. PENGATURAN KERTAS A4 & MARGIN */
        @page {
            size: A4 portrait;
            margin-top: 2cm;
            margin-bottom: 1.5cm;
            margin-left: 2.5cm;
            margin-right: 2.5cm;
        }

        /* 2. TYPOGRAPHY & SPACING DASAR */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11pt; 
            line-height: 1.3;
            color: #000;
        }

        /* 3. KOP SURAT */
        .kop-surat {
            margin-bottom: 15px;
            width: 100%;
        }
        .kop-surat img {
            width: 100%; 
            height: auto;
            display: block;
        }

        /* 4. JUDUL SURAT */
        .judul-container {
            text-align: center;
            margin-bottom: 15px;
        }
        .judul-surat {
            font-size: 11pt;
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
        }
        .nomor-surat {
            font-size: 11pt;
        }

        /* 5. TYPOGRAPHY KUSTOM */
        .text-justify { text-align: justify; }
        .font-bold { font-weight: bold; }
        .italic { font-style: italic; }

        /* 6. TABEL DATA */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 15px;
        }
        table.data-table td {
            vertical-align: top;
            padding: 3px 0;
        }
        .td-label { width: 160px; }
        .td-titikdua { width: 15px; text-align: center; }

        /* 7. TABEL TANDA TANGAN */
        table.ttd-table {
            width: 100%;
            text-align: center;
            margin-top: 20px;
            page-break-inside: avoid; 
        }
        table.ttd-table td {
            vertical-align: top;
            padding: 0;
        }
        .ttd-space { height: 55px; } 
        .ttd-nama {
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 2px;
        }
    </style>
</head>
<body>

    @php
        // LOGIKA PENANGGALAN OTOMATIS (FORMAT ANGKA)
        $tgl = $pengembalian->tanggal_pengembalian_aktual ?? now();
        $hari = \Carbon\Carbon::parse($tgl)->locale('id')->translatedFormat('l');
        $tanggal_angka = \Carbon\Carbon::parse($tgl)->format('j');
        $bulan = \Carbon\Carbon::parse($tgl)->locale('id')->translatedFormat('F');
        $tahun_angka = \Carbon\Carbon::parse($tgl)->format('Y');

        // FORMAT NOMOR SURAT
        $nomor_urut = str_pad($pengembalian->id, 4, '0', STR_PAD_LEFT);
        $nomor_surat = "S{$nomor_urut}/BPMP.GTLO/KPA/{$tahun_angka}";
    @endphp

    {{-- KOP SURAT --}}
    <div class="kop-surat">
        <img src="{{ storage_path('app/public/kop_surat.png') }}" alt="Kop Surat BPMP Provinsi Gorontalo"> 
    </div>

    {{-- JUDUL SURAT --}}
    <div class="judul-container">
        <div class="judul-surat">PENGEMBALIAN PEMINJAMAN</div>
        <div class="nomor-surat">No: {{ $nomor_surat }}</div>
    </div>

    {{-- PARAGRAF PEMBUKA --}}
    <div class="text-justify">
        Pada hari ini <span class="font-bold italic">{{ str_pad('', 15, '.') }}{{ $hari }}{{ str_pad('', 15, '.') }}</span> tanggal <span class="font-bold italic">{{ str_pad('', 15, '.') }}{{ $tanggal_angka }}{{ str_pad('', 15, '.') }}</span> Bulan <span class="font-bold italic">{{ str_pad('', 15, '.') }}{{ $bulan }}{{ str_pad('', 15, '.') }} Tahun {{ $tahun_angka }}</span> yang bertanda tangan dibawah ini :
    </div>

    {{-- TABEL IDENTITAS & BARANG --}}
    <table class="data-table">
        <tr>
            <td class="td-label">Nama</td>
            <td class="td-titikdua">:</td>
            <td>{{ $pengembalian->user->name ?? '-' }}</td>
        </tr>
        <tr>
            <td class="td-label">NIP</td>
            <td class="td-titikdua">:</td>
            <td>{{ $pengembalian->user->nip ?? '-' }}</td>
        </tr>
        <tr>
            <td class="td-label">Jabatan</td>
            <td class="td-titikdua">:</td>
            <td>{{ $pengembalian->user->jabatan ?? '-' }}</td>
        </tr>
        <tr>
            <td class="td-label">Nama Barang</td>
            <td class="td-titikdua">:</td>
            <td>{{ $pengembalian->peminjamanBarang->nama_barang ?? '-' }}</td>
        </tr>
        <tr>
            <td class="td-label">Merk/Type</td>
            <td class="td-titikdua">:</td>
            <td>{{ $pengembalian->peminjamanBarang->merek ?? '-' }}</td>
        </tr>
        <tr>
            <td class="td-label">Jumlah</td>
            <td class="td-titikdua">:</td>
            <td>{{ $pengembalian->jumlah_dikembalikan ?? '0' }} Unit</td>
        </tr>
        <tr>
            <td class="td-label">Alasan Pengembalian</td>
            <td class="td-titikdua">:</td>
            <td>{{ $pengembalian->catatan ?? 'Selesai digunakan' }}</td>
        </tr>
    </table>

    {{-- PARAGRAF PENUTUP --}}
    <div class="text-justify">
        Bahwa barang tersebut telah Selesai di Pergunakan dan di kembalikan sebagaimana Terlampir bahwa barang tersebut masih dalam keadaan baik dan lengkap.
    </div>
    <div class="text-justify" style="text-indent: 40px; margin-top: 10px;">
        Demikian berita acara ini ditandatangani dengan sebenar-benarnya dan untuk digunakan sebagaimana mestinya.
    </div>

    {{-- AREA TANDA TANGAN --}}
    <table class="ttd-table">
        <tr>
            <td width="50%">
                <div class="font-bold">Pengadministrasi BMN</div>
                <div class="ttd-space">
                    @if(!empty($ttdAdmin))
                        <img src="{{ $ttdAdmin }}" alt="TTD Admin" style="max-height: 55px; margin-top: 5px;">
                    @endif
                </div>
                <div class="ttd-nama">{{ $admin->name ?? 'Wiwin Suriadi Bokingo' }}</div>
                <div>NIP. {{ $admin->nip ?? '198001122008101002' }}</div>
            </td>
            <td width="50%">
                <div class="font-bold">Peminjam</div>
                <div class="ttd-space">
                    @if(!empty($ttdPeminjam))
                        <img src="{{ $ttdPeminjam }}" alt="TTD Peminjam" style="max-height: 55px; margin-top: 5px;">
                    @endif
                </div>
                <div class="ttd-nama">{{ $pengembalian->user->name ?? '...................................................' }}</div>
                <div>NIP. {{ $pengembalian->user->nip ?? '....................................' }}</div>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding-top: 25px;">
                <div class="font-bold">Mengetahui,</div>
                <div class="font-bold">Kuasa Pengguna Barang</div>
                <div class="ttd-space">
                    @if(!empty($ttdKepala))
                        <img src="{{ $ttdKepala }}" alt="TTD Kepala" style="max-height: 55px; margin-top: 5px;">
                    @endif
                </div>
                <div class="ttd-nama">{{ $kepala->name ?? 'Rudi Syaifullah, S. SI,M,M.' }}</div>
                <div>NIP. {{ $kepala->nip ?? '197606272003121002' }}</div>
            </td>
        </tr>
    </table>

</body>
</html>
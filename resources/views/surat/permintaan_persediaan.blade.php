<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Surat Permintaan Persediaan</title>
<style>
    /* 1. PENGATURAN MARGIN KERTAS PDF (Atas 4cm, Bawah 4cm, Kiri 3cm, Kanan 3cm) */
    @page {
        size: A4 portrait;
        margin-top: 4cm;
        margin-bottom: 4cm;
        margin-left: 3cm;
        margin-right: 3cm;
    }

    /* 2. RESET BODY & PEMADATAN TYPOGRAPHY */
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 9.5pt; /* Diperkecil agar dijamin muat 1 halaman dengan margin besar */
        line-height: 1.2; /* Spasi antar baris dirapatkan */
        color: #000;
        background-color: transparent;
    }

    /* 3. KOP SURAT */
    .kop-surat {
        margin-bottom: 8px; /* Jarak kop ke judul diperkecil */
        width: 100%;
    }
    .kop-surat img {
        width: 100%; 
        height: auto;
        display: block;
    }

    /* 4. TIPOGRAFI & SPACING */
    .text-center { text-align: center; }
    .text-justify { text-align: justify; }
    .font-bold { font-weight: bold; }
    
    .mb-5 { margin-bottom: 4px; }
    .mb-10 { margin-bottom: 8px; }

    .judul-surat {
        font-size: 10.5pt;
        margin-bottom: 2px;
        text-decoration: underline;
        font-weight: bold;
    }

    /* 5. TABEL IDENTITAS & BARANG */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 8px; /* Jarak bawah tabel diperkecil */
    }
    td {
        vertical-align: top;
        padding: 1px 0; /* Jarak antar baris tabel dirapatkan */
    }
    .td-label { width: 110px; }
    .td-titikdua { width: 15px; text-align: center; }

    /* 6. TABEL TANDA TANGAN */
    .ttd-table {
        width: 100%;
        text-align: center;
        margin-top: 10px; /* Spasi sebelum tabel TTD diperkecil */
        page-break-inside: avoid; 
    }
    .ttd-table td {
        width: 50%;
        padding: 0;
        vertical-align: bottom;
    }
    .ttd-img-container {
        height: 45px; /* Area gambar TTD dipadatkan */
        margin: 2px 0;
    }
    .ttd-img-container img {
        max-height: 45px;
        max-width: 100px;
    }
    .ttd-nama {
        font-weight: bold;
        text-decoration: underline;
        margin-bottom: 1px;
    }

    /* 7. FOOTER */
    .footer {
        position: fixed;
        bottom: -3cm; 
        left: 0;
        right: 0;
        font-size: 8pt; 
        color: #555;
        text-align: center;
        border-top: 1px solid #ccc;
        padding-top: 4px;
    }
</style>
</head>
<body>

    {{-- KOP SURAT --}}
    <div class="kop-surat">
        <img src="{{ storage_path('app/public/kop_surat.png') }}" alt="Kop Surat BPMP Provinsi Gorontalo"> 
    </div>

    <!-- JUDUL -->
    <div class="text-center mb-10">
        <div class="judul-surat">SURAT PERMINTAAN PERSEDIAAN</div>
        @php
            // Format ID jadi 3 digit (contoh: 1 -> 001, 25 -> 025)
            $nomor_urut = str_pad($permintaan->id, 3, '0', STR_PAD_LEFT);
            
            // Ambil tahun dari tanggal permintaan dibuat
            $tahun_surat = \Carbon\Carbon::parse($permintaan->created_at)->format('Y');
        @endphp
        <div>No: {{ $nomor_urut }}/BA.PP/693228/2026{{ date('Y') }}</div>
    </div>

    <!-- PEMBUKA -->
    <div class="text-justify mb-5">
        Yang bertanda tangan di bawah ini:
    </div>

    <!-- IDENTITAS PEMOHON (Ditarik dari relasi $permintaan->user) -->
    <table>
        <tr>
            <td class="td-label">Nama</td>
            <td class="td-titikdua">:</td>
            <td>{{ $peminjam->nama_lengkap ?? $peminjam->name ?? '-' }}</td>
        </tr>
        <tr>
            <td>NIP</td>
            <td class="td-titikdua">:</td>
            <td>{{ $peminjam->nip ?? '-' }}</td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td class="td-titikdua">:</td>
            <td>{{ $peminjam->jabatan ?? '-' }}</td>
        </tr>
        <tr>
            <td>Unit Kerja</td>
            <td class="td-titikdua">:</td>
            <td>Balai Penjaminan Mutu Pendidikan Provinsi Gorontalo</td>
        </tr>
    </table>

    <!-- PARAGRAF TRANSISI -->
    <div class="text-justify mb-5">
        Dengan ini mengajukan permintaan persediaan dengan rincian sebagai berikut:
    </div>

    <!-- DATA BARANG (Ditarik dari tabel permintaan_persediaan & relasinya) -->
    <table>
        <tr>
            <td class="td-label">Nama Barang</td>
            <td class="td-titikdua">:</td>
            <td class="font-bold">{{ $permintaan->persediaan->nama_barang ?? $permintaan->nama_barang ?? '-' }}</td>
        </tr>
        <tr>
            <td>Merek</td>
            <td class="td-titikdua">:</td>
            <td>{{ $permintaan->persediaan->merek ?? '-' }}</td>
        </tr>
        <tr>
            <td>Jumlah</td>
            <td class="td-titikdua">:</td>
            <td>{{ $permintaan->jumlah_diminta ?? '0' }} {{ $permintaan->persediaan->satuan ?? 'unit' }}</td>
        </tr>
        <tr>
            <td>Peruntukan</td>
            <td class="td-titikdua">:</td>
            <td>{{ $permintaan->tujuan_penggunaan ?? '-' }}</td>
        </tr>
    </table>
        
    <div class="text-justify mb-5">
        Persediaan tersebut diperlukan untuk keperluan operasional dan akan digunakan sesuai dengan peruntukannya.
    </div>

    <div class="text-justify mb-10">
        Demikian permintaan ini kami sampaikan, atas perhatian dan persetujuan Bapak/Ibu, kami ucapkan terima kasih.
    </div>

    <!-- TANGGAL SURAT -->
    @php
        $tgl = $permintaan->created_at ?? now();
        $tanggal = \Carbon\Carbon::parse($tgl)->format('j');
        $bulan = \Carbon\Carbon::parse($tgl)->locale('id')->translatedFormat('F');
        $tahun = \Carbon\Carbon::parse($tgl)->format('Y');
    @endphp
    <div style="text-align: right; margin-bottom: 5px; margin-right: 15px;">
        Gorontalo, {{ $tanggal }} {{ $bulan }} {{ $tahun }}
    </div>

    <!-- TANDA TANGAN -->
    <table class="ttd-table">
        <tr>
            <td>
                <div>Pengadministrasi BMN,</div>
                <div class="ttd-img-container">
                    @if(!empty($ttdAdmin))
                        <img src="{{ $ttdAdmin }}" alt="TTD Admin">
                    @endif
                </div>
                <div class="ttd-nama">{{ $admin->nama_lengkap ?? $admin->name ?? 'Admin Persediaan' }}</div>
                <div>NIP. {{ $admin->nip ?? '-' }}</div>
            </td>
            <td>
                <div>Pemohon,</div>
                <div class="ttd-img-container">
                    @if(!empty($ttdPeminjam))
                        <img src="{{ $ttdPeminjam }}" alt="TTD Pemohon">
                    @endif
                </div>
                <div class="ttd-nama">{{ $peminjam->nama_lengkap ?? $peminjam->name ?? '-' }}</div>
                <div>NIP. {{ $peminjam->nip ?? '-' }}</div>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding-top: 15px;">
                <div>Mengetahui,</div>
                <div class="font-bold">Kuasa Pengguna Barang</div>
                <div class="ttd-img-container">
                    @if(!empty($ttdKepala))
                        <img src="{{ $ttdKepala }}" alt="TTD Kepala">
                    @endif
                </div>
                <div class="ttd-nama">{{ $kepala->nama_lengkap ?? $kepala->name ?? 'Kepala BPMP' }}</div>
                <div>NIP. {{ $kepala->nip ?? '-' }}</div>
            </td>
        </tr>
    </table>

    <!-- FOOTER -->
    <div class="footer">
        Dokumen ini digenerate secara otomatis oleh Sistem Inventaris BPMP Provinsi Gorontalo<br>
        Dicetak pada: {{ $tanggalCetak ?? now()->translatedFormat('d F Y, H:i') }} WITA
    </div>

</body>
</html>
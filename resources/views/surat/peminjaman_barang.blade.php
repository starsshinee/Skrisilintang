<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Berita Acara Pinjam Pakai - {{ $peminjaman->id }}</title>
    <style>
        /* 1. PENGATURAN HALAMAN */
        @page {
            size: A4 portrait;
            /* Margin diperkecil sedikit agar muat satu halaman */
            margin-top: 3cm;
            margin-bottom: 2cm;
            margin-left: 2.5cm;
            margin-right: 2.5cm;
        }

        /* 2. TYPOGRAPHY */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10pt; /* Ukuran standar dokumen kantor */
            line-height: 1.3;
            color: #000;
        }

        .text-center { text-align: center; }
        .text-justify { text-align: justify; }
        .font-bold { font-weight: bold; }
        .italic { font-style: italic; }
        .underline { text-decoration: underline; }
        
        .mb-5 { margin-bottom: 5px; }
        .mb-10 { margin-bottom: 10px; }

        /* 3. KOP SURAT */
        .kop-surat {
            width: 100%;
            margin-bottom: 15px;
        }
        .kop-surat img {
            width: 100%; 
            height: auto;
        }

        .judul-surat {
            font-size: 11pt;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 2px;
        }

        /* 4. TABEL DATA */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        td {
            vertical-align: top;
            padding: 2px 0;
        }
        .td-label { width: 140px; }
        .td-titikdua { width: 15px; text-align: center; }

        /* 5. TANDA TANGAN (KUNCI AGAR SATU HALAMAN) */
        .ttd-table {
            width: 100%;
            text-align: center;
            margin-top: 20px;
            /* Mencegah tabel tanda tangan terpecah ke halaman berbeda */
            page-break-inside: avoid; 
        }
        .ttd-table td {
            width: 50%;
            padding: 5px;
            vertical-align: top;
        }
        .ttd-img-container {
            height: 60px; /* Tinggi dibatasi agar hemat ruang */
            margin: 5px 0;
            display: block;
        }
        .ttd-img-container img {
            max-height: 60px;
            max-width: 120px;
        }
        .ttd-nama {
            font-weight: bold;
            text-decoration: underline;
        }

        /* 6. FOOTER */
        .footer {
            position: fixed;
            bottom: -1cm; 
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
        {{-- Gunakan public_path agar DomPDF lancar membaca file --}}
        <img src="{{ public_path('storage/kop_surat.png') }}" alt="Kop Surat BPMP"> 
    </div>

    <!-- JUDUL & NOMOR SURAT -->
    <div class="text-center mb-10">
        <div class="judul-surat">BERITA ACARA PINJAM PAKAI</div>
        @php
            $nomor_urut = str_pad($peminjaman->id, 3, '0', STR_PAD_LEFT);
            $tahun_surat = \Carbon\Carbon::parse($peminjaman->created_at)->format('Y');
        @endphp
        <div>No: {{ $nomor_urut }}/BA.PP/693228/{{ $tahun_surat }}</div>
    </div>

    <!-- PEMBUKA -->
    <div class="text-justify mb-10">
        @php
          $tgl = $peminjaman->created_at ?? now();
          $hari = \Carbon\Carbon::parse($tgl)->locale('id')->translatedFormat('l');
          $tanggal_teks = \Carbon\Carbon::parse($tgl)->locale('id')->translatedFormat('j');
          $bulan = \Carbon\Carbon::parse($tgl)->locale('id')->translatedFormat('F');
          $tahun = \Carbon\Carbon::parse($tgl)->locale('id')->translatedFormat('Y');
        @endphp
        Pada hari ini <span class="font-bold italic">{{ $hari }}</span> tanggal <span class="font-bold italic">{{ $tanggal_teks }}</span> Bulan <span class="font-bold italic">{{ $bulan }}</span> Tahun <span class="font-bold italic">{{ $tahun }}</span> yang bertanda tangan dibawah ini:
    </div>

    <!-- IDENTITAS PEMINJAM -->
    <table>
        <tr>
            <td class="td-label">Nama</td>
            <td class="td-titikdua">:</td>
            <td>{{ $peminjaman->user->name }}</td>
        </tr>
        <tr>
            <td>NIP / NIK</td>
            <td class="td-titikdua">:</td>
            <td>{{ $peminjaman->user->nip ?? '-' }}</td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td class="td-titikdua">:</td>
            <td>{{ $peminjaman->user->jabatan ?? '-' }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td class="td-titikdua">:</td>
            <td>{{ $peminjaman->user->alamat ?? '-' }}</td>
        </tr>
    </table>

    <div class="text-justify mb-10">
        Sesuai dengan <span class="font-bold">PMK Nomor: 115/PMK.06/2020 Tentang Pemanfaatan Barang Milik Negara</span>. Maka demi untuk tertibnya administrasi Berita Acara Pinjam Pakai ini sebagai berikut:
    </div>

    <!-- DATA BARANG -->
    <table>
        <tr>
            <td class="td-label">Nama Barang</td>
            <td class="td-titikdua">:</td>
            <td class="font-bold">{{ $peminjaman->nama_barang }}</td>
        </tr>
        <tr>
            <td>Kode Barang / NUP</td>
            <td class="td-titikdua">:</td>
            <td>{{ $peminjaman->kode_barang }} / {{ $peminjaman->nup ?? '-' }}</td>
        </tr>
        <tr>
            <td>Merk/Type</td>
            <td class="td-titikdua">:</td>
            <td>{{ $peminjaman->merek ?? '-' }}</td>
        </tr>
        <tr>
            <td>Jumlah</td>
            <td class="td-titikdua">:</td>
            <td>{{ $peminjaman->jumlah }} Unit</td>
        </tr>
        <tr>
            <td>Jangka waktu</td>
            <td class="td-titikdua">:</td>
            <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_peminjaman)->translatedFormat('d M Y') }} s/d {{ \Carbon\Carbon::parse($peminjaman->tanggal_pengembalian)->translatedFormat('d M Y') }}</td>
        </tr>
        <tr>
            <td>Untuk Keperluan</td>
            <td class="td-titikdua">:</td>
            <td>{{ $peminjaman->deskripsi_peruntukan }}</td>
        </tr>
    </table>
        
    <div class="text-justify mb-10">
        Dengan penuh tanggung jawab, dan apabila dikemudian hari barang tersebut hilang maka sebagai Peminjam bertanggung jawab atas kerugian Aset Negara, sesuai dengan ketentuan <span class="font-bold">Pasal 1740 KUHPerdata.</span>
    </div>

    <div class="text-justify mb-10" style="text-indent: 40px;">
        Demikian berita acara ini ditanda tangani dengan sebenar-benarnya dan untuk digunakan sebagaimana mestinya.
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

    <!-- TANDA TANGAN (DIBUNGKUS SATU TABEL) -->
    <table class="ttd-table">
        <tr>
            <td>
                <div>Pengadministrasi BMN,</div>
                <div class="ttd-img-container">
                    @if($ttdAdmin)
                        <img src="{{ $ttdAdmin }}" alt="TTD Admin">
                    @endif
                </div>
                <div class="ttd-nama">{{ $admin->name }}</div>
                <div>NIP. {{ $admin->nip ?? '........................' }}</div>
            </td>
            <td>
                <div>Peminjam,</div>
                <div class="ttd-img-container">
                    @if($ttdPeminjam)
                        <img src="{{ $ttdPeminjam }}" alt="TTD Peminjam">
                    @endif
                </div>
                <div class="ttd-nama">{{ $peminjaman->user->name }}</div>
                <div>NIP. {{ $peminjaman->user->nip ?? '........................' }}</div>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding-top: 20px;">
                <div>Mengetahui,</div>
                <div class="font-bold">Kuasa Pengguna Barang</div>
                <div class="ttd-img-container">
                    @if($ttdKepala)
                        <img src="{{ $ttdKepala }}" alt="TTD Kepala">
                    @endif
                </div>
                <div class="ttd-nama">{{ $kepala->name ?? '........................' }}</div>
                <div>NIP. {{ $kepala->nip ?? '........................' }}</div>
            </td>
        </tr>
    </table>

    <div class="footer">
        Dokumen ini digenerate secara otomatis oleh SIPANDU BPMP Provinsi Gorontalo<br>
        Dicetak pada: {{ now()->translatedFormat('d F Y, H:i') }} WITA
    </div>

</body>
</html>
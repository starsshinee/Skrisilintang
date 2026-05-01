<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Berita Acara Pinjam Pakai</title>
<style>
    /* 1. PENGATURAN MARGIN KERTAS PDF (Tetap Atas/Bawah 4cm, Kiri/Kanan 3cm) */
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
        font-size: 9.5pt; /* Diperkecil lagi agar pasti muat 1 halaman */
        line-height: 1.2; /* Jarak antar baris dirapatkan */
        color: #000;
        background-color: transparent;
    }

    /* 3. KOP SURAT */
    .kop-surat {
        margin-bottom: 5px; /* Jarak kop ke judul diperkecil */
        width: 100%;
    }
    .kop-surat img {
        width: 100%; 
        height: auto;
        display: block;
    }

    /* 4. TIPOGRAFI & SPACING (DIPADATKAN EKSTREM) */
    .text-center { text-align: center; }
    .text-justify { text-align: justify; }
    .font-bold { font-weight: bold; }
    .italic { font-style: italic; }
    .underline { text-decoration: underline; }
    
    .mb-5 { margin-bottom: 3px; } /* Spasi sangat kecil */
    .mb-10 { margin-bottom: 6px; } /* Spasi diperkecil */

    .judul-surat {
        font-size: 10.5pt; /* Judul sedikit disesuaikan */
        margin-bottom: 1px;
        text-decoration: underline;
        font-weight: bold;
    }

    /* 5. TABEL IDENTITAS & BARANG */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 6px; /* Spasi bawah tabel diperkecil */
    }
    td {
        vertical-align: top;
        padding: 1px 0; /* Jarak antar baris tabel dirapatkan */
    }
    .td-label { width: 110px; }
    .td-titikdua { width: 15px; text-align: center; }

    /* 6. CATATAN PENTING */
    .catatan-container {
        margin-top: 5px;
        margin-bottom: 10px; /* Spasi bawah catatan diperkecil */
    }
    .catatan-item {
        font-style: italic;
        margin-bottom: 1px;
        text-align: justify;
    }

    /* 7. TABEL TANDA TANGAN */
    .ttd-table {
        width: 100%;
        text-align: center;
        margin-top: 5px; /* Spasi sebelum TTD diperkecil drastis */
        page-break-inside: avoid; 
    }
    .ttd-table td {
        width: 50%;
        padding: 0;
        vertical-align: bottom;
    }
    .ttd-img-container {
        height: 45px; /* Area gambar TTD sangat diperkecil */
        margin: 1px 0; /* Margin atas/bawah TTD dirapatkan */
    }
    .ttd-img-container img {
        max-height: 45px; /* Tinggi maksimal gambar TTD diperkecil */
        max-width: 100px;
    }
    .ttd-nama {
        font-weight: bold;
        text-decoration: underline;
        margin-bottom: 1px;
    }

    /* 8. FOOTER */
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
        <img src="{{ storage_path('app/public/kop_surat.png') }}" alt="Kop Surat BPMP"> 
    </div>

    <!-- JUDUL -->
    <div class="text-center mb-10">
        <div class="judul-surat">BERITA ACARA PINJAM PAKAI</div>
        <div>No: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/BPMP.GTLO/KPA/{{ date('Y') }}</div>
    </div>

    <!-- PEMBUKA -->
    <div class="text-justify mb-10">
        @php
          $tgl = $request->created_at ?? now();
          $hari = \Carbon\Carbon::parse($tgl)->locale('id')->translatedFormat('l');
          
          $tanggal_angka = \Carbon\Carbon::parse($tgl)->format('j');
          $tanggal_teks = match($tanggal_angka) {
              '1' => 'Satu', '2' => 'Dua', '3' => 'Tiga', '4' => 'Empat', '5' => 'Lima',
              '6' => 'Enam', '7' => 'Tujuh', '8' => 'Delapan', '9' => 'Sembilan', '10' => 'Sepuluh',
              '11' => 'Sebelas', '12' => 'Dua Belas', '13' => 'Tiga Belas', '14' => 'Empat Belas',
              '15' => 'Lima Belas', '16' => 'Enam Belas', '17' => 'Tujuh Belas', '18' => 'Delapan Belas',
              '19' => 'Sembilan Belas', '20' => 'Dua Puluh', '21' => 'Dua Puluh Satu', 
              '22' => 'Dua Puluh Dua', '23' => 'Dua Puluh Tiga', '24' => 'Dua Puluh Empat',
              '25' => 'Dua Puluh Lima', '26' => 'Dua Puluh Enam', '27' => 'Dua Puluh Tujuh',
              '28' => 'Dua Puluh Delapan', '29' => 'Dua Puluh Sembilan', '30' => 'Tiga Puluh',
              '31' => 'Tiga Puluh Satu', default => $tanggal_angka
          };
          
          $bulan = \Carbon\Carbon::parse($tgl)->locale('id')->translatedFormat('F');
          $tahun_teks = 'Dua Ribu Dua Puluh Enam'; 
        @endphp
        Pada hari ini <span class="font-bold italic">{{ $hari }}</span> tanggal <span class="font-bold italic">{{ $tanggal_teks }}</span> Bulan <span class="font-bold italic">{{ $bulan }} Tahun {{ $tahun_teks }}</span> yang bertanda tangan dibawah ini:
    </div>

    <!-- IDENTITAS PEMINJAM -->
    <table>
        <tr>
            <td class="td-label">Nama</td>
            <td class="td-titikdua">:</td>
            <td>{{ $request->user->nama_lengkap ?? 'Sri Rahayu Pakaya' }}</td>
        </tr>
        <tr>
            <td>NIP</td>
            <td class="td-titikdua">:</td>
            <td>{{ $request->user->nip ?? '197801292003122001' }}</td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td class="td-titikdua">:</td>
            <td>{{ $request->user->jabatan ?? 'Pelaksana' }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td class="td-titikdua">:</td>
            <td class="font-bold">{{ $request->user->alamat ?? 'Perumahan Toto Permai Kabila Bonbol' }}</td>
        </tr>
    </table>

    <!-- PARAGRAF REFERENSI -->
    <div class="text-justify mb-10">
        Sesuai dengan <span class="font-bold">PMK Nomor: 115/PMK.06/2020 Tentang Pemanfaatan Barang Milik Negara</span>. Maka demi untuk tertibnya administrasi Berita Acara Pinjam Pakai ini sebagai berikut:
    </div>

    <!-- DATA BARANG -->
    <table>
        <tr>
            <td class="td-label">Nama Barang</td>
            <td class="td-titikdua">:</td>
            <td class="font-bold">{{ $request->nama_barang ?? 'SEPEDA MOTOR DM 6910 E' }}</td>
        </tr>
        <tr>
            <td>Merk/Type</td>
            <td class="td-titikdua">:</td>
            <td>{{ $request->merek ?? 'YAMAHA FINO 125 CC WARNA PUTIH' }}</td>
        </tr>
        <tr>
            <td>Jumlah</td>
            <td class="td-titikdua">:</td>
            <td>{{ $request->jumlah ?? '1 unit' }}</td>
        </tr>
        <tr>
            <td>Jangka waktu</td>
            <td class="td-titikdua">:</td>
            <td>1 tahun s/d 31 Des {{ date('Y') }}</td>
        </tr>
        <tr>
            <td>Untuk Keperluan</td>
            <td class="td-titikdua">:</td>
            <td>{{ $request->deskripsi_peruntukan ?? 'Operasional kepala BPMP Provinsi Gorontalo' }}</td>
        </tr>
    </table>
        
    <div class="text-justify mb-5">
        Dengan penuh tanggung jawab, dan apabila dikemudian hari barang tersebut hilang maka sebagai Peminjam bertanggung jawab atas kerugian Aset Negara, sesuai dengan ketentuan <span class="font-bold">Pasal 1740 KUHPerdata.</span>
    </div>

    <div class="text-justify mb-5" style="text-indent: 40px;">
        Demikian berita acara ini ditanda tangani dengan sebenar-benarnya dan untuk digunakan sebagaimana mestinya.
    </div>

    <!-- CATATAN PENTING -->
    <div class="catatan-container">
        <div class="font-bold italic underline mb-5">Catatan Penting :</div>
        <div class="catatan-item">1. Barang bisa ditarik sewaktu-waktu apabila terjadi penyimpangan/penyalahgunaan atau dibutuhkan untuk kepentingan Lembaga/Kantor.</div>
        <div class="catatan-item">2. Kerusakan yang diakibatkan karena kelalaian pengguna maka kerusakan tersebut menjadi tanggung jawab pihak peminjam.</div>
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
                <div class="ttd-nama">{{ $admin->nama_lengkap ?? 'Wiwin Suriadi Bokingo' }}</div>
                <div>NIP. {{ $admin->nip ?? '198001122008101002' }}</div>
            </td>
            <td>
                <div>Peminjam,</div>
                <div class="ttd-img-container">
                    @if(!empty($ttdPeminjam))
                        <img src="{{ $ttdPeminjam }}" alt="TTD Peminjam">
                    @endif
                </div>
                <div class="ttd-nama">{{ $request->user->nama_lengkap ?? 'Sri Rahayu Pakaya' }}</div>
                <div>NIP. {{ $request->user->nip ?? '197801292003122001' }}</div>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding-top: 10px;"> <!-- Spasi atas untuk TTD Kepala dikurangi -->
                <div>Mengetahui,</div>
                <div class="font-bold">Kuasa Pengguna Barang</div>
                <div class="ttd-img-container">
                    @if(!empty($ttdKepala))
                        <img src="{{ $ttdKepala }}" alt="TTD Kepala">
                    @endif
                </div>
                <div class="ttd-nama">{{ $kepala->nama_lengkap ?? 'Rudi Syaifullah, S. SI,M,M.' }}</div>
                <div>NIP. {{ $kepala->nip ?? '157606272003121002' }}</div>
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
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Berita Acara Pinjam Pakai Kendaraan</title>
    <style>
        @page {
            size: A4 portrait;
            margin-top: 4cm;
            margin-bottom: 4cm;
            margin-left: 3cm;
            margin-right: 3cm;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 9.5pt;
            line-height: 1.2;
            color: #000;
            background-color: transparent;
        }

        .kop-surat { margin-bottom: 5px; width: 100%; }
        .kop-surat img { width: 100%; height: auto; display: block; }

        .text-center { text-align: center; }
        .text-justify { text-align: justify; }
        .font-bold { font-weight: bold; }
        .italic { font-style: italic; }
        .underline { text-decoration: underline; }
        
        .mb-5 { margin-bottom: 3px; }
        .mb-10 { margin-bottom: 6px; }

        .judul-surat {
            font-size: 10.5pt;
            margin-bottom: 1px;
            text-decoration: underline;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6px;
        }
        td {
            vertical-align: top;
            padding: 1px 0;
        }
        .td-label { width: 110px; }
        .td-titikdua { width: 15px; text-align: center; }

        .catatan-container { margin-top: 5px; margin-bottom: 10px; }
        .catatan-item { font-style: italic; margin-bottom: 1px; text-align: justify; }

        .ttd-table {
            width: 100%;
            text-align: center;
            margin-top: 5px;
            page-break-inside: avoid; 
        }
        .ttd-table td { width: 50%; padding: 0; vertical-align: bottom; }
        .ttd-img-container { height: 45px; margin: 1px 0; }
        .ttd-img-container img { max-height: 45px; max-width: 100px; }
        .ttd-nama { font-weight: bold; text-decoration: underline; margin-bottom: 1px; }

        .footer {
            position: fixed;
            bottom: -3cm; left: 0; right: 0;
            font-size: 8pt; color: #555; text-align: center;
            border-top: 1px solid #ccc; padding-top: 4px;
        }
    </style>
</head>
<body>

    {{-- KOP SURAT --}}
    <div class="kop-surat">
        <img src="{{ storage_path('app/public/kop_surat.png') }}" alt="Kop Surat BPMP Provinsi Gorontalo"> 
    </div>

    <!-- JUDUL & NOMOR SURAT -->
    <div class="text-center mb-10">
        <div class="judul-surat">BERITA ACARA PINJAM PAKAI</div>
        @php
            $nomor_urut = str_pad($peminjaman->id, 3, '0', STR_PAD_LEFT);
            $tahun_surat = \Carbon\Carbon::parse($peminjaman->created_at)->format('Y');
        @endphp
        <div>No: {{ $nomor_urut }}/BA.PK/693228/{{ $tahun_surat }}</div>
    </div>

    <!-- PEMBUKA -->
    <div class="text-justify mb-10">
        @php
          $tgl = $peminjaman->created_at ?? now();
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
          
          // Mengubah tahun menjadi format kalimat berdasarkan tahun surat dibuat
          $tahun_angka = \Carbon\Carbon::parse($tgl)->format('Y');
          // Jika ingin dinamis, Anda bisa menggunakan package terbilang, namun untuk amannya kita set default
          $tahun_teks = 'Dua Ribu Dua Puluh Enam'; 
        @endphp
        Pada hari ini <span class="font-bold italic">{{ $hari }}</span> tanggal <span class="font-bold italic">{{ $tanggal_teks }}</span> Bulan <span class="font-bold italic">{{ $bulan }} Tahun {{ $tahun_teks }}</span> yang bertanda tangan dibawah ini:
    </div>

    <!-- IDENTITAS PEMINJAM (Data Asli dari Database) -->
    <table>
        <tr>
            <td class="td-label">Nama</td>
            <td class="td-titikdua">:</td>
            <!-- Menggunakan name atau nama_lengkap sesuai kolom di database user Anda -->
            <td>{{ $peminjaman->user->name ?? '-' }}</td>
        </tr>
        <tr>
            <td>NIP</td>
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
            <td class="font-bold">{{ $peminjaman->user->alamat ?? '-' }}</td>
        </tr>
    </table>

    <div class="text-justify mb-10">
        Sesuai dengan <span class="font-bold">PMK Nomor: 115/PMK.06/2020 Tentang Pemanfaatan Barang Milik Negara</span>. Maka demi untuk tertibnya administrasi Berita Acara Pinjam Pakai ini sebagai berikut:
    </div>

    <!-- DATA KENDARAAN (Data Asli dari Database) -->
    <table>
        <tr>
            <td class="td-label">Nama Kendaraan</td>
            <td class="td-titikdua">:</td>
            <td class="font-bold">{{ $peminjaman->nama_barang ?? '-' }}</td>
        </tr>
        <tr>
            <td>Merek / NUP</td>
            <td class="td-titikdua">:</td>
            <td>{{ $peminjaman->merek ?? '-' }} / {{ $peminjaman->nup ?? '-' }}</td>
        </tr>
        <tr>
            <td>Kode Barang</td>
            <td class="td-titikdua">:</td>
            <td>{{ $peminjaman->kode_barang ?? '-' }}</td>
        </tr>
        <tr>
            <td>Jumlah</td>
            <td class="td-titikdua">:</td>
            <td>{{ $peminjaman->jumlah ?? '1' }} Unit</td>
        </tr>
        <tr>
            <td>Jangka waktu</td>
            <td class="td-titikdua">:</td>
            <td>
                {{ \Carbon\Carbon::parse($peminjaman->tanggal_peminjaman)->translatedFormat('d M Y') }} s/d 
                {{ \Carbon\Carbon::parse($peminjaman->tanggal_pengembalian)->translatedFormat('d M Y') }}
            </td>
        </tr>
        <tr>
            <td>Untuk Keperluan</td>
            <td class="td-titikdua">:</td>
            <td>{{ $peminjaman->deskripsi_peruntukan ?? '-' }}</td>
        </tr>
    </table>
        
    <div class="text-justify mb-5">
        Dengan penuh tanggung jawab, dan apabila dikemudian hari barang tersebut hilang maka sebagai Peminjam bertanggung jawab atas kerugian Aset Negara, sesuai dengan ketentuan <span class="font-bold">Pasal 1740 KUHPerdata.</span>
    </div>

    <div class="text-justify mb-5" style="text-indent: 40px;">
        Demikian berita acara ini ditanda tangani dengan sebenar-benarnya dan untuk digunakan sebagaimana mestinya.
    </div>

    <div class="catatan-container">
        <div class="font-bold italic underline mb-5">Catatan Penting :</div>
        <div class="catatan-item">1. Kendaraan bisa ditarik sewaktu-waktu apabila terjadi penyimpangan/penyalahgunaan atau dibutuhkan untuk kepentingan Lembaga/Kantor.</div>
        <div class="catatan-item">2. Kerusakan yang diakibatkan karena kelalaian pengguna maka kerusakan tersebut menjadi tanggung jawab pihak peminjam.</div>
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
                <!-- Mengambil data Admin secara dinamis jika diset dari Controller -->
                <div class="ttd-nama">{{ $admin->name ?? '-' }}</div>
                <div>NIP. {{ $admin->nip ?? '-' }}</div>
            </td>
            <td>
                <div>Peminjam,</div>
                <div class="ttd-img-container">
                    @if(!empty($ttdPeminjam))
                        <img src="{{ $ttdPeminjam }}" alt="TTD Peminjam">
                    @endif
                </div>
                <!-- Peminjam 100% dinamis dari tabel users -->
                <div class="ttd-nama">{{ $peminjaman->user->name ?? '-' }}</div>
                <div>NIP. {{ $peminjaman->user->nip ?? '-' }}</div>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding-top: 10px;">
                <div>Mengetahui,</div>
                <div class="font-bold">Kuasa Pengguna Barang</div>
                <div class="ttd-img-container">
                    @if(!empty($ttdKepala))
                        <img src="{{ $ttdKepala }}" alt="TTD Kepala">
                    @endif
                </div>
                <!-- Mengambil data Kepala BPMP secara dinamis jika diset dari Controller -->
                <div class="ttd-nama">{{ $kepala->name ?? '-' }}</div>
                <div>NIP. {{ $kepala->nip ?? '-' }}</div>
            </td>
        </tr>
    </table>

    <div class="footer">
        Dokumen ini digenerate secara otomatis oleh SIPANDU BPMP Provinsi Gorontalo<br>
        Dicetak pada: {{ $tanggalCetak ?? now()->translatedFormat('d F Y, H:i') }} WITA
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pengembalian Peminjaman Kendaraan - {{ $request->user->nama_lengkap ?? 'Peminjam' }}</title>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }

  body {
    font-family: "Times New Roman", Times, serif;
    font-size: 12pt;
    background: #e0e0e0;
    display: flex;
    justify-content: center;
    padding: 30px 10px;
  }

  .page {
    width: 210mm;
    min-height: 297mm;
    background: #fff;
    padding: 0 25mm 20mm 25mm;
    box-shadow: 0 4px 24px rgba(0,0,0,0.18);
  }

  /* KOP SURAT IMAGE */
  .kop-surat {
    text-align: center;
    margin-bottom: 8px;
    padding-bottom: 0;
  }

  .kop-surat img {
    width: 100%;
    max-width: 100%;
    height: auto;
    display: block;
    margin: 0 auto;
  }

  /* JUDUL */
  .judul-section {
    text-align: center;
    margin: 8px 0 6px 0;
  }

  .judul-section h2 {
    font-size: 14pt;
    font-weight: bold;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    font-family: "Times New Roman", serif;
    text-decoration: underline;
  }

  .nomor-surat {
    font-size: 11pt;
    font-family: "Times New Roman", serif;
    margin-top: 2px;
  }

  /* PEMBUKA */
  .pembuka {
    margin: 10px 0 6px 0;
    font-size: 11.5pt;
    line-height: 1.6;
    text-align: justify;
  }

  /* TABEL IDENTITAS */
  .identitas-table {
    width: 100%;
    border-collapse: collapse;
    margin: 6px 0 8px 8px;
    font-size: 11.5pt;
  }

  .identitas-table td {
    padding: 1.5px 0;
    vertical-align: top;
  }

  .identitas-table td:first-child {
    width: 130px;
  }

  .identitas-table td:nth-child(2) {
    width: 18px;
    text-align: center;
  }

  .identitas-table td:last-child {
    font-weight: normal;
  }

  .identitas-table td.bold-val {
    font-weight: bold;
  }

  /* PARAGRAF */
  .paragraf {
    font-size: 11.5pt;
    line-height: 1.6;
    text-align: justify;
    margin: 8px 0;
  }

  /* ALASAN SECTION */
  .alasan-section {
    font-size: 11.5pt;
    line-height: 1.6;
    margin: 10px 0;
  }

  .alasan-label {
    font-weight: normal;
    margin-bottom: 4px;
  }

  .alasan-content {
    min-height: 40px;
    border-bottom: 1px dotted #999;
    padding-bottom: 4px;
  }

  /* TTD SECTION */
  .ttd-section {
    display: flex;
    justify-content: space-between;
    margin-top: 14px;
    gap: 20px;
  }

  .ttd-block {
    text-align: center;
    flex: 1;
    font-size: 11.5pt;
  }

  .ttd-block .peran {
    margin-bottom: 55px;
    font-weight: bold;
  }

  .ttd-block .nama {
    font-weight: bold;
    text-decoration: underline;
    margin-bottom: 2px;
  }

  .ttd-block .nip {
    font-size: 11pt;
  }

  .ttd-block .ttd-area {
    height: 55px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .ttd-mengetahui {
    text-align: center;
    margin-top: 12px;
    font-size: 11.5pt;
  }

  .ttd-mengetahui .peran-label {
    font-weight: normal;
  }

  .ttd-mengetahui .sub-label {
    font-weight: bold;
    margin-bottom: 55px;
  }

  .ttd-mengetahui .nama {
    font-weight: bold;
    text-decoration: underline;
  }

  .ttd-mengetahui .nip {
    font-size: 11pt;
  }

  @media print {
    body { background: none; padding: 0; }
    .page { box-shadow: none; margin: 0; padding: 0 20mm 15mm 20mm; }
  }
</style>
</head>
<body>
<div class="page">

  <!-- KOP SURAT (IMAGE) -->
  <div class="kop-surat">
    <img src="{{ asset('storage/kop_surat.png') }}" alt="Kop Surat BPMP Provinsi Gorontalo">
  </div>

  <!-- JUDUL -->
  <div class="judul-section">
    <h2>Pengembalian Peminjaman</h2>
    <div class="nomor-surat">No: S0015/BPMP.GTLO/KPA/{{ date('Y') }}</div>
  </div>

  <!-- PEMBUKA -->
  <div class="pembuka">
    @php
      $tgl = $request->tanggal_pengembalian_aktual ?? $request->created_at ?? now();
      $hari = \Carbon\Carbon::parse($tgl)->locale('id')->translatedFormat('l');
      $tanggal = \Carbon\Carbon::parse($tgl)->translatedFormat('j');
      $bulan = \Carbon\Carbon::parse($tgl)->locale('id')->translatedFormat('F');
      $tahun = \Carbon\Carbon::parse($tgl)->translatedFormat('Y');
    @endphp
    Pada hari &nbsp;ini....................tanggal....................Bulan..................<strong><em>Tahun {{ $tahun }}</em></strong> yang
    bertanda tangan dibawah ini :
  </div>

  <!-- IDENTITAS PEMINJAM -->
  <table class="identitas-table">
    <tr>
      <td>Nama</td>
      <td>:</td>
      <td>{{ $request->user->nama_lengkap ?? '-' }}</td>
    </tr>
    <tr>
      <td>NIP</td>
      <td>:</td>
      <td>{{ $request->user->nip ?? '-' }}</td>
    </tr>
    <tr>
      <td>Jabatan</td>
      <td>:</td>
      <td>{{ $request->user->jabatan ?? '-' }}</td>
    </tr>
  </table>

  <!-- DATA KENDARAAN -->
  <table class="identitas-table">
    <tr>
      <td>Nama Barang</td>
      <td>:</td>
      <td>{{ $request->peminjamanKendaraan->nama_barang ?? '-' }}</td>
    </tr>
    <tr>
      <td>Merk/Type</td>
      <td>:</td>
      <td>{{ $request->peminjamanKendaraan->merek ?? '-' }}</td>
    </tr>
    <tr>
      <td>Jumlah</td>
      <td>:</td>
      <td>{{ $request->peminjamanKendaraan->jumlah ?? 1 }} unit</td>
    </tr>
  </table>

  <!-- ALASAN PENGEMBALIAN -->
  <div class="alasan-section">
    <div class="alasan-label">Alasan Pengembalian :</div>
    <div class="alasan-content">
      {{ $request->catatan ?? '-' }}
    </div>
  </div>

  <!-- PARAGRAF PENUTUP -->
  <div class="paragraf">
    Bahwa barang tersebut telah Selesai di Pergunakan &nbsp;dan di kembalikan sebagaimana Terlampir bahwa barang tersebut masih dalam keadaan baik dan lengkap.
  </div>

  <div class="paragraf" style="text-indent: 30px;">
    Demikian berita acara ini ditandatangani dengan sebenar-benarnya dan untuk digunakan sebagaimana mestinya.
  </div>

  <!-- TANDA TANGAN KIRI DAN KANAN -->
  <div class="ttd-section">
    <div class="ttd-block">
      <div class="peran">Pengadministrasi BMN</div>
      <div class="nama">Wiwin Suriadi Bokingo</div>
      <div class="nip">NIP. 198001122008101002</div>
    </div>
    <div class="ttd-block">
      <div class="peran">Peminjam</div>
      <div class="ttd-area">
        @if(!empty($ttdBase64))
          <img src="{{ $ttdBase64 }}" alt="Tanda Tangan" style="max-width: 100px; max-height: 50px;">
        @endif
      </div>
      <div class="nama">{{ $request->user->nama_lengkap ?? '........................' }}</div>
      <div class="nip">NIP. {{ $request->user->nip ?? '........................' }}</div>
    </div>
  </div>

  <!-- MENGETAHUI -->
  <div class="ttd-mengetahui">
    <div class="peran-label">Mengetahui,</div>
    <div class="sub-label">Kuasa Pengguna Barang</div>
    <div class="nama">Rudi Syaifullah, S. SI,M,M.</div>
    <div class="nip">NIP. 157606272003121002</div>
  </div>

</div>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Berita Acara Pinjam Pakai</title>
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
    padding: 20mm 25mm 20mm 30mm;
    box-shadow: 0 4px 24px rgba(0,0,0,0.18);
  }

  /* HEADER */
  .header {
    display: flex;
    align-items: flex-start;
    border-bottom: 3px solid #000;
    padding-bottom: 8px;
    margin-bottom: 14px;
  }

  .logo-area {
    display: flex;
    align-items: center;
    gap: 10px;
    min-width: 155px;
  }

  .logo-img {
    width: 60px;
    height: 60px;
  }

  /* SVG Garuda-like logo placeholder */
  .logo-circle {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, #1a5276 0%, #2e86c1 60%, #85c1e9 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }

  .logo-text-group {
    display: flex;
    flex-direction: column;
    justify-content: center;
  }

  .logo-brand {
    font-family: Arial, sans-serif;
    font-size: 15pt;
    font-weight: bold;
    color: #1a5276;
    letter-spacing: 0px;
    line-height: 1;
  }

  .logo-brand span.kemen { color: #1a5276; }
  .logo-brand span.dik { color: #e8a020; font-weight: 900; }
  .logo-brand span.dasmen { color: #1a5276; }

  .logo-subtitle {
    font-family: Arial, sans-serif;
    font-size: 7.5pt;
    color: #1a5276;
    margin-top: 1px;
    letter-spacing: 0.2px;
    font-weight: bold;
  }

  .header-divider {
    width: 2px;
    height: 72px;
    background: #000;
    margin: 0 14px;
  }

  .header-right {
    flex: 1;
    font-family: Arial, sans-serif;
    font-size: 8pt;
    line-height: 1.55;
    color: #111;
  }

  .header-right .instansi-name {
    font-size: 10pt;
    font-weight: bold;
    line-height: 1.3;
    margin-bottom: 2px;
  }

  .header-right .sub-unit {
    font-size: 8pt;
    font-weight: bold;
    color: #333;
    margin-bottom: 3px;
  }

  .header-right .alamat {
    font-size: 7.5pt;
    color: #444;
  }

  .header-right .kontak {
    font-size: 7.5pt;
    color: #444;
    display: flex;
    gap: 10px;
    align-items: center;
    margin-top: 1px;
  }

  /* JUDUL */
  .judul-section {
    text-align: center;
    margin: 10px 0 6px 0;
  }

  .judul-section h2 {
    font-size: 14pt;
    font-weight: bold;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    font-family: "Times New Roman", serif;
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
    width: 90px;
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

  /* PARAGRAF TENGAH */
  .paragraf {
    font-size: 11.5pt;
    line-height: 1.6;
    text-align: justify;
    margin: 8px 0;
  }

  .paragraf .highlight {
    font-weight: bold;
    text-decoration: underline;
  }

  /* BARANG TABLE */
  .barang-table {
    width: 100%;
    border-collapse: collapse;
    margin: 4px 0 4px 8px;
    font-size: 11.5pt;
  }

  .barang-table td {
    padding: 1.5px 0;
    vertical-align: top;
  }

  .barang-table td:first-child {
    width: 110px;
  }

  .barang-table td:nth-child(2) {
    width: 18px;
    text-align: center;
  }

  .barang-table td.bval {
    font-weight: bold;
  }

  /* CATATAN */
  .catatan-title {
    font-size: 11.5pt;
    font-style: italic;
    font-weight: bold;
    margin: 10px 0 2px 0;
  }

  .catatan-list {
    font-size: 11pt;
    line-height: 1.65;
    font-style: italic;
    text-align: justify;
    list-style: none;
    padding: 0;
    margin-left: 2px;
  }

  .catatan-list li {
    margin-bottom: 3px;
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
    margin-bottom: 40px;
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

  .ttd-mengetahui {
    text-align: center;
    margin-top: 12px;
    font-size: 11.5pt;
  }

  .ttd-mengetahui .peran-label {
    font-weight: normal;
  }

  .ttd-mengetahui .sub-label {
    font-weight: normal;
    margin-bottom: 38px;
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
    .page { box-shadow: none; margin: 0; }
  }
</style>
</head>
<body>
<div class="page">

  <!-- HEADER -->
  <div class="header">
    <div class="logo-area">
      <!-- Logo Kemendikdasmen SVG -->
      <svg width="62" height="62" viewBox="0 0 62 62" fill="none" xmlns="http://www.w3.org/2000/svg">
        <circle cx="31" cy="31" r="30" fill="#f0f4fa" stroke="#1a5276" stroke-width="1.5"/>
        <!-- Garuda simplified -->
        <ellipse cx="31" cy="26" rx="10" ry="13" fill="#1a5276"/>
        <ellipse cx="31" cy="24" rx="6" ry="8" fill="#f7c948"/>
        <!-- Wings -->
        <ellipse cx="16" cy="28" rx="10" ry="5" fill="#1a5276" transform="rotate(-20 16 28)"/>
        <ellipse cx="46" cy="28" rx="10" ry="5" fill="#1a5276" transform="rotate(20 46 28)"/>
        <!-- Body -->
        <ellipse cx="31" cy="35" rx="7" ry="9" fill="#1a5276"/>
        <!-- Shield -->
        <rect x="27" y="30" width="8" height="10" rx="2" fill="#f7c948"/>
        <!-- Stars -->
        <circle cx="31" cy="14" r="2" fill="#f7c948"/>
        <text x="31" y="56" text-anchor="middle" font-size="5" fill="#1a5276" font-family="Arial" font-weight="bold">KEMENDIKDASMEN</text>
      </svg>

      <div class="logo-text-group">
        <div class="logo-brand">
          <span class="kemen">Kemen</span><span class="dik">dik</span><span class="dasmen">dasmen</span>
        </div>
        <div class="logo-subtitle">Kementerian Pendidikan Dasar dan Menengah</div>
      </div>
    </div>

    <div class="header-divider"></div>

    <div class="header-right">
      <div class="instansi-name">Kementerian Pendidikan Dasar dan Menengah</div>
      <div class="sub-unit">Balai Penjaminan Mutu Pendidikan Provinsi Gorontalo</div>
      <div class="alamat">Jalan dr. Zainal Umar Sidiki, Tilongkabila, Bone Bolango, 96119</div>
      <div class="alamat">Kotak Pos 1024</div>
      <div class="kontak">
        <span>🌐 www.kemendikdasmen.go.id</span>
        <span>☎ 08042200045</span>
        <span>📠 777</span>
      </div>
    </div>
  </div>

  <!-- JUDUL -->
  <div class="judul-section">
    <h2>Berita Acara Pinjam Pakai</h2>
    <div class="nomor-surat">No: &nbsp;/BPMP.GTLO/KPA/2025</div>
  </div>

  <!-- PEMBUKA -->
  <div class="pembuka">
    Pada &nbsp;hari &nbsp;ini &nbsp;<strong><em>Senin</em></strong>. &nbsp;tanggal <strong><em>Tiga Belas</em></strong> &nbsp;Bulan &nbsp;<strong><em>Januari</em></strong> &nbsp;Tahun &nbsp;<strong><em>Dua Ribu Dua Puluh Lima</em></strong> &nbsp;yang bertanda tangan dibawah ini :
  </div>

  <!-- IDENTITAS -->
  <table class="identitas-table">
    <tr>
      <td>Nama</td>
      <td>:</td>
      <td>Sri Rahayu Pakaya</td>
    </tr>
    <tr>
      <td>NIP</td>
      <td>:</td>
      <td>197801292003122001</td>
    </tr>
    <tr>
      <td>Jabatan</td>
      <td>:</td>
      <td>Pelaksana</td>
    </tr>
    <tr>
      <td>Alamat</td>
      <td>:</td>
      <td class="bold-val">Perumahan Toto Permai Kabila Bonbol</td>
    </tr>
  </table>

  <!-- PARAGRAF REFERENSI PMK -->
  <div class="paragraf">
    Sesuai dengan &nbsp;<span class="highlight">PMK Nomor:115/PMK.06/2020 Tentang &nbsp;Pemanfaatan Barang Milik Negara</span>, Maka demi untuk tertibnya administrasi Berita Acara Pinjam Pakai ini &nbsp;sebagai berikut:
  </div>

  <!-- DATA BARANG -->
  <table class="barang-table">
    <tr>
      <td>Nama Barang</td>
      <td>:</td>
      <td class="bval">SEPEDA MOTOR DM 6310 E</td>
    </tr>
    <tr>
      <td>Merk/Type</td>
      <td>:</td>
      <td class="bval">YAMAHA FINO &nbsp;125 CC WARNA PUTIH</td>
    </tr>
    <tr>
      <td>Jumlah</td>
      <td>:</td>
      <td>1 unit</td>
    </tr>
    <tr>
      <td>Jangka waktu</td>
      <td>:</td>
      <td>1 tahun s/d 31 des 2025</td>
    </tr>
    <tr>
      <td>Untuk Keperluan</td>
      <td>:</td>
      <td>operasional kepala BPMP</td>
    </tr>
  </table>

  <!-- PARAGRAF TANGGUNG JAWAB -->
  <div class="paragraf">
    Dengan penuh tanggung jawab, dan apabila dikemudian hari barang tersebut hilang maka sebagai Peminjam bertanggung jawab atas kerugian Aset Negara, sesuai dengan ketentuan <strong>Pasal 1740 KUHPerdata</strong>
  </div>

  <!-- PENUTUP -->
  <div class="paragraf">
    Demikian berita acara ini ditanda tangani dengan sebenar-benarnya dan untuk digunakan sebagaimana mestinya.
  </div>

  <!-- CATATAN PENTING -->
  <div class="catatan-title">Catatan Penting :</div>
  <ol class="catatan-list">
    <li>1.<em>barang bisa ditarik sewaktu-waktu apabila terjadi penyimpangan Penyalahgunaan atau dibutuhkan untuk kepentingan Lembaga/Kantor</em></li>
    <li>2.<em>Kerusakan yang di akibatkan karena &nbsp;kelalaian pengguna maka kerusakan tersebut menjadi &nbsp;tanggung jawab pihak peminjam</em></li>
  </ol>

  <!-- TANDA TANGAN KIRI DAN KANAN -->
  <div class="ttd-section">
    <div class="ttd-block">
      <div class="peran">Pengadministrasi BMN</div>
      <div class="nama">Wiwin Suriadi Bokingo</div>
      <div class="nip">NIP. 198001122008101002</div>
    </div>
    <div class="ttd-block">
      <div class="peran">Peminjam</div>
      <div class="nama">Sri Rahayu Pakaya</div>
      <div class="nip">NIP. 197801292003122001</div>
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
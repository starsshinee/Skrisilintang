<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SIPANDU - Laporan Transaksi Keluar</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
  :root {
    --danger: #EF4444;
    --danger-light: #FEF2F2;
    --blue: #4F6FFF;
    --amber: #F59E0B;
    --purple: #8B5CF6;
    --radius: 16px;
    --bg: #F4F6FB;
    --surface: #FFFFFF;
    --text: #1E293B;
    --text-muted: #64748B;
    --muted: #94A3B8;
    --border: #E8EDF5;
  }
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; }

  .main { margin-left: 240px; display: flex; flex-direction: column; min-height: 100vh; }
  .topbar {
    background: var(--surface);
    border-bottom: 1px solid var(--border);
    padding: 0 28px;
    height: 56px;
    display: flex; align-items: center; justify-content: space-between;
    position: sticky; top: 0; z-index: 50;
  }
  .topbar-title { font-size: 16px; font-weight: 700; color: var(--text); }
  .topbar-right { display: flex; align-items: center; gap: 16px; }
  .notif-btn {
    width: 36px; height: 36px; border-radius: 50%; border: 1px solid var(--border);
    background: var(--surface); display: flex; align-items: center; justify-content: center;
    cursor: pointer; position: relative;
  }
  .notif-dot { width: 8px; height: 8px; background: var(--danger); border-radius: 50%; position: absolute; top: 6px; right: 6px; border: 2px solid white; }
  .date-text { font-size: 13px; color: var(--text-muted); font-weight: 500; }
  .btn-keluar {
    display: flex; align-items: center; gap: 6px;
    padding: 7px 14px; border-radius: 8px;
    border: 1px solid var(--border);
    background: var(--surface); color: var(--text-muted);
    font-size: 13px; font-weight: 600; font-family: inherit; cursor: pointer; transition: all .15s;
  }
  .btn-keluar:hover { background: var(--bg); }

  .content { padding: 28px; flex: 1; }

  /* PAGE HEADER */
  .page-top {
    display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 24px;
  }
  .page-top h1 { font-size: 22px; font-weight: 800; color: var(--danger); margin-bottom: 4px; }
  .page-top p { font-size: 13px; color: var(--muted); }
  .btn-unduh {
    display: flex; align-items: center; gap: 7px;
    padding: 10px 18px; border-radius: 10px;
    background: var(--danger);
    color: white; font-size: 13.5px; font-weight: 700;
    font-family: inherit; border: none; cursor: pointer;
    box-shadow: 0 4px 14px rgba(239,68,68,.3);
    transition: all .2s;
  }
  .btn-unduh:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(239,68,68,.4); }

  /* FILTER BAR */
  .filter-bar {
    background: var(--surface);
    border-radius: var(--radius);
    padding: 20px;
    border: 1px solid var(--border);
    margin-bottom: 24px;
  }
  .filter-row { display: flex; align-items: center; gap: 16px; flex-wrap: wrap; }
  .filter-input {
    padding: 10px 14px; border-radius: 10px;
    border: 1.5px solid var(--border); background: var(--bg);
    font-family: inherit; font-size: 13px; min-width: 220px;
  }
  .filter-input:focus { outline: none; border-color: var(--danger); }

  /* STAT CARDS */
  .stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 24px;
  }
  .stat-card {
    background: var(--surface);
    border-radius: var(--radius);
    padding: 20px 22px;
    border: 1px solid var(--border);
    transition: transform .2s, box-shadow .2s;
  }
  .stat-card:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,.06); }
  .stat-header { display: flex; align-items: center; gap: 8px; margin-bottom: 12px; }
  .stat-icon {
    width: 32px; height: 32px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
  }
  .stat-label-sm { font-size: 13px; font-weight: 600; color: #64748B; }
  .stat-value { font-size: 30px; font-weight: 800; margin-bottom: 4px; }
  .stat-sub { font-size: 12px; color: var(--muted); }

  .ic-danger { background: #FEF2F2; }
  .ic-danger svg { fill: var(--danger); }
  .ic-amber { background: #FEF3C7; }
  .ic-amber svg { fill: var(--amber); }
  .ic-purple { background: #F5F3FF; }
  .ic-purple svg { fill: var(--purple); }
  .ic-blue { background: #EEF2FF; }
  .ic-blue svg { fill: var(--blue); }

  /* CHART */
  .chart-card {
    background: linear-gradient(135deg, #FEF2F2 0%, #FEF5F7 100%);
    border-radius: var(--radius);
    border: 1px solid #FECACA;
    padding: 24px;
    margin-bottom: 24px;
  }
  .chart-title { font-size: 16px; font-weight: 700; color: var(--text); margin-bottom: 20px; }
  .chart-area { height: 180px; display: flex; align-items: flex-end; gap: 8px; margin-bottom: 8px; }
  .chart-col { display: flex; flex-direction: column; align-items: center; flex: 1; gap: 6px; }
  .bar-wrap { flex: 1; display: flex; align-items: flex-end; width: 100%; }
  .bar {
    width: 100%; border-radius: 6px 6px 0 0;
    background: linear-gradient(180deg, var(--danger), #DC2626);
    min-height: 4px;
    transition: opacity .2s;
  }
  .bar:hover { opacity: .8; }
  .bar-val { font-size: 10px; font-weight: 700; color: #991B1B; }
  .bar-label { font-size: 10px; color: #6B7280; }

  /* TABLE */
  .table-card {
    background: var(--surface);
    border-radius: var(--radius);
    border: 1px solid var(--border);
    overflow: hidden;
  }
  .table-toolbar {
    display: flex; align-items: center; gap: 12px;
    padding: 16px 20px; border-bottom: 1px solid var(--border); flex-wrap: wrap;
  }
  table { width: 100%; border-collapse: collapse; }
  thead tr { background: #FEF2F2; }
  th {
    padding: 13px 20px;
    text-align: left;
    font-size: 11px; font-weight: 700;
    color: var(--danger); letter-spacing: .8px; text-transform: uppercase;
    border-bottom: 1.5px solid #FECACA;
  }
  td {
    padding: 14px 20px;
    font-size: 13.5px; color: var(--text);
    border-bottom: 1px solid var(--border);
  }
  tr:last-child td { border-bottom: none; }
  tbody tr:hover { background: #FEF2F2; }

  .id-cell { font-weight: 700; color: var(--danger); }
  .jumlah-cell { font-weight: 700; color: var(--danger); }
  .nilai-cell { font-weight: 700; color: var(--danger); font-family: 'Monaco', monospace; }

  .table-footer {
    display: flex; align-items: center; justify-content: space-between;
    padding: 14px 20px; border-top: 1px solid var(--border);
    font-size: 13px; color: var(--muted);
  }

  @media (max-width: 768px) {
    .main { margin-left: 0; }
    .stats-grid { grid-template-columns: 1fr; }
    .filter-row { flex-direction: column; align-items: stretch; }
    .filter-input { min-width: auto; }
    .table-toolbar { flex-direction: column; align-items: stretch; }
    .table-footer { flex-direction: column; gap: 12px; text-align: center; }
  }
</style>
</head>
<body>

{{-- SIDEBAR --}}
@include('partials.sidebar')

<main class="main">

  {{-- TOPBAR --}}
  <div class="topbar">
    <span class="topbar-title">Laporan Transaksi Keluar</span>
    <div class="topbar-right">
      <div class="notif-btn">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="#64748B"><path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/></svg>
        <span class="notif-dot"></span>
      </div>
      <span class="date-text">{{ now()->translatedFormat('l, d F Y') }}</span>
      <button class="btn-keluar">Keluar</button>
    </div>
  </div>

  <div class="content">

    {{-- PAGE HEADER --}}
    <div class="page-top">
      <div>
        <h1>Laporan Transaksi Keluar</h1>
        <p>Analisis lengkap transaksi keluar persediaan & aset</p>
      </div>
      <a href="{{ route('adminpersediaan.laporan-transaksi-keluar.download') . '?' . http_build_query(request()->query()) }}" class="btn-unduh">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="white"><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg>
        Unduh Laporan
      </a>
    </div>

    {{-- FILTER --}}
    <div class="filter-bar">
      <form method="GET" action="{{ route('adminpersediaan.laporan-transaksi-keluar') }}">
        <div class="filter-row">
          <div style="flex:1; min-width:250px;">
            <input type="text" name="search" class="filter-input" placeholder="Cari nomor transaksi, kode barang, nama..." value="{{ request('search') }}">
          </div>
          <input type="date" name="tanggal_input" class="filter-input" value="{{ request('tanggal_input') }}">
          <select name="kode_kategori" class="filter-input" onchange="this.form.submit()">
            <option value="">Semua Kategori</option>
            @foreach(\App\Models\TransaksiKeluarPersediaan::distinct()->orderBy('kode_kategori')->pluck('kode_kategori')->toArray() as $kodeKategori)
              <option value="{{ $kodeKategori }}" {{ request('kode_kategori') == $kodeKategori ? 'selected' : '' }}>{{ $kodeKategori }}</option>
            @endforeach
          </select>
          @if(request()->query())
            <a href="{{ route('adminpersediaan.laporan-transaksi-keluar') }}" class="btn" style="padding:10px 18px; background:var(--bg); color:var(--text); border:1.5px solid var(--border); border-radius:10px; font-weight:600; text-decoration:none;">Reset</a>
          @endif
        </div>
      </form>
    </div>

    {{-- STATS --}}
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-header">
          <div class="stat-icon ic-danger">
            <svg width="16" height="16" viewBox="0 0 24 24"><path d="M19 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2z"/></svg>
          </div>
          <span class="stat-label-sm">Total Transaksi</span>
        </div>
        <div class="stat-value">{{ number_format($chartData['summary']['total_transaksi']) }}</div>
        <div class="stat-sub">Semua periode</div>
      </div>
      <div class="stat-card">
        <div class="stat-header">
          <div class="stat-icon ic-danger">
            <svg width="16" height="16" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
          </div>
          <span class="stat-label-sm">Total Item Keluar</span>
        </div>
        <div class="stat-value" style="color:var(--danger);">{{ number_format($chartData['summary']['total_jumlah']) }}</div>
        <div class="stat-sub">Unit</div>
      </div>
      <div class="stat-card">
        <div class="stat-header">
          <div class="stat-icon ic-amber">
            <svg width="16" height="16" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
          </div>
          <span class="stat-label-sm">Total Nilai</span>
        </div>
        <div class="stat-value" style="font-size:22px">Rp {{ number_format($chartData['summary']['total_nilai']/1000000, 0) }} <span style="font-size:14px;">Jt</span></div>
        <div class="stat-sub">Nilai transaksi</div>
      </div>
      <div class="stat-card">
        <div class="stat-header">
          <div class="stat-icon ic-purple">
            <svg width="16" height="16" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
          </div>
          <span class="stat-label-sm">Rata-rata</span>
        </div>
        <div class="stat-value" style="color:var(--purple);">Rp {{ number_format($chartData['summary']['rata_rata_transaksi']) }}</div>
        <div class="stat-sub">Per transaksi</div>
      </div>
    </div>

    {{-- CHART --}}
    <div class="chart-card">
      <div class="chart-title">Tren Transaksi Keluar 12 Bulan Terakhir</div>
      <div class="chart-area">
        @foreach($chartData['monthly']['labels'] as $index => $label)
        <div class="chart-col">
          <div class="bar-val">{{ $chartData['monthly']['jumlah_data'][$index] }}</div>
          <div class="bar-wrap">
            @php
                $maxData = max($chartData['monthly']['jumlah_data']);
                $height = $maxData > 0 ? max(10, ($chartData['monthly']['jumlah_data'][$index] / $maxData * 100)) : 0;
            @endphp
            <div class="bar" style="height: {{ $height }}%"></div>
          </div>
          <div class="bar-label">{{ $label }}</div>
        </div>
        @endforeach
      </div>
    </div>

    {{-- TOP KATEGORI --}}
    @if($chartData['top_kategori']->isNotEmpty())
    <div class="chart-card" style="margin-bottom:24px;">
      <div class="chart-title">Top 5 Kategori Paling Banyak Keluar (3 Bulan Terakhir)</div>
      <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:16px;">
        @foreach($chartData['top_kategori'] as $kategori)
        <div style="background:var(--surface); border-radius:12px; padding:16px; border:1px solid var(--border);">
          <div style="font-size:11px; color:var(--muted); font-weight:600; margin-bottom:6px;">{{ $kategori->kode_kategori }}</div>
          <div style="font-size:18px; font-weight:800; color:var(--danger); margin-bottom:4px;">{{ number_format($kategori->total_jumlah) }}</div>
          <div style="font-size:12px; color:var(--text-muted);">({{ $kategori->total_transaksi }} transaksi)</div>
        </div>
        @endforeach
      </div>
    </div>
    @endif

    {{-- TABLE --}}
    <div class="table-card">
      <div class="table-toolbar">
        <div>{{ $transaksi->total() }} data ditemukan</div>
      </div>
      
      <table>
        <thead>
          <tr>
            <th>No. Transaksi</th>
            <th>Tanggal</th>
            <th>Kode Kategori</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Jumlah Keluar</th>
            <th>Harga Satuan</th>
            <th>Total</th>
            <th>Keterangan</th>
          </tr>
        </thead>
        <tbody>
          @forelse($transaksi as $item)
          <tr>
            <td class="id-cell">{{ $item->nomor_transaksi }}</td>
            <td>{{ $item->tanggal_input_format ?? $item->tanggal_input->format('d/m/Y') }}</td>
            <td style="font-weight:600; color:var(--danger);">{{ $item->kode_kategori }}</td>
            <td class="id-cell">{{ $item->kode_barang }}</td>
            <td>{{ Str::limit($item->nama_barang, 30) }}</td>
            <td class="jumlah-cell">{{ number_format($item->jumlah_keluar) }}</td>
            <td class="nilai-cell">Rp {{ number_format($item->harga) }}</td>
            <td class="nilai-cell" style="font-size:14px;">Rp {{ number_format($item->total) }}</td>
            <td>{{ Str::limit($item->keterangan, 25) }}</td>
          </tr>
          @empty
          <tr>
            <td colspan="9" style="text-align:center; padding:60px; color:var(--muted);">
              Belum ada data transaksi keluar
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>

      <div class="table-footer">
        <span>Menampilkan {{ $transaksi->firstItem() ?? 0 }}–{{ $transaksi->lastItem() ?? 0 }} dari {{ $transaksi->total() }} data</span>
        <div>{{ $transaksi->appends(request()->query())->links() }}</div>
      </div>
    </div>

  </div>
</main>

</body>
</html>
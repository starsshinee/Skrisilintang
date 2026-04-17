<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Laporan Mutasi Barang</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --primary: #0ea5e9;
    --primary-dark: #0284c7;
    --teal: #14b8a6;
    --teal-light: #e0f7f4;
    --teal-mid: #5eead4;
    --blue-light: #e0f2fe;
    --purple: #8b5cf6;
    --purple-light: #ede9fe;
    --green: #22c55e;
    --green-light: #dcfce7;
    --navy: #0f172a;
    --text: #1e293b;
    --text-muted: #64748b;
    --text-light: #94a3b8;
    --bg: #f0f9ff;
    --bg-card: #ffffff;
    --border: #e2e8f0;
    --shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
    --shadow-md: 0 4px 16px rgba(14,165,233,0.08);
  }

  body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: var(--bg);
    color: var(--text);
    min-height: 100vh;
  }

  /* ── HEADER ── */
  .header {
    background: var(--bg-card);
    border-bottom: 1px solid var(--border);
    padding: 0 24px;
    height: 56px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: sticky;
    top: 0;
    z-index: 100;
  }

  .header-left {
    display: flex;
    align-items: center;
    gap: 16px;
  }

  .hamburger {
    width: 20px;
    height: 14px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    cursor: pointer;
  }

  .hamburger span {
    display: block;
    height: 2px;
    background: var(--text-muted);
    border-radius: 2px;
  }

  .header-title {
    font-size: 15px;
    font-weight: 600;
    color: var(--text);
  }

  .header-right {
    display: flex;
    align-items: center;
    gap: 16px;
  }

  .notif-btn {
    position: relative;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: none;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .notif-btn svg {
    width: 22px;
    height: 22px;
    stroke: var(--text-muted);
    fill: none;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
  }

  .notif-dot {
    position: absolute;
    top: 6px;
    right: 7px;
    width: 8px;
    height: 8px;
    background: #ef4444;
    border-radius: 50%;
    border: 1.5px solid #fff;
  }

  .header-date {
    font-size: 13px;
    font-weight: 500;
    color: var(--text);
  }

  /* ── MAIN ── */
  .main {
    max-width: 900px;
    margin: 0 auto;
    padding: 28px 24px 48px;
  }

  /* ── PAGE HEADER ── */
  .page-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 24px;
    flex-wrap: wrap;
    gap: 12px;
  }

  .page-title {
    font-size: 20px;
    font-weight: 700;
    color: var(--teal);
    margin-bottom: 4px;
  }

  .page-subtitle {
    font-size: 13px;
    color: var(--text-muted);
    font-weight: 400;
  }

  .btn-download {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--primary);
    color: #fff;
    font-size: 13px;
    font-weight: 600;
    padding: 10px 20px;
    border-radius: 10px;
    border: none;
    cursor: pointer;
    transition: background .2s;
    white-space: nowrap;
    font-family: inherit;
  }

  .btn-download:hover { background: var(--primary-dark); }

  .btn-download svg {
    width: 16px;
    height: 16px;
    stroke: #fff;
    fill: none;
    stroke-width: 2.2;
    stroke-linecap: round;
    stroke-linejoin: round;
  }

  /* ── STAT CARDS ── */
  .stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
    margin-bottom: 24px;
  }

  @media (max-width: 700px) {
    .stats-grid { grid-template-columns: repeat(2, 1fr); }
  }

  .stat-card {
    background: var(--bg-card);
    border-radius: 14px;
    padding: 18px 16px 14px;
    border: 1px solid var(--border);
  }

  .stat-card-top {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 10px;
  }

  .stat-icon {
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .stat-icon svg {
    width: 20px;
    height: 20px;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
    fill: none;
  }

  .stat-label {
    font-size: 12px;
    font-weight: 500;
    color: var(--text-muted);
  }

  .stat-value {
    font-size: 30px;
    font-weight: 700;
    color: var(--text);
    line-height: 1;
    margin-bottom: 6px;
  }

  .stat-sub {
    font-size: 12px;
    color: var(--text-muted);
  }

  /* card color variants */
  .stat-card.teal .stat-icon svg { stroke: var(--teal); }
  .stat-card.green .stat-icon svg { stroke: var(--green); }
  .stat-card.blue .stat-icon svg { stroke: var(--primary); }
  .stat-card.purple .stat-icon svg { stroke: var(--purple); }

  /* ── CHART CARD ── */
  .chart-card {
    background: var(--bg-card);
    border-radius: 14px;
    border: 1px solid var(--border);
    padding: 22px 20px 16px;
    margin-bottom: 24px;
  }

  .chart-card-title {
    font-size: 15px;
    font-weight: 700;
    color: var(--text);
    margin-bottom: 18px;
  }

  .chart-wrap {
    height: 180px;
    position: relative;
  }

  /* ── SEARCH & FILTER ── */
  .search-bar {
    background: var(--bg-card);
    border-radius: 14px;
    border: 1px solid var(--border);
    padding: 14px 16px;
    display: flex;
    gap: 10px;
    margin-bottom: 24px;
    flex-wrap: wrap;
  }

  .search-input-wrap {
    flex: 1;
    min-width: 180px;
    display: flex;
    align-items: center;
    gap: 8px;
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 8px 12px;
  }

  .search-input-wrap svg {
    width: 16px;
    height: 16px;
    stroke: var(--text-light);
    fill: none;
    stroke-width: 2;
    stroke-linecap: round;
    flex-shrink: 0;
  }

  .search-input-wrap input {
    border: none;
    background: none;
    font-size: 13px;
    color: var(--text);
    font-family: inherit;
    width: 100%;
    outline: none;
  }

  .search-input-wrap input::placeholder { color: var(--text-light); }

  .search-select {
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 8px 12px;
    font-size: 13px;
    font-family: inherit;
    color: var(--text);
    cursor: pointer;
    outline: none;
  }

  .btn-filter {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 8px 14px;
    font-size: 13px;
    font-family: inherit;
    color: var(--text);
    cursor: pointer;
    font-weight: 500;
  }

  .btn-filter svg {
    width: 14px;
    height: 14px;
    stroke: var(--text);
    fill: none;
    stroke-width: 2.2;
    stroke-linecap: round;
    stroke-linejoin: round;
  }

  /* ── TABLE ── */
  .table-card {
    background: var(--bg-card);
    border-radius: 14px;
    border: 1px solid var(--border);
    overflow: hidden;
    margin-bottom: 24px;
  }

  table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
  }

  thead th {
    background: var(--bg);
    padding: 12px 14px;
    text-align: left;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .04em;
    color: var(--teal);
    text-transform: uppercase;
    border-bottom: 1px solid var(--border);
  }

  tbody tr {
    border-bottom: 1px solid var(--border);
    transition: background .15s;
  }

  tbody tr:last-child { border-bottom: none; }
  tbody tr:hover { background: var(--bg); }

  tbody td {
    padding: 14px;
    vertical-align: middle;
    color: var(--text);
    font-size: 13px;
    font-weight: 500;
  }

  .td-id { color: var(--text-muted); font-weight: 600; font-size: 12px; }

  .location-tag {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 6px;
    font-size: 11.5px;
    font-weight: 600;
  }

  .location-tag.gray {
    background: #f1f5f9;
    color: #64748b;
  }

  .location-tag.teal {
    background: var(--teal-light);
    color: #0f766e;
  }

  .badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 11.5px;
    font-weight: 600;
  }

  .badge.selesai {
    background: var(--green-light);
    color: #15803d;
  }

  .badge.proses {
    background: var(--purple-light);
    color: #7c3aed;
  }

  .btn-view {
    background: none;
    border: none;
    cursor: pointer;
    padding: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .btn-view svg {
    width: 18px;
    height: 18px;
    stroke: var(--text-light);
    fill: none;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
    transition: stroke .15s;
  }

  .btn-view:hover svg { stroke: var(--primary); }

  /* ── BOTTOM GRID ── */
  .bottom-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
  }

  @media (max-width: 600px) {
    .bottom-grid { grid-template-columns: 1fr; }
  }

  .bottom-card {
    background: var(--bg-card);
    border-radius: 14px;
    border: 1px solid var(--border);
    padding: 20px 18px;
  }

  .bottom-card-title {
    font-size: 14px;
    font-weight: 700;
    color: var(--text);
    margin-bottom: 16px;
  }

  /* Top Lokasi */
  .lokasi-list { display: flex; flex-direction: column; gap: 10px; }

  .lokasi-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 13px;
  }

  .lokasi-name { color: var(--text); font-weight: 500; }
  .lokasi-count { color: var(--teal); font-weight: 700; font-size: 13px; }

  /* Ringkasan */
  .ringkasan-list { display: flex; flex-direction: column; gap: 12px; }

  .ringkasan-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 13px;
  }

  .ringkasan-label { color: var(--text-muted); }

  .ringkasan-value {
    font-weight: 700;
    color: var(--text);
    font-size: 14px;
  }

  .ringkasan-value.green { color: var(--green); }
</style>
</head>
<body>

<!-- HEADER -->
<header class="header">
  <div class="header-left">
    <div class="hamburger">
      <span></span><span></span><span></span>
    </div>
    <span class="header-title">Laporan Mutasi Barang</span>
  </div>
  <div class="header-right">
    <button class="notif-btn">
      <svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
      <span class="notif-dot"></span>
    </button>
    <span class="header-date">Jumat, 17 April 2026</span>
  </div>
</header>

<!-- MAIN CONTENT -->
<main class="main">

  <!-- Page Header -->
  <div class="page-header">
    <div>
      <h1 class="page-title">Laporan Mutasi Barang</h1>
      <p class="page-subtitle">Detail dan analisis semua perpindahan barang antar lokasi</p>
    </div>
    <button class="btn-download">
      <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
      Unduh Laporan
    </button>
  </div>

  <!-- Stats -->
  <div class="stats-grid">
    <div class="stat-card teal">
      <div class="stat-card-top">
        <div class="stat-icon">
          <svg viewBox="0 0 24 24"><path d="M17 1l4 4-4 4"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/><path d="M7 23l-4-4 4-4"/><path d="M21 13v2a4 4 0 0 1-4 4H3"/></svg>
        </div>
        <span class="stat-label">Total Mutasi</span>
      </div>
      <div class="stat-value">2</div>
      <div class="stat-sub">Bulan ini</div>
    </div>

    <div class="stat-card green">
      <div class="stat-card-top">
        <div class="stat-icon">
          <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        </div>
        <span class="stat-label">Selesai</span>
      </div>
      <div class="stat-value">1</div>
      <div class="stat-sub">50%</div>
    </div>

    <div class="stat-card blue">
      <div class="stat-card-top">
        <div class="stat-icon">
          <svg viewBox="0 0 24 24"><line x1="12" y1="2" x2="12" y2="6"/><line x1="12" y1="18" x2="12" y2="22"/><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"/><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"/><line x1="2" y1="12" x2="6" y2="12"/><line x1="18" y1="12" x2="22" y2="12"/><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"/><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"/></svg>
        </div>
        <span class="stat-label">Dalam Proses</span>
      </div>
      <div class="stat-value">1</div>
      <div class="stat-sub">50%</div>
    </div>

    <div class="stat-card purple">
      <div class="stat-card-top">
        <div class="stat-icon">
          <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
        </div>
        <span class="stat-label">Lokasi Tujuan</span>
      </div>
      <div class="stat-value">4</div>
      <div class="stat-sub">Lokasi unik</div>
    </div>
  </div>

  <!-- Chart -->
  <div class="chart-card">
    <div class="chart-card-title">Tren Mutasi Bulanan</div>
    <div class="chart-wrap">
      <canvas id="trendChart"></canvas>
    </div>
  </div>

  <!-- Search & Filter -->
  <div class="search-bar">
    <div class="search-input-wrap">
      <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
      <input type="text" placeholder="Cari barang atau lokasi...">
    </div>
    <select class="search-select">
      <option>Semua Status</option>
      <option>Selesai</option>
      <option>Dalam Proses</option>
    </select>
    <button class="btn-filter">
      <svg viewBox="0 0 24 24"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
      Filter
    </button>
  </div>

  <!-- Table -->
  <div class="table-card">
    <table>
      <thead>
        <tr>
          <th>ID Mutasi</th>
          <th>Tanggal</th>
          <th>Nama Barang</th>
          <th>QTY</th>
          <th>Dari Lokasi</th>
          <th>Ke Lokasi</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="td-id">MT-001</td>
          <td>2025-01-15</td>
          <td>Proyektor Epson</td>
          <td>1</td>
          <td><span class="location-tag gray">Gudang Utama</span></td>
          <td><span class="location-tag teal">Ruang Rapat Lt.3</span></td>
          <td><span class="badge selesai">Selesai</span></td>
          <td>
            <button class="btn-view">
              <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            </button>
          </td>
        </tr>
        <tr>
          <td class="td-id">MT-002</td>
          <td>2025-01-14</td>
          <td>Kursi Ergonomis</td>
          <td>4</td>
          <td><span class="location-tag gray">Dept. HR</span></td>
          <td><span class="location-tag teal">Dept. Marketing</span></td>
          <td><span class="badge proses">Proses</span></td>
          <td>
            <button class="btn-view">
              <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  <!-- Bottom Grid -->
  <div class="bottom-grid">

    <!-- Top Lokasi Tujuan -->
    <div class="bottom-card">
      <div class="bottom-card-title">Top Lokasi Tujuan</div>
      <div class="lokasi-list">
        <div class="lokasi-row">
          <span class="lokasi-name">Ruang Rapat Lt.3</span>
          <span class="lokasi-count">8 item</span>
        </div>
        <div class="lokasi-row">
          <span class="lokasi-name">Dept. Marketing</span>
          <span class="lokasi-count">5 item</span>
        </div>
        <div class="lokasi-row">
          <span class="lokasi-name">Dept. IT</span>
          <span class="lokasi-count">4 item</span>
        </div>
        <div class="lokasi-row">
          <span class="lokasi-name">Gudang Cabang</span>
          <span class="lokasi-count">3 item</span>
        </div>
      </div>
    </div>

    <!-- Ringkasan Mutasi -->
    <div class="bottom-card">
      <div class="bottom-card-title">Ringkasan Mutasi</div>
      <div class="ringkasan-list">
        <div class="ringkasan-row">
          <span class="ringkasan-label">Total Item Dimutasi</span>
          <span class="ringkasan-value">20</span>
        </div>
        <div class="ringkasan-row">
          <span class="ringkasan-label">Rata-rata Waktu Proses</span>
          <span class="ringkasan-value">2.5 Hari</span>
        </div>
        <div class="ringkasan-row">
          <span class="ringkasan-label">Sukses Selesai</span>
          <span class="ringkasan-value green">95%</span>
        </div>
      </div>
    </div>

  </div>
</main>

<script>
  const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
  const days   = [6, 9, 8, 11, 7, 10, 12, 9, 13, 11, 10, 14];

  const ctx = document.getElementById('trendChart').getContext('2d');
  new Chart(ctx, {
    type: 'line',
    data: {
      labels: months,
      datasets: [{
        data: days,
        borderColor: '#14b8a6',
        borderWidth: 2,
        pointRadius: 4,
        pointBackgroundColor: '#14b8a6',
        pointBorderColor: '#fff',
        pointBorderWidth: 2,
        tension: 0.35,
        fill: true,
        backgroundColor: (ctx) => {
          const gradient = ctx.chart.ctx.createLinearGradient(0, 0, 0, 160);
          gradient.addColorStop(0, 'rgba(20,184,166,0.18)');
          gradient.addColorStop(1, 'rgba(20,184,166,0)');
          return gradient;
        }
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { display: false }, tooltip: {
        backgroundColor: '#0f172a',
        padding: 10,
        titleFont: { family: 'Plus Jakarta Sans', size: 12 },
        bodyFont: { family: 'Plus Jakarta Sans', size: 12 },
        callbacks: { label: (ctx) => ` ${ctx.raw} mutasi` }
      }},
      scales: {
        x: {
          grid: { display: false },
          ticks: { font: { family: 'Plus Jakarta Sans', size: 11 }, color: '#94a3b8' }
        },
        y: {
          display: false,
          min: 0,
          max: 18
        }
      }
    }
  });

  document.querySelector('.btn-download').addEventListener('click', () => {
    alert('Mengunduh laporan...');
  });
</script>

</body>
</html>
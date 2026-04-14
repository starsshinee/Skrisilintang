<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SIBMN - BPMP Provinsi Gorontalo</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --sidebar-w: 240px;
      --primary: #3b5bdb;
      --primary-light: #eef2ff;
      --green: #2f9e44;
      --green-bg: #ebfbee;
      --orange: #e67700;
      --orange-bg: #fff3bf;
      --red: #c92a2a;
      --red-bg: #fff5f5;
      --teal: #0c8599;
      --purple: #6741d9;
      --sidebar-bg: #1e2a4a;
      --sidebar-active: #3b5bdb;
      --text: #1a1a2e;
      --muted: #6b7280;
      --border: #e5e7eb;
      --card-bg: #ffffff;
      --bg: #f4f6fb;
    }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: var(--bg);
      color: var(--text);
      display: flex;
      min-height: 100vh;
    }

    /* SIDEBAR */
    .sidebar {
      width: var(--sidebar-w);
      background: var(--sidebar-bg);
      display: flex;
      flex-direction: column;
      position: fixed;
      top: 0; left: 0; bottom: 0;
      z-index: 100;
    }

    .sidebar-brand {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 20px 20px 16px;
      border-bottom: 1px solid rgba(255,255,255,0.08);
    }

    .brand-icon {
      width: 40px; height: 40px;
      background: var(--primary);
      border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
      color: #fff;
      font-size: 18px;
    }

    .brand-text .name { color: #fff; font-weight: 700; font-size: 15px; }
    .brand-text .sub { color: rgba(255,255,255,0.5); font-size: 12px; }

    .sidebar-nav {
      padding: 16px 12px;
      flex: 1;
      display: flex;
      flex-direction: column;
      gap: 4px;
    }

    .nav-item {
      display: flex; align-items: center; gap: 12px;
      padding: 10px 12px;
      border-radius: 8px;
      color: rgba(255,255,255,0.6);
      font-size: 14px;
      font-weight: 500;
      cursor: pointer;
      text-decoration: none;
      transition: all .2s;
    }
    .nav-item:hover { background: rgba(255,255,255,0.08); color: #fff; }
    .nav-item.active { background: var(--primary); color: #fff; }
    .nav-item i { width: 18px; text-align: center; }

    .sidebar-footer {
      padding: 16px;
      border-top: 1px solid rgba(255,255,255,0.08);
    }

    .user-info {
      display: flex; align-items: center; gap: 10px;
      margin-bottom: 12px;
    }

    .avatar {
      width: 36px; height: 36px;
      background: var(--primary);
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      color: #fff; font-weight: 700; font-size: 14px;
      flex-shrink: 0;
    }

    .user-name { color: #fff; font-size: 13px; font-weight: 600; }
    .user-role { color: rgba(255,255,255,0.4); font-size: 11px; }

    .logout-btn {
      display: flex; align-items: center; gap: 8px;
      color: rgba(255,255,255,0.5);
      font-size: 13px;
      cursor: pointer;
      transition: color .2s;
      background: none; border: none;
    }
    .logout-btn:hover { color: #ff6b6b; }

    /* MAIN */
    .main {
      margin-left: 260px;
      flex: 1;
      display: flex;
      flex-direction: column;
    }

    .topbar {
      background: #fff;
      padding: 16px 32px;
      display: flex; align-items: center; justify-content: space-between;
      border-bottom: 1px solid var(--border);
      position: sticky; top: 0; z-index: 50;
    }

    .page-title { font-size: 20px; font-weight: 700; }
    .page-sub { font-size: 13px; color: var(--muted); margin-top: 2px; }

    .topbar-right { display: flex; align-items: center; gap: 12px; }

    .notif-btn {
      width: 38px; height: 38px;
      border: 1px solid var(--border);
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      cursor: pointer; position: relative;
      background: #fff;
      color: var(--muted);
    }
    .notif-dot {
      width: 8px; height: 8px;
      background: #f03e3e;
      border-radius: 50%;
      position: absolute; top: 6px; right: 6px;
      border: 2px solid #fff;
    }

    .avatar-top {
      width: 38px; height: 38px;
      background: var(--primary);
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      color: #fff; font-weight: 700; font-size: 14px;
      cursor: pointer;
    }

    /* CONTENT */
    .content { padding: 28px 32px; flex: 1; }

    /* STAT CARDS */
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 20px;
      margin-bottom: 28px;
    }

    .stat-card {
      background: var(--card-bg);
      border-radius: 14px;
      padding: 20px 24px;
      border: 1px solid var(--border);
      transition: box-shadow .2s;
    }
    .stat-card:hover { box-shadow: 0 4px 20px rgba(0,0,0,0.07); }

    .stat-header {
      display: flex; align-items: center; justify-content: space-between;
      margin-bottom: 14px;
    }

    .stat-icon {
      width: 44px; height: 44px;
      border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
      font-size: 20px;
      color: #fff;
    }
    .icon-blue { background: #3b5bdb; }
    .icon-green { background: #2f9e44; }
    .icon-orange { background: #f59f00; }
    .icon-red { background: #e03131; }

    .stat-badge {
      font-size: 12px; font-weight: 600;
      padding: 3px 8px;
      border-radius: 20px;
    }
    .badge-up { background: #ebfbee; color: #2f9e44; }
    .badge-down { background: #fff5f5; color: #c92a2a; }

    .stat-value { font-size: 28px; font-weight: 700; margin-bottom: 4px; }
    .stat-label { font-size: 13px; color: var(--muted); }

    /* BOTTOM SECTION */
    .bottom-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
    }

    .card {
      background: var(--card-bg);
      border-radius: 14px;
      border: 1px solid var(--border);
      padding: 24px;
    }

    .card-title {
      display: flex; align-items: center; gap: 8px;
      font-size: 15px; font-weight: 700;
      margin-bottom: 20px;
      color: var(--text);
    }
    .card-title i { color: var(--primary); }

    /* ACTIVITY */
    .activity-list { display: flex; flex-direction: column; gap: 0; }

    .activity-item {
      display: flex; align-items: center; justify-content: space-between;
      padding: 12px 0;
      border-bottom: 1px solid var(--border);
      gap: 12px;
    }
    .activity-item:last-child { border-bottom: none; }

    .activity-left { display: flex; align-items: center; gap: 12px; }

    .act-icon {
      width: 32px; height: 32px;
      border-radius: 8px;
      display: flex; align-items: center; justify-content: center;
      font-size: 14px;
      flex-shrink: 0;
    }
    .act-blue { background: #eef2ff; color: #3b5bdb; }
    .act-yellow { background: #fff9db; color: #e67700; }
    .act-green { background: #ebfbee; color: #2f9e44; }
    .act-teal { background: #e3fafc; color: #0c8599; }
    .act-gray { background: #f3f4f6; color: #6b7280; }

    .act-text { font-size: 14px; font-weight: 500; }
    .act-time { font-size: 12px; color: var(--muted); white-space: nowrap; }

    /* CHART */
    .chart-list { display: flex; flex-direction: column; gap: 14px; }

    .chart-row { }
    .chart-meta {
      display: flex; justify-content: space-between;
      font-size: 13px; margin-bottom: 6px;
    }
    .chart-name { font-weight: 500; }
    .chart-num { font-weight: 700; color: var(--text); }

    .bar-track {
      height: 8px;
      background: #f3f4f6;
      border-radius: 99px;
      overflow: hidden;
    }
    .bar-fill {
      height: 100%;
      border-radius: 99px;
      transition: width 1s ease;
    }
    .bar-blue { background: #3b5bdb; }
    .bar-green { background: #2f9e44; }
    .bar-orange { background: #f59f00; }
    .bar-purple { background: #6741d9; }
    .bar-teal { background: #0c8599; }
    .bar-red { background: #e03131; }
  </style>
</head>
<body>

@include('partials.sidebar')

<!-- MAIN -->
<div class="main">
  <div class="topbar">
    <div>
      <div class="page-title">Dashboard</div>
      <div class="page-sub">Super Admin — BPMP Gorontalo</div>
    </div>
    <div class="topbar-right">
      <div class="notif-btn">
        <i class="fas fa-bell"></i>
        <span class="notif-dot"></span>
      </div>
      <div class="avatar-top">DA</div>
    </div>
  </div>

  <div class="content">
    <!-- STAT CARDS -->
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-header">
          <div class="stat-icon icon-blue"><i class="fas fa-database"></i></div>
          <span class="stat-badge badge-up">+12%</span>
        </div>
        <div class="stat-value">1,247</div>
        <div class="stat-label">Total Item BMN</div>
      </div>

      <div class="stat-card">
        <div class="stat-header">
          <div class="stat-icon icon-green"><i class="fas fa-chart-line"></i></div>
          <span class="stat-badge badge-up">+5.2%</span>
        </div>
        <div class="stat-value">Rp 28.5M</div>
        <div class="stat-label">Nilai Aset</div>
      </div>

      <div class="stat-card">
        <div class="stat-header">
          <div class="stat-icon icon-orange"><i class="fas fa-arrow-right-arrow-left"></i></div>
          <span class="stat-badge badge-up">+18%</span>
        </div>
        <div class="stat-value">342</div>
        <div class="stat-label">Transaksi Bulan Ini</div>
      </div>

      <div class="stat-card">
        <div class="stat-header">
          <div class="stat-icon icon-red"><i class="fas fa-clock"></i></div>
          <span class="stat-badge badge-down">-3</span>
        </div>
        <div class="stat-value">23</div>
        <div class="stat-label">Perlu Perhatian</div>
      </div>
    </div>

    <!-- BOTTOM -->
    <div class="bottom-grid">
      <!-- AKTIVITAS -->
      <div class="card">
        <div class="card-title">
          <i class="fas fa-chart-line"></i> Aktivitas Terakhir
        </div>
        <div class="activity-list">
          <div class="activity-item">
            <div class="activity-left">
              <div class="act-icon act-blue"><i class="fas fa-circle-arrow-down"></i></div>
              <span class="act-text">Barang masuk: ATK 50 rim</span>
            </div>
            <span class="act-time">2 jam lalu</span>
          </div>
          <div class="activity-item">
            <div class="activity-left">
              <div class="act-icon act-yellow"><i class="fas fa-file-lines"></i></div>
              <span class="act-text">Peminjaman Proyektor #PRJ-003</span>
            </div>
            <span class="act-time">4 jam lalu</span>
          </div>
          <div class="activity-item">
            <div class="activity-left">
              <div class="act-icon act-green"><i class="fas fa-screwdriver-wrench"></i></div>
              <span class="act-text">Pemeliharaan AC Ruang Rapat</span>
            </div>
            <span class="act-time">Kemarin</span>
          </div>
          <div class="activity-item">
            <div class="activity-left">
              <div class="act-icon act-teal"><i class="fas fa-rotate"></i></div>
              <span class="act-text">Mutasi Laptop ke Bidang PMP</span>
            </div>
            <span class="act-time">2 hari lalu</span>
          </div>
          <div class="activity-item">
            <div class="activity-left">
              <div class="act-icon act-gray"><i class="fas fa-clipboard-list"></i></div>
              <span class="act-text">Stok opname persediaan Q4</span>
            </div>
            <span class="act-time">3 hari lalu</span>
          </div>
        </div>
      </div>

      <!-- GRAFIK -->
      <div class="card">
        <div class="card-title">
          <i class="fas fa-chart-bar"></i> Grafik BMN per Kategori
        </div>
        <div class="chart-list">
          <div class="chart-row">
            <div class="chart-meta">
              <span class="chart-name">Peralatan & Mesin</span>
              <span class="chart-num">420</span>
            </div>
            <div class="bar-track"><div class="bar-fill bar-blue" style="width:85%"></div></div>
          </div>
          <div class="chart-row">
            <div class="chart-meta">
              <span class="chart-name">Gedung & Bangunan</span>
              <span class="chart-num">85</span>
            </div>
            <div class="bar-track"><div class="bar-fill bar-green" style="width:22%"></div></div>
          </div>
          <div class="chart-row">
            <div class="chart-meta">
              <span class="chart-name">Tanah</span>
              <span class="chart-num">12</span>
            </div>
            <div class="bar-track"><div class="bar-fill bar-orange" style="width:8%"></div></div>
          </div>
          <div class="chart-row">
            <div class="chart-meta">
              <span class="chart-name">Kendaraan</span>
              <span class="chart-num">35</span>
            </div>
            <div class="bar-track"><div class="bar-fill bar-purple" style="width:14%"></div></div>
          </div>
          <div class="chart-row">
            <div class="chart-meta">
              <span class="chart-name">Persediaan</span>
              <span class="chart-num">391</span>
            </div>
            <div class="bar-track"><div class="bar-fill bar-teal" style="width:79%"></div></div>
          </div>
          <div class="chart-row">
            <div class="chart-meta">
              <span class="chart-name">Aset Lainnya</span>
              <span class="chart-num">304</span>
            </div>
            <div class="bar-track"><div class="bar-fill bar-red" style="width:62%"></div></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
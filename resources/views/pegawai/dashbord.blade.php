<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SIPANDU - User Dashboard</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Segoe UI', sans-serif; background: #f0f2f5; display: flex; min-height: 100vh; }

    /* ===== SIDEBAR ===== */
    .sidebar {
      width: 220px;
      min-height: 100vh;
      background: #1a237e;
      display: flex;
      flex-direction: column;
      position: fixed;
      top: 0; left: 0;
      z-index: 100;
    }
    .sidebar-logo {
      padding: 18px 20px;
      display: flex;
      align-items: center;
      gap: 10px;
      border-bottom: 1px solid rgba(255,255,255,0.12);
    }
    .logo-circle {
      width: 36px; height: 36px;
      border-radius: 50%;
      background: white;
      display: flex; align-items: center; justify-content: center;
    }
    .logo-circle span { color: #1a237e; font-weight: 700; font-size: 11px; }
    .sidebar-logo-text { color: white; font-weight: 700; font-size: 16px; letter-spacing: 1px; }

    .sidebar-user {
      padding: 10px 20px;
      background: rgba(255,255,255,0.1);
      display: flex; align-items: center; gap: 8px;
    }
    .user-icon {
      width: 28px; height: 28px; border-radius: 50%;
      background: rgba(255,255,255,0.25);
      display: flex; align-items: center; justify-content: center;
    }
    .sidebar-user-label { color: white; font-size: 12px; font-weight: 500; }

    .sidebar-nav { flex: 1; padding: 8px 0; }
    .nav-item {
      display: flex; align-items: center; gap: 10px;
      padding: 11px 20px;
      color: rgba(255,255,255,0.75);
      cursor: pointer;
      font-size: 13px;
      border-left: 3px solid transparent;
      transition: background 0.15s;
      text-decoration: none;
    }
    .nav-item:hover { background: rgba(255,255,255,0.08); color: white; }
    .nav-item.active { background: rgba(255,255,255,0.15); color: white; border-left: 3px solid #7c9eff; }
    .nav-item svg { width: 16px; height: 16px; flex-shrink: 0; }

    .sidebar-logout { padding: 12px 20px; border-top: 1px solid rgba(255,255,255,0.12); }
    .logout-btn {
      display: flex; align-items: center; gap: 10px;
      color: rgba(255,255,255,0.65);
      font-size: 13px; cursor: pointer; padding: 8px 0;
      background: none; border: none; width: 100%;
    }
    .logout-btn:hover { color: white; }

    /* ===== MAIN ===== */
    .main {
      margin-left: 220px;
      flex: 1;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    .topbar {
      background: white;
      padding: 14px 24px;
      display: flex; align-items: center; gap: 14px;
      border-bottom: 1px solid #e0e0e0;
      position: sticky; top: 0; z-index: 50;
    }
    .hamburger { cursor: pointer; display: flex; flex-direction: column; justify-content: space-between; width: 20px; height: 14px; }
    .hamburger span { display: block; height: 2px; background: #555; border-radius: 2px; }
    .topbar-title { font-size: 18px; font-weight: 600; color: #1a237e; }

    .content { padding: 20px 24px; flex: 1; }

    /* ===== WELCOME CARD ===== */
    .welcome-card {
      background: linear-gradient(135deg, #1a237e 0%, #3949ab 60%, #7c9eff 100%);
      border-radius: 12px;
      padding: 20px 24px;
      display: flex; justify-content: space-between; align-items: flex-start;
      margin-bottom: 20px;
      position: relative; overflow: hidden;
    }
    .welcome-card::before {
      content: '';
      position: absolute; right: -20px; top: -20px;
      width: 140px; height: 140px; border-radius: 50%;
      background: rgba(255,255,255,0.06);
    }
    .welcome-card::after {
      content: '';
      position: absolute; right: 60px; bottom: -30px;
      width: 100px; height: 100px; border-radius: 50%;
      background: rgba(255,255,255,0.04);
    }
    .welcome-text h2 { color: white; font-size: 17px; font-weight: 600; margin-bottom: 6px; }
    .welcome-text p { color: rgba(255,255,255,0.78); font-size: 12px; max-width: 380px; line-height: 1.5; }
    .welcome-right { text-align: right; flex-shrink: 0; }
    .settings-btn {
      background: rgba(255,255,255,0.15);
      border: 1px solid rgba(255,255,255,0.3);
      color: white; padding: 6px 12px;
      border-radius: 6px; font-size: 11px; cursor: pointer;
      display: inline-flex; align-items: center; gap: 5px;
      margin-bottom: 10px;
    }
    .settings-btn:hover { background: rgba(255,255,255,0.22); }
    .day-label { color: rgba(255,255,255,0.65); font-size: 11px; }
    .date-text { color: rgba(255,255,255,0.92); font-size: 13px; font-weight: 500; }

    /* ===== STAT CARDS ===== */
    .stats-row {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 14px;
      margin-bottom: 20px;
    }
    .stat-card {
      background: white;
      border-radius: 10px;
      padding: 16px;
      display: flex; align-items: center; gap: 14px;
      box-shadow: 0 1px 4px rgba(0,0,0,0.07);
    }
    .stat-icon {
      width: 44px; height: 44px; border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0;
    }
    .stat-icon.blue  { background: #e8f0fe; }
    .stat-icon.amber { background: #fff3e0; }
    .stat-icon.green { background: #e8f5e9; }
    .stat-icon.red   { background: #fce4ec; }
    .stat-num { font-size: 28px; font-weight: 700; line-height: 1; }
    .stat-num.blue  { color: #1a73e8; }
    .stat-num.amber { color: #f57c00; }
    .stat-num.green { color: #388e3c; }
    .stat-num.red   { color: #c62828; }
    .stat-label { font-size: 11px; color: #888; margin-top: 4px; line-height: 1.4; }

    /* ===== BOTTOM ROW ===== */
    .bottom-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 16px;
    }
    .panel {
      background: white;
      border-radius: 10px;
      padding: 16px 18px;
      box-shadow: 0 1px 4px rgba(0,0,0,0.07);
    }
    .panel-header {
      display: flex; align-items: center; justify-content: space-between;
      margin-bottom: 14px;
      padding-bottom: 10px;
      border-bottom: 1px solid #f0f0f0;
    }
    .panel-title {
      font-size: 14px; font-weight: 600; color: #222;
      display: flex; align-items: center; gap: 6px;
    }
    .badge-count {
      background: #f0f2f5; border-radius: 10px;
      padding: 3px 10px; font-size: 11px; color: #555;
    }

    /* ===== REQUEST ITEM ===== */
    .request-item {
      border: 1px solid #eee;
      border-radius: 8px;
      padding: 12px;
      margin-bottom: 10px;
    }
    .request-item:last-child { margin-bottom: 0; }
    .req-top { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px; }
    .req-name { font-size: 13px; font-weight: 500; color: #222; }
    .status-badge {
      font-size: 10px; padding: 3px 10px; border-radius: 10px;
      font-weight: 500; display: inline-flex; align-items: center; gap: 4px; white-space: nowrap;
    }
    .status-badge.menunggu { background: #fff3e0; color: #e65100; }
    .status-badge.diterima { background: #e8f5e9; color: #2e7d32; }
    .status-badge.ditolak  { background: #fce4ec; color: #c62828; }
    .req-type-tag {
      font-size: 11px; color: #666; background: #f5f5f5;
      padding: 2px 8px; border-radius: 4px; display: inline-block; margin-bottom: 4px;
    }
    .req-meta { font-size: 11px; color: #999; margin-bottom: 4px; }
    .req-date { font-size: 11px; color: #aaa; display: flex; align-items: center; gap: 4px; flex-wrap: wrap; }
    .req-date svg { flex-shrink: 0; }
    .req-time { display: flex; align-items: center; gap: 3px; margin-left: 8px; }
    .req-actions { display: flex; gap: 8px; margin-top: 10px; justify-content: flex-end; flex-wrap: wrap; }
    .btn-detail {
      font-size: 11px; color: #1a73e8; background: #e8f0fe;
      border: none; padding: 5px 12px; border-radius: 5px; cursor: pointer;
    }
    .btn-detail:hover { background: #d2e3fc; }
    .btn-surat {
      font-size: 11px; color: #f57c00; background: #fff3e0;
      border: none; padding: 5px 12px; border-radius: 5px; cursor: pointer;
    }
    .btn-surat:hover { background: #ffe0b2; }

    /* ===== MENU PANEL ===== */
    .menu-panel { display: flex; flex-direction: column; gap: 12px; }
    .menu-btn {
      padding: 13px 18px; border-radius: 8px; border: none;
      cursor: pointer; font-size: 13px; font-weight: 600;
      display: flex; align-items: center; gap: 8px;
      transition: opacity 0.15s, transform 0.1s;
      width: 100%;
    }
    .menu-btn:hover { opacity: 0.88; }
    .menu-btn:active { transform: scale(0.98); }
    .menu-btn.primary { background: #1a237e; color: white; }
    .menu-btn.danger  { background: #c62828; color: white; }
    .menu-desc {
      font-size: 11px; color: #aaa;
      margin-top: 6px; line-height: 1.6; text-align: center;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 900px) {
      .stats-row { grid-template-columns: repeat(2, 1fr); }
      .bottom-row { grid-template-columns: 1fr; }
    }
    @media (max-width: 640px) {
      .sidebar { width: 180px; }
      .main { margin-left: 180px; }
      .stats-row { grid-template-columns: repeat(2, 1fr); }
      .welcome-card { flex-direction: column; gap: 14px; }
      .welcome-right { text-align: left; }
    }
  </style>
</head>
<body>

@include('partials.sidebar')

<!-- MAIN -->
<div class="main">
  <div class="topbar">
    <div class="hamburger">
      <span></span><span></span><span></span>
    </div>
    <span class="topbar-title">User Dashboard</span>
  </div>

  <div class="content">

    <!-- WELCOME CARD -->
    <div class="welcome-card">
      <div class="welcome-text">
        <h2>Selamat Datang, amelia eka safitri! 👋</h2>
        <p>Kelola permintaan barang Anda dengan mudah melalui sistem inventaris BPMP Provinsi Gorontalo</p>
      </div>
      <div class="welcome-right">
        <button class="settings-btn">
          <svg width="11" height="11" viewBox="0 0 24 24" fill="none">
            <circle cx="12" cy="12" r="3" stroke="white" stroke-width="2"/>
            <path d="M12 1v3M12 20v3M4.22 4.22l2.12 2.12M17.66 17.66l2.12 2.12M1 12h3M20 12h3M4.22 19.78l2.12-2.12M17.66 6.34l2.12-2.12" stroke="white" stroke-width="2" stroke-linecap="round"/>
          </svg>
          Pengaturan Akun
        </button>
        <div class="day-label">Hari ini</div>
        <div class="date-text">Monday, 01 December</div>
        <div class="date-text">2025</div>
      </div>
    </div>

    <!-- STAT CARDS -->
    <div class="stats-row">
      <div class="stat-card">
        <div class="stat-icon blue">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
            <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" stroke="#1a73e8" stroke-width="1.8" stroke-linecap="round"/>
          </svg>
        </div>
        <div>
          <div class="stat-num blue">2</div>
          <div class="stat-label">Total Permintaan<br>Semua waktu</div>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icon amber">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
            <circle cx="12" cy="12" r="9" stroke="#f57c00" stroke-width="1.8"/>
            <path d="M12 7v5l3 3" stroke="#f57c00" stroke-width="1.8" stroke-linecap="round"/>
          </svg>
        </div>
        <div>
          <div class="stat-num amber">2</div>
          <div class="stat-label">Menunggu Review<br>Sedang diproses</div>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icon green">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
            <path d="M20 6L9 17l-5-5" stroke="#388e3c" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
        <div>
          <div class="stat-num green">0</div>
          <div class="stat-label">Diterima<br>Berhasil Diterima</div>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icon red">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
            <path d="M18 6L6 18M6 6l12 12" stroke="#c62828" stroke-width="2.2" stroke-linecap="round"/>
          </svg>
        </div>
        <div>
          <div class="stat-num red">0</div>
          <div class="stat-label">Ditolak<br>Telah perbaikan</div>
        </div>
      </div>
    </div>

    <!-- BOTTOM ROW -->
    <div class="bottom-row">

      <!-- PERMINTAAN TERBARU -->
      <div class="panel">
        <div class="panel-header">
          <span class="panel-title">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none">
              <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2" stroke="#333" stroke-width="1.6" stroke-linecap="round"/>
              <rect x="9" y="3" width="6" height="4" rx="1" stroke="#333" stroke-width="1.5"/>
            </svg>
            Permintaan Terbaru
          </span>
          <span class="badge-count">2 total permintaan</span>
        </div>

        <!-- Item 1 -->
        <div class="request-item">
          <div class="req-top">
            <div class="req-name">Harum ut quae sunt</div>
            <span class="status-badge menunggu">
              <svg width="7" height="7" viewBox="0 0 10 10"><circle cx="5" cy="5" r="5" fill="#f57c00"/></svg>
              Menunggu
            </span>
          </div>
          <div class="req-type-tag">elektronik &bull; Tidak Diketahui</div>
          <div class="req-meta">Peminjaman Barang</div>
          <div class="req-date">
            <svg width="11" height="11" viewBox="0 0 24 24" fill="none">
              <rect x="3" y="4" width="18" height="18" rx="2" stroke="#aaa" stroke-width="1.5"/>
              <path d="M16 2v4M8 2v4M3 10h18" stroke="#aaa" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
            27 November 2025
            <span class="req-time">
              <svg width="11" height="11" viewBox="0 0 24 24" fill="none">
                <circle cx="12" cy="12" r="9" stroke="#aaa" stroke-width="1.5"/>
                <path d="M12 7v5l3 2" stroke="#aaa" stroke-width="1.5" stroke-linecap="round"/>
              </svg>
              10:10
            </span>
          </div>
          <div class="req-actions">
            <button class="btn-detail">Lihat Detail</button>
            <button class="btn-surat">Surat Belum Tersedia</button>
          </div>
        </div>

        <!-- Item 2 -->
        <div class="request-item">
          <div class="req-top">
            <div class="req-name">Permintaan Barang #002</div>
            <span class="status-badge menunggu">
              <svg width="7" height="7" viewBox="0 0 10 10"><circle cx="5" cy="5" r="5" fill="#f57c00"/></svg>
              Menunggu
            </span>
          </div>
          <div class="req-type-tag">alat tulis &bull; Tersedia</div>
          <div class="req-meta">Permintaan Persediaan</div>
          <div class="req-date">
            <svg width="11" height="11" viewBox="0 0 24 24" fill="none">
              <rect x="3" y="4" width="18" height="18" rx="2" stroke="#aaa" stroke-width="1.5"/>
              <path d="M16 2v4M8 2v4M3 10h18" stroke="#aaa" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
            28 November 2025
            <span class="req-time">
              <svg width="11" height="11" viewBox="0 0 24 24" fill="none">
                <circle cx="12" cy="12" r="9" stroke="#aaa" stroke-width="1.5"/>
                <path d="M12 7v5l3 2" stroke="#aaa" stroke-width="1.5" stroke-linecap="round"/>
              </svg>
              09:30
            </span>
          </div>
          <div class="req-actions">
            <button class="btn-detail">Lihat Detail</button>
            <button class="btn-surat">Lihat Surat</button>
          </div>
        </div>
      </div>

      <!-- MENU UTAMA -->
      <div class="panel">
        <div class="panel-header">
          <span class="panel-title">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none">
              <path d="M4 6h16M4 10h16M4 14h8" stroke="#333" stroke-width="1.6" stroke-linecap="round"/>
            </svg>
            Menu Utama
          </span>
        </div>
        <div class="menu-panel">
          <button class="menu-btn primary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
              <path d="M12 5v14M5 12h14" stroke="white" stroke-width="2.2" stroke-linecap="round"/>
            </svg>
            Buat Permintaan Barang
          </button>
          <button class="menu-btn danger">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
              <path d="M17 16l4-4m0 0l-4-4m4 4H7" stroke="white" stroke-width="2" stroke-linecap="round"/>
              <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4" stroke="white" stroke-width="2" stroke-linecap="round"/>
            </svg>
            Logout
          </button>
          <p class="menu-desc">
            Gunakan menu di samping kiri untuk navigasi ke fitur lainnya seperti peminjaman barang, kendaraan, dan histori permintaan.
          </p>
        </div>
      </div>

    </div><!-- end bottom-row -->
  </div><!-- end content -->
</div><!-- end main -->

</body>
</html>
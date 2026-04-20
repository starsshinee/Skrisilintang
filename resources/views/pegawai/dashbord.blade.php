<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SIPANDU - User Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    :root {
      --primary: #2563eb;
      --primary-light: #3b82f6;
      --primary-dark: #1d4ed8;
      --accent: #06b6d4;
      --accent2: #8b5cf6;
      --success: #10b981;
      --warning: #f59e0b;
      --danger: #ef4444;
      --bg: #f0f4ff;
      --sidebar-bg: #0f172a;
      --sidebar-text: #94a3b8;
      --sidebar-active: #2563eb;
      --card-bg: #ffffff;
      --text-primary: #0f172a;
      --text-secondary: #64748b;
      --border: #e2e8f0;
      --radius: 16px;
      --radius-sm: 10px;
      --shadow: 0 4px 24px rgba(37,99,235,0.08);
      --shadow-lg: 0 8px 40px rgba(37,99,235,0.14);
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: var(--bg);
      color: var(--text-primary);
      display: flex;
      min-height: 100vh;
      overflow-x: hidden;
    }

    /* ===== MAIN ===== */
    .main {
      margin-left: 256px;
      flex: 1;
      padding: 0 32px 32px;
    }

    /* TOP BAR */
    .topbar {
      display: flex; align-items: center; justify-content: space-between;
      padding: 20px 0 24px;
      position: sticky; top: 0; z-index: 50;
      background: var(--bg);
    }
    .topbar-title { font-family: 'Space Grotesk', sans-serif; font-size: 22px; font-weight: 700; color: var(--text-primary); }
    .topbar-right { display: flex; align-items: center; gap: 12px; }
    .topbar-date {
      font-size: 13px; color: var(--text-secondary); font-weight: 500;
      background: var(--card-bg);
      border: 1px solid var(--border);
      padding: 8px 14px; border-radius: 10px;
      display: flex; align-items: center; gap: 6px;
    }
    .notif-btn {
      width: 40px; height: 40px;
      background: var(--card-bg);
      border: 1px solid var(--border);
      border-radius: 10px;
      display: grid; place-items: center;
      cursor: pointer; position: relative;
      color: var(--text-secondary);
      transition: all .2s;
    }
    .notif-btn:hover { border-color: var(--primary); color: var(--primary); }
    .notif-dot {
      position: absolute; top: 8px; right: 8px;
      width: 7px; height: 7px;
      background: var(--danger);
      border-radius: 50%;
      border: 1.5px solid var(--card-bg);
    }

    /* HERO BANNER */
    .hero {
      background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #0891b2 100%);
      border-radius: 20px;
      padding: 32px 36px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: relative;
      overflow: hidden;
      margin-bottom: 28px;
      box-shadow: 0 8px 32px rgba(37,99,235,0.28);
    }
    .hero::before {
      content: '';
      position: absolute; inset: 0;
      background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
    .hero-blob {
      position: absolute;
      width: 300px; height: 300px;
      border-radius: 50%;
      background: rgba(255,255,255,0.05);
      right: -60px; top: -80px;
      pointer-events: none;
    }
    .hero-blob2 {
      position: absolute;
      width: 180px; height: 180px;
      border-radius: 50%;
      background: rgba(255,255,255,0.04);
      right: 120px; bottom: -60px;
      pointer-events: none;
    }
    .hero-left { position: relative; z-index: 2; }
    .hero-greeting { font-size: 13px; color: rgba(255,255,255,0.7); font-weight: 500; margin-bottom: 6px; letter-spacing: .5px; }
    .hero-title { font-family: 'Space Grotesk', sans-serif; font-size: 28px; font-weight: 800; color: #fff; margin-bottom: 8px; }
    .hero-sub { font-size: 14px; color: rgba(255,255,255,0.75); max-width: 380px; line-height: 1.6; }
    .hero-right { position: relative; z-index: 2; text-align: right; }
    .hero-inst { font-size: 12px; color: rgba(255,255,255,0.65); margin-bottom: 4px; }
    .hero-nip { font-size: 13px; color: rgba(255,255,255,0.85); font-weight: 600; margin-bottom: 14px; }
    .hero-btn {
      display: inline-flex; align-items: center; gap: 8px;
      background: rgba(255,255,255,0.18);
      backdrop-filter: blur(8px);
      border: 1.5px solid rgba(255,255,255,0.25);
      color: #fff; font-size: 13px; font-weight: 600;
      padding: 10px 20px; border-radius: 10px;
      cursor: pointer; transition: all .2s;
      text-decoration: none;
    }
    .hero-btn:hover { background: rgba(255,255,255,0.28); }

    .content { padding: 0; }
    /* ===== STAT CARDS ===== */
    .stats-row {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
      margin-bottom: 28px;
    }
    .stat-card {
      background: var(--card-bg);
      border-radius: var(--radius);
      padding: 24px;
      border: 1px solid var(--border);
      box-shadow: var(--shadow);
      display: flex;
      align-items: flex-end;
      gap: 18px;
      position: relative;
      overflow: hidden;
    }
    .stat-icon {
      width: 60px;
      height: 60px;
      border-radius: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 22px;
      flex-shrink: 0;
    }
    .stat-icon.blue { background: rgba(37,99,235,0.1); color: var(--primary); }
    .stat-icon.amber { background: rgba(245,158,11,0.1); color: var(--warning); }
    .stat-icon.green { background: rgba(16,185,129,0.1); color: var(--success); }
    .stat-num { font-size: 28px; font-weight: 700; line-height: 1; }
    .stat-num.blue  { color: var(--primary); }
    .stat-num.amber { color: var(--warning); }
    .stat-num.green { color: var(--success); }
    .stat-label { font-size: 13px; color: var(--text-secondary); font-weight: 500; margin-bottom: 4px; }
    .stat-num { font-size: 28px; font-weight: 700; line-height: 1; }
    .stat-num.blue  { color: var(--primary); }
    .stat-num.amber { color: var(--warning); }
    .stat-num.green { color: var(--success); }
    .stat-sub { font-size: 11px; color: var(--text-secondary); margin-top: 2px; }

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
    @media (max-width: 1024px) {
      .stats-row { grid-template-columns: repeat(2, 1fr); }
      .bottom-row { grid-template-columns: 1fr; }
    }
    @media (max-width: 900px) {
      .stats-row { grid-template-columns: repeat(2, 1fr); }
      div[style*="grid-template-columns: repeat(3"] { grid-template-columns: repeat(2, 1fr) !important; }
    }
    @media (max-width: 640px) {
      .main { margin-left: 256px; padding: 0 16px 16px; }
      .stats-row { grid-template-columns: 1fr; }
      .hero { padding: 20px 16px; flex-direction: column; gap: 16px; text-align: center; }
      .hero-right { text-align: center; }
      .topbar { padding: 12px 0 16px; }
      .topbar-title { font-size: 18px; }
      div[style*="grid-template-columns: repeat(3"] { grid-template-columns: 1fr !important; }
    }
  </style>
</head>
<body>

@include('partials.sidebar')

<!-- MAIN -->
<div class="main">
  <!-- TOPBAR -->
  <div class="topbar">
    <div class="topbar-title">Dashboard Pegawai</div>
    <div class="topbar-right">
      <div class="topbar-date">
        <i class="fas fa-calendar" style="color:var(--primary)"></i>
        <span id="current-date">Monday, 01 December 2025</span>
      </div>
      <button class="notif-btn">
        <i class="fas fa-bell"></i>
        <span class="notif-dot"></span>
      </button>
    </div>
  </div>

  <div class="content">
    <!-- HERO BANNER -->
    <div class="hero">
      <div class="hero-blob"></div>
      <div class="hero-blob2"></div>
      <div class="hero-left">
        <div class="hero-greeting">Selamat Datang 👋</div>
        <div class="hero-title">{{ auth()->user()->name ?? 'Pegawai' }}</div>
        <div class="hero-sub">Kelola permintaan barang Anda dengan mudah melalui sistem inventaris BPMP Provinsi Gorontalo</div>
      </div>
      <div class="hero-right">
        <div class="hero-inst">Sistem Inventaris</div>
        <div class="hero-nip">BPMP Provinsi Gorontalo</div>
        <a href="{{ route('pegawai.pengaturan-akun') }}" class="hero-btn">
          <i class="fas fa-cog"></i>
          Pengaturan Akun
        </a>
      </div>
    </div>

    <!-- STAT CARDS -->
    <div class="stats-row">
      <div class="stat-card">
        <div class="stat-icon blue">
          <i class="fas fa-box"></i>
        </div>
        <div>
          <div class="stat-label">Peminjaman Barang</div>
          <div class="stat-num blue">5</div>
          <div class="stat-sub">Total permintaan</div>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icon amber">
          <i class="fas fa-car"></i>
        </div>
        <div>
          <div class="stat-label">Peminjaman Kendaraan</div>
          <div class="stat-num amber">2</div>
          <div class="stat-sub">Total permintaan</div>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icon green">
          <i class="fas fa-cubes"></i>
        </div>
        <div>
          <div class="stat-label">Permintaan Persediaan</div>
          <div class="stat-num green">3</div>
          <div class="stat-sub">Total permintaan</div>
        </div>
      </div>
    </div>

    <!-- QUICK ACTIONS -->
    <div style="margin-bottom: 28px;">
      <h2 style="font-family: 'Space Grotesk', sans-serif; font-size: 18px; font-weight: 700; color: var(--text-primary); margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
        <i class="fas fa-lightning-bolt" style="color: var(--primary); font-size: 16px;"></i>
        Aksi Cepat
      </h2>
      <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px;">
        <a href="{{ route('pegawai.peminjaman-barang') }}" style="display: flex; align-items: center; justify-content: center; gap: 8px; padding: 16px 20px; border-radius: 12px; background: linear-gradient(135deg, #2563eb, #3b82f6); color: white; text-decoration: none; font-weight: 600; font-size: 13px; transition: all 0.2s; cursor: pointer;">
          <i class="fas fa-box"></i>
          Peminjaman Barang
        </a>
        <a href="{{ route('pegawai.peminjaman-kendaraan') }}" style="display: flex; align-items: center; justify-content: center; gap: 8px; padding: 16px 20px; border-radius: 12px; background: linear-gradient(135deg, var(--warning), #fbbf24); color: white; text-decoration: none; font-weight: 600; font-size: 13px; transition: all 0.2s; cursor: pointer;">
          <i class="fas fa-car"></i>
          Peminjaman Kendaraan
        </a>
        <a href="{{ route('pegawai.pengembalian-barang') }}" style="display: flex; align-items: center; justify-content: center; gap: 8px; padding: 16px 20px; border-radius: 12px; background: linear-gradient(135deg, var(--success), #34d399); color: white; text-decoration: none; font-weight: 600; font-size: 13px; transition: all 0.2s; cursor: pointer;">
          <i class="fas fa-cubes"></i>
          Pengembalian Barang
        </a>
        <a href="{{ route('pegawai.pengembalian-kendaraan') }}" style="display: flex; align-items: center; justify-content: center; gap: 8px; padding: 16px 20px; border-radius: 12px; background: linear-gradient(135deg, var(--success), #34d399); color: white; text-decoration: none; font-weight: 600; font-size: 13px; transition: all 0.2s; cursor: pointer;">
          <i class="fas fa-cubes"></i>
          Pengembalian Barang
        </a>
      </div>
    </div>

    <!-- BOTTOM ROW -->
    <div class="bottom-row">

      <!-- RIWAYAT PERMINTAAN TERBARU -->
      <div class="panel">
        <div class="panel-header">
          <span class="panel-title">
            <i class="fas fa-history" style="color: var(--primary); margin-right: 6px;"></i>
            Riwayat Permintaan Terbaru
          </span>
          <span class="badge-count">5 permintaan</span>
        </div>

        <!-- Item 1 - Peminjaman Barang -->
        <div class="request-item">
          <div class="req-top">
            <div class="req-name">Meminjam Laptop untuk Training</div>
            <span class="status-badge menunggu">
              <svg width="7" height="7" viewBox="0 0 10 10"><circle cx="5" cy="5" r="5" fill="#f57c00"/></svg>
              Diproses
            </span>
          </div>
          <div class="req-type-tag" style="background: #dbeafe; color: var(--primary); border-left: 2px solid var(--primary);">
            <i class="fas fa-box" style="margin-right: 4px;"></i>Peminjaman Barang
          </div>
          <div class="req-date">
            <svg width="11" height="11" viewBox="0 0 24 24" fill="none">
              <rect x="3" y="4" width="18" height="18" rx="2" stroke="#aaa" stroke-width="1.5"/>
              <path d="M16 2v4M8 2v4M3 10h18" stroke="#aaa" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
            15 April 2026
            <span class="req-time">
              <svg width="11" height="11" viewBox="0 0 24 24" fill="none">
                <circle cx="12" cy="12" r="9" stroke="#aaa" stroke-width="1.5"/>
                <path d="M12 7v5l3 2" stroke="#aaa" stroke-width="1.5" stroke-linecap="round"/>
              </svg>
              14:30
            </span>
          </div>
          <div class="req-actions">
            <button class="btn-detail">Lihat Detail</button>
          </div>
        </div>

        <!-- Item 2 - Peminjaman Kendaraan -->
        <div class="request-item">
          <div class="req-top">
            <div class="req-name">Penggunaan Kendaraan ke Lokasi Survey</div>
            <span class="status-badge diterima">
              <svg width="7" height="7" viewBox="0 0 10 10"><circle cx="5" cy="5" r="5" fill="#10b981"/></svg>
              Disetujui
            </span>
          </div>
          <div class="req-type-tag" style="background: #fff3e0; color: var(--warning); border-left: 2px solid var(--warning);">
            <i class="fas fa-car" style="margin-right: 4px;"></i>Peminjaman Kendaraan
          </div>
          <div class="req-date">
            <svg width="11" height="11" viewBox="0 0 24 24" fill="none">
              <rect x="3" y="4" width="18" height="18" rx="2" stroke="#aaa" stroke-width="1.5"/>
              <path d="M16 2v4M8 2v4M3 10h18" stroke="#aaa" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
            14 April 2026
            <span class="req-time">
              <svg width="11" height="11" viewBox="0 0 24 24" fill="none">
                <circle cx="12" cy="12" r="9" stroke="#aaa" stroke-width="1.5"/>
                <path d="M12 7v5l3 2" stroke="#aaa" stroke-width="1.5" stroke-linecap="round"/>
              </svg>
              09:15
            </span>
          </div>
          <div class="req-actions">
            <button class="btn-detail">Lihat Detail</button>
          </div>
        </div>

        <!-- Item 3 - Permintaan Persediaan -->
        <div class="request-item">
          <div class="req-top">
            <div class="req-name">Pensil 2B, Cat Air, dan Kertas HVS</div>
            <span class="status-badge diterima">
              <svg width="7" height="7" viewBox="0 0 10 10"><circle cx="5" cy="5" r="5" fill="#10b981"/></svg>
              Diterima
            </span>
          </div>
          <div class="req-type-tag" style="background: #e8f5e9; color: var(--success); border-left: 2px solid var(--success);">
            <i class="fas fa-cubes" style="margin-right: 4px;"></i>Permintaan Persediaan
          </div>
          <div class="req-date">
            <svg width="11" height="11" viewBox="0 0 24 24" fill="none">
              <rect x="3" y="4" width="18" height="18" rx="2" stroke="#aaa" stroke-width="1.5"/>
              <path d="M16 2v4M8 2v4M3 10h18" stroke="#aaa" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
            12 April 2026
            <span class="req-time">
              <svg width="11" height="11" viewBox="0 0 24 24" fill="none">
                <circle cx="12" cy="12" r="9" stroke="#aaa" stroke-width="1.5"/>
                <path d="M12 7v5l3 2" stroke="#aaa" stroke-width="1.5" stroke-linecap="round"/>
              </svg>
              11:45
            </span>
          </div>
          <div class="req-actions">
            <button class="btn-detail">Lihat Detail</button>
          </div>
        </div>
      </div>

      <!-- STATUS RINGKAS -->
      <div class="panel">
        <div class="panel-header">
          <span class="panel-title">
            <i class="fas fa-chart-pie" style="color: var(--primary); margin-right: 6px;"></i>
            Status Ringkas
          </span>
        </div>
        <div style="padding: 16px 0;">
          <!-- Status Barang -->
          <div style="padding: 14px 0; border-bottom: 1px solid #f0f0f0; display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 10px;">
              <i class="fas fa-box" style="width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; background: #dbeafe; color: var(--primary); border-radius: 8px; font-size: 12px;"></i>
              <div>
                <div style="font-size: 12px; font-weight: 600; color: var(--text-primary);">Peminjaman Barang</div>
                <div style="font-size: 11px; color: var(--text-secondary);">2 Menunggu, 2 Disetujui</div>
              </div>
            </div>
            <span style="font-size: 14px; font-weight: 700; color: var(--primary);">5</span>
          </div>

          <!-- Status Kendaraan -->
          <div style="padding: 14px 0; border-bottom: 1px solid #f0f0f0; display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 10px;">
              <i class="fas fa-car" style="width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; background: #fff3e0; color: var(--warning); border-radius: 8px; font-size: 12px;"></i>
              <div>
                <div style="font-size: 12px; font-weight: 600; color: var(--text-primary);">Peminjaman Kendaraan</div>
                <div style="font-size: 11px; color: var(--text-secondary);">1 Menunggu, 1 Disetujui</div>
              </div>
            </div>
            <span style="font-size: 14px; font-weight: 700; color: var(--warning);">2</span>
          </div>

          <!-- Status Persediaan -->
          <div style="padding: 14px 0; display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 10px;">
              <i class="fas fa-cubes" style="width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; background: #e8f5e9; color: var(--success); border-radius: 8px; font-size: 12px;"></i>
              <div>
                <div style="font-size: 12px; font-weight: 600; color: var(--text-primary);">Permintaan Persediaan</div>
                <div style="font-size: 11px; color: var(--text-secondary);">1 Menunggu, 2 Diterima</div>
              </div>
            </div>
            <span style="font-size: 14px; font-weight: 700; color: var(--success);">3</span>
          </div>
        </div>
      </div>

    </div><!-- end bottom-row -->
  </div><!-- end content -->
</div><!-- end main -->

</body>
</html>
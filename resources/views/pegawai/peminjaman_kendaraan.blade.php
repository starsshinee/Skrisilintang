<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SIPANDU - Peminjaman Kendaraan</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
  :root {
    --primary: #2563eb;
    --primary-light: #3b82f6;
    --accent: #06b6d4;
    --accent2: #8b5cf6;
    --success: #10b981;
    --warning: #f59e0b;
    --danger: #ef4444;
    --bg: #f0f4ff;
    --sidebar-bg: #0f172a;
    --sidebar-text: #94a3b8;
    --sidebar-width: 260px;
    --card-bg: #ffffff;
    --text-primary: #0f172a;
    --text-secondary: #64748b;
    --border: #e2e8f0;
    --radius: 16px;
    --radius-sm: 10px;
    --shadow: 0 4px 24px rgba(37,99,235,0.08);
    --shadow-lg: 0 8px 40px rgba(37,99,235,0.14);
    --topbar-height: 80px;
  }

  * { margin: 0; padding: 0; box-sizing: border-box; }

  body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: var(--bg);
    color: var(--text-primary);
    display: flex;
    min-height: 100vh;
  }

  /* ===== SIDEBAR ===== */
  .sidebar {
    width: var(--sidebar-width);
    background: var(--sidebar-bg);
    min-height: 100vh;
    position: fixed;
    left: 0; top: 0; bottom: 0;
    z-index: 200;
    display: flex;
    flex-direction: column;
    transition: transform 0.3s cubic-bezier(.4,0,.2,1);
    overflow-y: auto;
    overflow-x: hidden;
  }

  .sidebar-logo {
    padding: 24px 20px 20px;
    border-bottom: 1px solid rgba(255,255,255,0.06);
  }
  .sidebar-logo-inner {
    display: flex; align-items: center; gap: 10px;
  }
  .logo-icon {
    width: 38px; height: 38px;
    background: var(--primary);
    border-radius: 10px;
    display: grid; place-items: center;
    font-size: 17px; color: #fff;
    flex-shrink: 0;
  }
  .logo-text { font-family: 'Space Grotesk', sans-serif; font-size: 18px; font-weight: 700; color: #fff; }
  .logo-sub { font-size: 10px; color: var(--sidebar-text); margin-top: 1px; }

  .sidebar-section { padding: 20px 14px 0; }
  .sidebar-section-label {
    font-size: 10px; font-weight: 700; color: #475569;
    text-transform: uppercase; letter-spacing: 1px;
    padding: 0 8px; margin-bottom: 8px;
  }

  .nav-item {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 10px;
    border-radius: 10px;
    cursor: pointer;
    margin-bottom: 2px;
    text-decoration: none;
    transition: all .18s;
    color: var(--sidebar-text);
    font-size: 13px; font-weight: 500;
  }
  .nav-item i { width: 18px; text-align: center; font-size: 14px; }
  .nav-item:hover { background: rgba(255,255,255,0.06); color: #fff; }
  .nav-item.active { background: rgba(37,99,235,0.22); color: #93c5fd; }
  .nav-item.active i { color: #60a5fa; }

  .nav-badge {
    margin-left: auto;
    background: var(--primary);
    color: #fff;
    font-size: 10px; font-weight: 700;
    padding: 2px 7px; border-radius: 20px;
  }

  .sidebar-user {
    margin-top: auto;
    padding: 16px 14px;
    border-top: 1px solid rgba(255,255,255,0.06);
  }
  .user-card {
    display: flex; align-items: center; gap: 10px;
    padding: 10px;
    border-radius: 10px;
    cursor: pointer;
    transition: all .18s;
  }
  .user-card:hover { background: rgba(255,255,255,0.06); }
  .user-avatar {
    width: 36px; height: 36px;
    border-radius: 10px;
    background: linear-gradient(135deg, var(--primary), var(--accent));
    display: grid; place-items: center;
    font-size: 14px; font-weight: 700; color: #fff;
    flex-shrink: 0;
  }
  .user-name { font-size: 13px; font-weight: 600; color: #fff; }
  .user-role { font-size: 11px; color: var(--sidebar-text); margin-top: 1px; }

  /* OVERLAY for mobile */
  .sidebar-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.5);
    z-index: 190;
    backdrop-filter: blur(2px);
  }
  .sidebar-overlay.show { display: block; }

  /* ===== MAIN ===== */
  .main {
    margin-left: var(--sidebar-width);
    flex: 1;
    padding: 0 28px 40px;
    min-width: 0;
    transition: margin-left 0.3s cubic-bezier(.4,0,.2,1);
  }

  /* ===== TOPBAR ===== */
  .topbar {
    display: flex; align-items: center; justify-content: space-between;
    padding: 20px 0 20px;
    position: sticky; top: 0; z-index: 50;
    background: var(--bg);
    border-bottom: 1px solid transparent;
  }
  .topbar-left { display: flex; align-items: center; gap: 14px; }
  .hamburger-btn {
    display: none;
    width: 40px; height: 40px;
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 10px;
    cursor: pointer;
    align-items: center; justify-content: center;
    font-size: 16px; color: var(--text-secondary);
    flex-shrink: 0;
    transition: all .2s;
  }
  .hamburger-btn:hover { border-color: var(--primary); color: var(--primary); }
  .breadcrumb { font-size: 13px; color: var(--text-secondary); display: flex; align-items: center; gap: 6px; }
  .breadcrumb span { color: var(--primary); font-weight: 600; }
  .topbar-title { font-family: 'Space Grotesk', sans-serif; font-size: 22px; font-weight: 700; }
  .topbar-right { display: flex; align-items: center; gap: 12px; }
  .notif-btn {
    width: 40px; height: 40px;
    background: var(--card-bg); border: 1px solid var(--border);
    border-radius: 10px; display: grid; place-items: center;
    cursor: pointer; position: relative; color: var(--text-secondary); transition: all .2s;
    flex-shrink: 0;
  }
  .notif-btn:hover { border-color: var(--primary); color: var(--primary); }
  .notif-dot { position: absolute; top: 8px; right: 8px; width: 7px; height: 7px; background: var(--danger); border-radius: 50%; border: 1.5px solid var(--card-bg); }

  /* ===== CONTENT GRID ===== */
  .content-grid {
    display: grid;
    grid-template-columns: 1fr 1.4fr;
    gap: 24px;
    align-items: start;
  }

  /* ===== FORM CARD ===== */
  .form-card {
    background: var(--card-bg);
    border-radius: var(--radius);
    border: 1px solid var(--border);
    box-shadow: var(--shadow);
    overflow: hidden;
    position: sticky;
    top: 90px;
    height: fit-content;
  }
  .form-header {
    padding: 24px 24px 20px;
    background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
    position: relative; overflow: hidden;
  }
  .form-header::before {
    content: '';
    position: absolute; right: -30px; top: -30px;
    width: 120px; height: 120px;
    border-radius: 50%;
    background: rgba(255,255,255,0.08);
  }
  .form-header-icon {
    position: relative; z-index: 1;
    width: 46px; height: 46px;
    background: rgba(255,255,255,0.2);
    border-radius: 13px;
    display: grid; place-items: center;
    font-size: 20px; color: #fff;
    margin-bottom: 12px;
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,0.2);
  }
  .form-header-title { font-family: 'Space Grotesk', sans-serif; font-size: 18px; font-weight: 700; color: #fff; }
  .form-header-sub { font-size: 12px; color: rgba(255,255,255,0.75); margin-top: 4px; }

  .form-body { padding: 20px 24px; }

  .form-group { margin-bottom: 16px; }
  .form-label {
    display: flex; align-items: center; gap: 6px;
    font-size: 11px; font-weight: 700; color: var(--text-secondary);
    text-transform: uppercase; letter-spacing: .6px;
    margin-bottom: 7px;
  }
  .form-label i { color: var(--primary); font-size: 10px; }
  .form-label .req { color: var(--danger); }

  .form-input, .form-select, .form-textarea {
    width: 100%;
    padding: 10px 13px;
    border: 1.5px solid var(--border);
    border-radius: 10px;
    font-size: 13px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: var(--text-primary);
    background: #fff;
    transition: all .2s;
    outline: none;
  }
  .form-input:focus, .form-select:focus, .form-textarea:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
  }
  .form-input::placeholder, .form-textarea::placeholder { color: #b0bcd4; }
  .form-select {
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2.5'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 14px center;
    padding-right: 36px; cursor: pointer;
  }
  .form-textarea { resize: vertical; min-height: 86px; }

  .input-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

  .submit-btn {
    width: 100%;
    padding: 13px;
    background: linear-gradient(135deg, var(--primary), var(--primary-light));
    color: #fff;
    border: none;
    border-radius: 11px;
    font-size: 13px;
    font-weight: 700;
    font-family: 'Plus Jakarta Sans', sans-serif;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    transition: all .2s;
    box-shadow: 0 4px 14px rgba(37,99,235,0.35);
    margin-top: 6px;
  }
  .submit-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(37,99,235,0.4); }
  .submit-btn:active { transform: translateY(0); }

  /* ===== HISTORY ===== */
  .history-card {
    background: var(--card-bg);
    border-radius: var(--radius);
    border: 1px solid var(--border);
    box-shadow: var(--shadow);
    overflow: hidden;
  }
  .history-header {
    padding: 20px 22px 16px;
    display: flex; align-items: center; justify-content: space-between;
    border-bottom: 1px solid var(--border);
    flex-wrap: wrap; gap: 12px;
  }
  .history-title {
    font-family: 'Space Grotesk', sans-serif;
    font-size: 16px; font-weight: 700; color: var(--text-primary);
    display: flex; align-items: center; gap: 8px;
  }
  .history-title i { color: var(--primary); }
  .filter-tabs { display: flex; gap: 5px; flex-wrap: wrap; }
  .filter-tab {
    font-size: 11px; font-weight: 600; padding: 5px 11px;
    border-radius: 7px; cursor: pointer; border: 1.5px solid var(--border);
    background: transparent; color: var(--text-secondary);
    transition: all .2s; font-family: 'Plus Jakarta Sans', sans-serif;
  }
  .filter-tab.active { background: var(--primary); color: #fff; border-color: var(--primary); }
  .filter-tab:hover:not(.active) { border-color: var(--primary); color: var(--primary); }

  .req-list { padding: 18px 22px; display: flex; flex-direction: column; gap: 14px; }

  .req-card {
    border: 1.5px solid var(--border);
    border-radius: 14px;
    overflow: hidden;
    transition: all .2s;
  }
  .req-card:hover { box-shadow: var(--shadow); transform: translateY(-1px); }
  .req-card-top {
    padding: 15px 16px;
    display: flex; align-items: flex-start; justify-content: space-between;
    gap: 10px;
  }
  .req-card-icon {
    width: 40px; height: 40px; border-radius: 11px;
    display: grid; place-items: center;
    font-size: 16px; flex-shrink: 0;
  }
  .req-card-name { font-size: 13px; font-weight: 700; color: var(--text-primary); }
  .req-card-code { font-size: 11px; color: var(--text-secondary); margin-top: 2px; }
  .status-badge {
    font-size: 10px; font-weight: 700; padding: 4px 10px; border-radius: 7px;
    letter-spacing: .3px; display: flex; align-items: center; gap: 5px;
    white-space: nowrap; flex-shrink: 0;
  }
  .status-badge.approved { background: rgba(16,185,129,0.1); color: var(--success); border: 1px solid rgba(16,185,129,0.2); }
  .status-badge.pending { background: rgba(245,158,11,0.1); color: var(--warning); border: 1px solid rgba(245,158,11,0.2); }
  .status-badge.rejected { background: rgba(239,68,68,0.1); color: var(--danger); border: 1px solid rgba(239,68,68,0.2); }
  .status-badge i { font-size: 8px; }

  .req-card-meta {
    padding: 11px 16px;
    background: #f8faff;
    display: grid; grid-template-columns: 1fr 1fr;
    gap: 10px;
    border-top: 1px solid #eef1ff;
  }
  .meta-label { font-size: 10px; text-transform: uppercase; letter-spacing: .6px; color: #94a3b8; font-weight: 700; margin-bottom: 2px; }
  .meta-value { font-size: 12px; font-weight: 600; color: var(--text-primary); }

  .req-card-footer {
    padding: 11px 16px;
    display: flex; gap: 8px;
    border-top: 1px solid #eef1ff;
  }
  .card-btn {
    flex: 1; padding: 9px;
    border-radius: 8px;
    font-size: 12px; font-weight: 600;
    cursor: pointer; border: none;
    display: flex; align-items: center; justify-content: center; gap: 6px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    transition: all .2s;
  }
  .card-btn.detail { background: rgba(37,99,235,0.08); color: var(--primary); }
  .card-btn.detail:hover { background: rgba(37,99,235,0.15); }
  .card-btn.cancel { background: rgba(239,68,68,0.08); color: var(--danger); }
  .card-btn.cancel:hover { background: rgba(239,68,68,0.15); }

  /* ===== TOAST ===== */
  #toast {
    position: fixed; bottom: 24px; right: 24px;
    background: #0f172a; color: #fff;
    padding: 14px 20px; border-radius: 12px;
    font-size: 13px; font-weight: 600;
    display: flex; align-items: center; gap: 10px;
    transform: translateY(80px); opacity: 0;
    transition: all .35s cubic-bezier(.4,0,.2,1);
    z-index: 9999; box-shadow: 0 8px 24px rgba(0,0,0,0.25);
    pointer-events: none; max-width: calc(100vw - 48px);
  }

  @keyframes fadeUp { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: translateY(0); } }
  .animate { animation: fadeUp .5s ease both; }
  .d1 { animation-delay: .05s; } .d2 { animation-delay: .1s; } .d3 { animation-delay: .15s; }

  ::-webkit-scrollbar { width: 5px; }
  ::-webkit-scrollbar-track { background: transparent; }
  ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

  /* ===== RESPONSIVE BREAKPOINTS ===== */

  @media (max-width: 900px) and (min-width: 769px) {
    .main { padding: 0 20px 40px; }
    .topbar-title { font-size: 18px; }
    .content-grid { gap: 16px; }
  }

  /* Mobile: sidebar hidden by default, hamburger visible */
  @media (max-width: 768px) {
    .sidebar {
      transform: translateX(-100%);
    }
    .sidebar.open {
      transform: translateX(0);
      box-shadow: 4px 0 30px rgba(0,0,0,0.3);
    }

    .main {
      margin-left: 0;
      padding: 0 16px 40px;
    }

    .hamburger-btn {
      display: flex;
    }

    .topbar {
      padding: 14px 0;
    }
    .topbar-title { font-size: 16px; }
    .breadcrumb { display: none; }

    .content-grid {
      grid-template-columns: 1fr;
      gap: 16px;
    }

    .form-card { position: static; }

    .form-header { padding: 20px 18px 16px; }
    .form-body { padding: 16px 18px; }

    .input-row { grid-template-columns: 1fr; gap: 0; }

    .history-header {
      padding: 16px 16px 12px;
    }
    .req-list { padding: 14px 16px; gap: 12px; }

    .req-card-meta {
      grid-template-columns: 1fr;
    }

    #toast {
      bottom: 16px; right: 16px; left: 16px;
      max-width: none;
    }
  }

  @media (max-width: 400px) {
    .filter-tabs { gap: 4px; }
    .filter-tab { padding: 4px 8px; font-size: 10px; }
  }
</style>
</head>
<body>

<!-- SIDEBAR OVERLAY -->
@include('partials.sidebar')

<!-- MAIN -->
<main class="main">
  <!-- TOPBAR -->
  <div class="topbar">
    <div class="topbar-left">
      <button class="hamburger-btn" onclick="toggleSidebar()" aria-label="Toggle menu">
        <i class="fas fa-bars"></i>
      </button>
      <div>
        <div class="breadcrumb">
          <a href="#" style="text-decoration:none;color:var(--text-secondary)">Dashboard</a>
          <i class="fas fa-chevron-right" style="font-size:9px"></i>
          <span>Peminjaman Kendaraan</span>
        </div>
        <div class="topbar-title">Peminjaman Kendaraan</div>
      </div>
    </div>
    <div class="topbar-right">
      <div class="notif-btn"><i class="fas fa-bell"></i><div class="notif-dot"></div></div>
    </div>
  </div>

  <!-- CONTENT -->
  <div class="content-grid">

    <!-- FORM -->
    <div class="form-card animate d2" id="formCard">
      <div class="form-header">
        <div class="form-header-icon"><i class="fas fa-car"></i></div>
        <div class="form-header-title">Buat Permintaan</div>
        <div class="form-header-sub">Isi formulir peminjaman Kendaraan di bawah ini</div>
      </div>
      <div class="form-body">
        <div class="form-group">
          <div class="form-label"><i class="fas fa-user"></i> Nama Lengkap <span class="req">*</span></div>
          <input type="text" class="form-input" placeholder="Masukkan nama lengkap Anda" id="namaInput">
        </div>
        <div class="form-group">
          <div class="form-label"><i class="fas fa-car-side"></i> Nama Kendaraan <span class="req">*</span></div>
          <input type="text" class="form-input" placeholder="Contoh: Toyota Kijang Innova" id="namaKendaraanInput">
        </div>
        <div class="form-group">
          <div class="form-label"><i class="fas fa-hashtag"></i> Jumlah Kendaraan <span class="req">*</span></div>
          <input type="number" class="form-input" placeholder="Masukkan jumlah kendaraan" min="1" id="jumlahBarangInput">
        </div>
        <div class="input-row">
          <div class="form-group">
            <div class="form-label"><i class="fas fa-calendar"></i> Tgl Pinjam <span class="req">*</span></div>
            <input type="date" class="form-input" id="tglPinjam">
          </div>
          <div class="form-group">
            <div class="form-label"><i class="fas fa-calendar-check"></i> Tgl Kembali <span class="req">*</span></div>
            <input type="date" class="form-input" id="tglKembali">
          </div>
        </div>
        <div class="form-group">
          <div class="form-label"><i class="fas fa-bullseye"></i> Tujuan Penggunaan <span class="req">*</span></div>
          <textarea class="form-textarea" placeholder="Jelaskan tujuan peminjaman secara singkat dan jelas..." id="tujuanInput"></textarea>
        </div>
        <button class="submit-btn" onclick="submitForm()">
          <i class="fas fa-paper-plane"></i> Kirim Permintaan
        </button>
      </div>
    </div>

    <!-- RIWAYAT -->
    <div>
      <div class="history-card animate d3">
        <div class="history-header">
          <div class="history-title"><i class="fas fa-clock-rotate-left"></i> Riwayat Permintaan</div>
          <div class="filter-tabs">
            <button class="filter-tab active" onclick="filterTab(this,'all')">Semua</button>
            <button class="filter-tab" onclick="filterTab(this,'pending')">Pending</button>
            <button class="filter-tab" onclick="filterTab(this,'approved')">Disetujui</button>
            <button class="filter-tab" onclick="filterTab(this,'rejected')">Ditolak</button>
          </div>
        </div>
        <div class="req-list" id="riwayatList">

          <div class="req-card" data-status="approved">
            <div class="req-card-top">
              <div style="display:flex;align-items:center;gap:11px">
                <div class="req-card-icon" style="background:rgba(37,99,235,0.1);color:#2563eb"><i class="fas fa-van-shuttle"></i></div>
                <div>
                  <div class="req-card-name">Minibus Dinas</div>
                  <div class="req-card-code">REQ-KND-001</div>
                </div>
              </div>
              <div class="status-badge approved"><i class="fas fa-circle"></i> Disetujui</div>
            </div>
            <div class="req-card-meta">
              <div class="meta-item"><div class="meta-label">Nama</div><div class="meta-value">Ahmad Fauzi</div></div>
              <div class="meta-item"><div class="meta-label">Tujuan</div><div class="meta-value">Survey Lapangan</div></div>
              <div class="meta-item"><div class="meta-label">Tgl Permintaan</div><div class="meta-value">15 Jan 2025</div></div>
              <div class="meta-item"><div class="meta-label">Tgl Pinjam – Kembali</div><div class="meta-value">20 Jan – 21 Jan 2025</div></div>
            </div>
            <div class="req-card-footer">
              <button class="card-btn detail"><i class="fas fa-eye"></i> Detail</button>
            </div>
          </div>

          <div class="req-card" data-status="pending">
            <div class="req-card-top">
              <div style="display:flex;align-items:center;gap:11px">
                <div class="req-card-icon" style="background:rgba(6,182,212,0.1);color:#06b6d4"><i class="fas fa-car"></i></div>
                <div>
                  <div class="req-card-name">Sedan Operasional</div>
                  <div class="req-card-code">REQ-KND-002</div>
                </div>
              </div>
              <div class="status-badge pending"><i class="fas fa-circle"></i> Menunggu</div>
            </div>
            <div class="req-card-meta">
              <div class="meta-item"><div class="meta-label">Nama</div><div class="meta-value">Sari Wulandari</div></div>
              <div class="meta-item"><div class="meta-label">Tujuan</div><div class="meta-value">Dinas Luar Kota</div></div>
              <div class="meta-item"><div class="meta-label">Tgl Permintaan</div><div class="meta-value">12 Jan 2025</div></div>
              <div class="meta-item"><div class="meta-label">Tgl Pinjam – Kembali</div><div class="meta-value">18 Jan – 18 Jan 2025</div></div>
            </div>
            <div class="req-card-footer">
              <button class="card-btn detail"><i class="fas fa-eye"></i> Detail</button>
              <button class="card-btn cancel"><i class="fas fa-xmark"></i> Batalkan</button>
            </div>
          </div>

          <div class="req-card" data-status="rejected">
            <div class="req-card-top">
              <div style="display:flex;align-items:center;gap:11px">
                <div class="req-card-icon" style="background:rgba(139,92,246,0.1);color:#8b5cf6"><i class="fas fa-truck"></i></div>
                <div>
                  <div class="req-card-name">Pickup Barang</div>
                  <div class="req-card-code">REQ-KND-003</div>
                </div>
              </div>
              <div class="status-badge rejected"><i class="fas fa-circle"></i> Ditolak</div>
            </div>
            <div class="req-card-meta">
              <div class="meta-item"><div class="meta-label">Nama</div><div class="meta-value">Budi Santoso</div></div>
              <div class="meta-item"><div class="meta-label">Tujuan</div><div class="meta-value">Pengiriman Logistik</div></div>
              <div class="meta-item"><div class="meta-label">Tgl Permintaan</div><div class="meta-value">10 Jan 2025</div></div>
              <div class="meta-item"><div class="meta-label">Tgl Pinjam – Kembali</div><div class="meta-value">15 Jan – 15 Jan 2025</div></div>
            </div>
            <div class="req-card-footer">
              <button class="card-btn detail"><i class="fas fa-eye"></i> Detail</button>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</main>

<!-- TOAST -->
<div id="toast">
  <i class="fas fa-circle-check" style="color:#10b981;font-size:16px"></i>
  <span id="toastMsg">Permintaan berhasil dikirim!</span>
</div>

<script>
  /* Sidebar toggle */
  function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    sidebar.classList.toggle('open');
    overlay.classList.toggle('show');
    document.body.style.overflow = sidebar.classList.contains('open') ? 'hidden' : '';
  }

  function closeSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    sidebar.classList.remove('open');
    overlay.classList.remove('show');
    document.body.style.overflow = '';
  }

  /* Close sidebar on resize to desktop */
  window.addEventListener('resize', () => {
    if (window.innerWidth > 768) closeSidebar();
  });

  /* Filter tabs */
  function filterTab(el, filter) {
    document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
    document.querySelectorAll('.req-card').forEach(card => {
      card.style.display = (filter === 'all' || card.dataset.status === filter) ? '' : 'none';
    });
  }

  /* Form submit */
  function submitForm() {
    const nama = document.getElementById('namaInput').value.trim();
    const kendaraan = document.getElementById('namaKendaraanInput').value.trim();
    const jumlah = document.getElementById('jumlahBarangInput').value.trim();
    const tglPinjam = document.getElementById('tglPinjam').value;
    const tglKembali = document.getElementById('tglKembali').value;
    const tujuan = document.getElementById('tujuanInput').value.trim();

    if (!nama || !kendaraan || !jumlah || !tglPinjam || !tglKembali || !tujuan) {
      showToast('Harap lengkapi semua field yang wajib diisi.', 'error');
      return;
    }
    showToast('Permintaan berhasil dikirim! Menunggu persetujuan.', 'success');
  }

  function showToast(msg, type = 'success') {
    const toast = document.getElementById('toast');
    const icon = toast.querySelector('i');
    document.getElementById('toastMsg').textContent = msg;
    icon.style.color = type === 'error' ? '#ef4444' : '#10b981';
    icon.className = type === 'error' ? 'fas fa-circle-exclamation' : 'fas fa-circle-check';
    icon.style.fontSize = '16px';
    toast.style.transform = 'translateY(0)';
    toast.style.opacity = '1';
    setTimeout(() => {
      toast.style.transform = 'translateY(80px)';
      toast.style.opacity = '0';
    }, 3500);
  }

  /* Set min date for date inputs */
  const today = new Date().toISOString().split('T')[0];
  document.getElementById('tglPinjam').min = today;
  document.getElementById('tglKembali').min = today;
  document.getElementById('tglPinjam').addEventListener('change', function() {
    document.getElementById('tglKembali').min = this.value;
  });
</script>
</body>
</html>
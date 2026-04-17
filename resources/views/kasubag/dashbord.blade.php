<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Kasubag</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
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
    --blue: #3b6ff0;
    --blue-light: #eef2ff;
    --orange: #f59e0b;
    --orange-light: #fffbeb;
    --green: #10b981;
    --green-light: #ecfdf5;
    --red: #ef4444;
    --red-light: #fef2f2;
    --purple: #8b5cf6;
    --purple-light: #f5f3ff;
    --gray-50: #f8fafc;
    --gray-100: #f1f5f9;
    --gray-200: #e2e8f0;
    --gray-400: #94a3b8;
    --gray-600: #475569;
    --gray-800: #1e293b;
    --sidebar-w: 240px;
  }
  body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); color: var(--gray-800); display: flex; min-height: 100vh; }

  /* SIDEBAR */
  .sidebar {
    width: var(--sidebar-w);
    background: #fff;
    border-right: 1px solid var(--gray-200);
    display: flex;
    flex-direction: column;
    position: fixed;
    top: 0; left: 0; bottom: 0;
    z-index: 10;
  }
  .sidebar-brand {
    padding: 20px 20px 16px;
    border-bottom: 1px solid var(--gray-100);
    display: flex;
    align-items: center;
    gap: 12px;
  }
  .brand-icon {
    width: 40px; height: 40px;
    background: var(--blue);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
  }
  .brand-icon svg { width: 22px; height: 22px; fill: #fff; }
  .brand-text h2 { font-size: 14px; font-weight: 700; color: var(--gray-800); }
  .brand-text p { font-size: 11px; color: var(--gray-400); margin-top: 1px; }
  .nav { padding: 12px 12px; flex: 1; }
  .nav-item {
    display: flex; align-items: center; gap: 10px;
    padding: 9px 12px;
    border-radius: 8px;
    font-size: 13.5px;
    font-weight: 500;
    color: var(--gray-600);
    cursor: pointer;
    text-decoration: none;
    transition: all .15s;
    margin-bottom: 2px;
  }
  .nav-item:hover { background: var(--gray-100); }
  .nav-item.active { background: var(--blue-light); color: var(--blue); font-weight: 600; }
  .nav-item svg { width: 18px; height: 18px; flex-shrink: 0; }
  .nav-section-label {
    font-size: 11px;
    font-weight: 600;
    color: var(--gray-400);
    text-transform: uppercase;
    letter-spacing: .06em;
    padding: 12px 12px 6px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    cursor: pointer;
  }
  .nav-section-label svg { width: 14px; height: 14px; transition: transform .2s; }
  .badge {
    margin-left: auto;
    background: var(--orange-light);
    color: var(--orange);
    font-size: 11px;
    font-weight: 700;
    padding: 1px 7px;
    border-radius: 20px;
  }

  /* ── MAIN CONTENT ── */
  .main { margin-left: 256px; flex: 1; padding: 0 32px 32px; }

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

  /* MAIN */
  /* .main {
    margin-left: var(--sidebar-w);
    margin-top: 60px;
    padding: 32px 32px;
    flex: 1;
    min-height: calc(100vh - 60px);
  }
  .page-header { margin-bottom: 28px; }
  .page-header h1 { font-size: 22px; font-weight: 700; }
  .page-header p { font-size: 13.5px; color: var(--gray-400); margin-top: 3px; } */

  /* STAT CARDS */
  .stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 28px; }
  .stat-card {
    background: #fff;
    border: 1px solid var(--gray-200);
    border-radius: 14px;
    padding: 20px 22px;
    display: flex;
    flex-direction: column;
    gap: 10px;
  }
  .stat-icon { width: 38px; height: 38px; border-radius: 10px; display: flex; align-items: center; justify-content: center; }
  .stat-icon svg { width: 20px; height: 20px; stroke-width: 2; fill: none; stroke: currentColor; }
  .stat-icon.orange { background: var(--orange-light); color: var(--orange); }
  .stat-icon.green { background: var(--green-light); color: var(--green); }
  .stat-icon.red { background: var(--red-light); color: var(--red); }
  .stat-icon.blue { background: var(--blue-light); color: var(--blue); }
  .stat-value { font-size: 30px; font-weight: 700; line-height: 1; }
  .stat-label { font-size: 12.5px; color: var(--gray-400); font-weight: 500; }

  /* BOTTOM GRID */
  .bottom-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
  .card { background: #fff; border: 1px solid var(--gray-200); border-radius: 14px; padding: 22px; }
  .card-title { font-size: 14px; font-weight: 700; margin-bottom: 18px; }

  /* CATEGORY BARS */
  .cat-row { display: flex; align-items: center; gap: 12px; margin-bottom: 14px; }
  .cat-row:last-child { margin-bottom: 0; }
  .cat-icon { width: 26px; height: 26px; border-radius: 7px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
  .cat-icon svg { width: 14px; height: 14px; stroke-width: 2; fill: none; stroke: currentColor; }
  .cat-label { font-size: 13px; font-weight: 500; width: 90px; }
  .bar-wrap { flex: 1; background: var(--gray-100); border-radius: 999px; height: 24px; overflow: hidden; }
  .bar { height: 100%; border-radius: 999px; display: flex; align-items: center; justify-content: flex-end; padding-right: 10px; font-size: 11.5px; font-weight: 600; color: #fff; }
  .bar.blue { background: #93c5fd; color: #1e40af; }
  .bar.purple { background: #c4b5fd; color: #6d28d9; }
  .bar.orange { background: #fcd34d; color: #92400e; }
  .bar.green { background: #6ee7b7; color: #065f46; }

  /* PENDING LIST */
  .pending-item {
    display: flex; align-items: center; gap: 12px;
    padding: 10px 0;
    border-bottom: 1px solid var(--gray-100);
  }
  .pending-item:last-child { border-bottom: none; }
  .pending-ico { width: 34px; height: 34px; border-radius: 9px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
  .pending-ico svg { width: 16px; height: 16px; stroke-width: 2; fill: none; stroke: currentColor; }
  .pending-ico.blue { background: var(--blue-light); color: var(--blue); }
  .pending-ico.purple { background: var(--purple-light); color: var(--purple); }
  .pending-ico.orange { background: var(--orange-light); color: var(--orange); }
  .pending-ico.green { background: var(--green-light); color: var(--green); }
  .pending-text { flex: 1; }
  .pending-text strong { font-size: 13px; font-weight: 600; display: block; }
  .pending-text span { font-size: 11.5px; color: var(--gray-400); }
  .badge-pending { background: var(--orange-light); color: var(--orange); font-size: 11px; font-weight: 600; padding: 3px 9px; border-radius: 20px; white-space: nowrap; }
</style>
</head>
<body>

@include('partials.sidebar')

<!-- MAIN CONTENT -->
<main class="main">
  <!-- TOPBAR -->
  <div class="topbar">
    <div class="topbar-title">Dashboard Kasubag</div>
    <div class="topbar-right">
      <div class="topbar-date">
        <i class="fas fa-calendar" style="color:var(--primary)"></i>
        Rabu, 15 April 2026
      </div>
      <div class="notif-btn">
        <i class="fas fa-bell"></i>
        <div class="notif-dot"></div>
      </div>
    </div>
  </div>

  <!-- HERO BANNER -->
  <div class="hero animate d1">
    <div class="hero-blob"></div>
    <div class="hero-blob2"></div>
    <div class="hero-left">
      <div class="hero-greeting">👋 Selamat datang kembali!</div>
      <div class="hero-title">Halo, Kasubag!</div>
      <div class="hero-sub">Sebagai Kasubag, Anda dapat mengelola dan mengelola permintaan peminjaman aset dan fasilitas BPMP Provinsi Gorontalo.</div>
    </div>
    <div class="hero-right">
      <div class="hero-inst">Instansi: BPMP Provinsi Gorontalo</div>
      <div class="hero-nip">NIP: 0983654321</div>
      <a href="{{ route('tamu.pengaturan-akun') }}" class="hero-btn">
        <i class="fas fa-gear"></i> Pengaturan Akun
      </a>
    </div>
  </div>

  <div class="stats">
    <div class="stat-card">
      <div class="stat-icon orange">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
      </div>
      <div class="stat-value">8</div>
      <div class="stat-label">Menunggu Verifikasi</div>
    </div>
    <div class="stat-card">
      <div class="stat-icon green">
        <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
      </div>
      <div class="stat-value">0</div>
      <div class="stat-label">Disetujui</div>
    </div>
    <div class="stat-card">
      <div class="stat-icon red">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
      </div>
      <div class="stat-value">0</div>
      <div class="stat-label">Ditolak</div>
    </div>
    <div class="stat-card">
      <div class="stat-icon blue">
        <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
      </div>
      <div class="stat-value">8</div>
      <div class="stat-label">Total Permintaan</div>
    </div>
  </div>

  <div class="bottom-grid">
    <!-- Permintaan per Kategori -->
    <div class="card">
      <div class="card-title">Permintaan per Kategori</div>
      <div class="cat-row">
        <div class="cat-icon blue" style="background:#eff6ff;color:#3b82f6">
          <svg viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
        </div>
        <span class="cat-label">Barang</span>
        <div class="bar-wrap"><div class="bar blue" style="width:100%">2 (2 pending)</div></div>
      </div>
      <div class="cat-row">
        <div class="cat-icon" style="background:#f5f3ff;color:#8b5cf6">
          <svg viewBox="0 0 24 24"><path d="M5 17H3a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v9a2 2 0 0 1-2 2h-1"/><circle cx="7.5" cy="17.5" r="2.5"/><circle cx="17.5" cy="17.5" r="2.5"/></svg>
        </div>
        <span class="cat-label">Kendaraan</span>
        <div class="bar-wrap"><div class="bar purple" style="width:100%">2 (2 pending)</div></div>
      </div>
      <div class="cat-row">
        <div class="cat-icon" style="background:#fffbeb;color:#f59e0b">
          <svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
        </div>
        <span class="cat-label">Gedung</span>
        <div class="bar-wrap"><div class="bar orange" style="width:100%">2 (2 pending)</div></div>
      </div>
      <div class="cat-row">
        <div class="cat-icon" style="background:#ecfdf5;color:#10b981">
          <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14"/><path d="M4.93 4.93a10 10 0 0 0 0 14.14"/></svg>
        </div>
        <span class="cat-label">Persediaan</span>
        <div class="bar-wrap"><div class="bar green" style="width:100%">2 (2 pending)</div></div>
      </div>
    </div>

    <!-- Permintaan Terbaru Menunggu -->
    <div class="card">
      <div class="card-title">Permintaan Terbaru Menunggu</div>
      <div class="pending-item">
        <div class="pending-ico blue">
          <svg viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
        </div>
        <div class="pending-text">
          <strong>Proyektor Epson EB-X51</strong>
          <span>Budi Santoso · 2024-12-10</span>
        </div>
        <span class="badge-pending">Pending</span>
      </div>
      <div class="pending-item">
        <div class="pending-ico purple">
          <svg viewBox="0 0 24 24"><path d="M5 17H3a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v9a2 2 0 0 1-2 2h-1"/><circle cx="7.5" cy="17.5" r="2.5"/><circle cx="17.5" cy="17.5" r="2.5"/></svg>
        </div>
        <div class="pending-text">
          <strong>Toyota Avanza (B 1234 CD)</strong>
          <span>Siti Rahmawati · 2024-12-11</span>
        </div>
        <span class="badge-pending">Pending</span>
      </div>
      <div class="pending-item">
        <div class="pending-ico orange">
          <svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
        </div>
        <div class="pending-text">
          <strong>Aula Lt.3 (Kapasitas 200)</strong>
          <span>Ahmad Fauzi · 2024-12-11</span>
        </div>
        <span class="badge-pending">Pending</span>
      </div>
      <div class="pending-item">
        <div class="pending-ico green">
          <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14"/><path d="M4.93 4.93a10 10 0 0 0 0 14.14"/></svg>
        </div>
        <div class="pending-text">
          <strong>Kertas A4 (10 rim), Tinta Printer (5 set)</strong>
          <span>Dewi Lestari · 2024-12-12</span>
        </div>
        <span class="badge-pending">Pending</span>
      </div>
    </div>
  </div>
</main>

</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SIBMN - Informasi Fasilitas</title>
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
    --card-bg: #ffffff;
    --text-primary: #0f172a;
    --text-secondary: #64748b;
    --border: #e2e8f0;
    --radius: 16px;
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

  /* ── MAIN CONTENT ── */
  .main { margin-left: 260px; flex: 1; padding: 0 32px 40px; }

  /* TOP BAR */
  .topbar {
    display: flex; align-items: center; justify-content: space-between;
    padding: 20px 0 24px;
    position: sticky; top: 0; z-index: 50;
    background: var(--bg);
  }
  .topbar-left {}
  .breadcrumb { font-size: 13px; color: var(--text-secondary); display: flex; align-items: center; gap: 6px; margin-bottom: 4px; }
  .breadcrumb a { color: var(--text-secondary); text-decoration: none; }
  .breadcrumb a:hover { color: var(--primary); }
  .breadcrumb span { color: var(--primary); font-weight: 600; }
  .topbar-title { font-family: 'Space Grotesk', sans-serif; font-size: 22px; font-weight: 700; color: var(--text-primary); }
  .topbar-right { display: flex; align-items: center; gap: 12px; }
  .notif-btn {
    width: 40px; height: 40px;
    background: var(--card-bg); border: 1px solid var(--border);
    border-radius: 10px; display: grid; place-items: center;
    cursor: pointer; position: relative; color: var(--text-secondary); transition: all .2s;
  }
  .notif-btn:hover { border-color: var(--primary); color: var(--primary); }
  .notif-dot { position: absolute; top: 8px; right: 8px; width: 7px; height: 7px; background: var(--danger); border-radius: 50%; border: 1.5px solid var(--card-bg); }

  /* HERO BANNER */
  .hero {
    background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 55%, #0891b2 100%);
    border-radius: 20px;
    padding: 32px 36px;
    display: flex; align-items: center; justify-content: space-between;
    position: relative; overflow: hidden;
    margin-bottom: 32px;
    box-shadow: 0 8px 32px rgba(37,99,235,0.28);
  }
  .hero::before {
    content: '';
    position: absolute; inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
  }
  .hero-blob { position: absolute; width: 280px; height: 280px; border-radius: 50%; background: rgba(255,255,255,0.05); right: -50px; top: -70px; pointer-events: none; }
  .hero-left { position: relative; z-index: 2; }
  .hero-tag { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.15); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.2); color: rgba(255,255,255,0.9); font-size: 12px; font-weight: 600; padding: 5px 12px; border-radius: 20px; margin-bottom: 12px; }
  .hero-title { font-family: 'Space Grotesk', sans-serif; font-size: 26px; font-weight: 800; color: #fff; margin-bottom: 8px; }
  .hero-sub { font-size: 14px; color: rgba(255,255,255,0.75); max-width: 420px; line-height: 1.6; }
  .hero-right { position: relative; z-index: 2; }
  .hero-stat { text-align: center; }
  .hero-stat-num { font-family: 'Space Grotesk', sans-serif; font-size: 42px; font-weight: 800; color: #fff; line-height: 1; }
  .hero-stat-label { font-size: 13px; color: rgba(255,255,255,0.7); margin-top: 4px; }
  .hero-btn {
    display: inline-flex; align-items: center; gap: 8px; margin-top: 14px;
    background: rgba(255,255,255,0.18); backdrop-filter: blur(8px);
    border: 1.5px solid rgba(255,255,255,0.25);
    color: #fff; font-size: 13px; font-weight: 600;
    padding: 10px 20px; border-radius: 10px;
    cursor: pointer; transition: all .2s; text-decoration: none;
  }
  .hero-btn:hover { background: rgba(255,255,255,0.28); }

  /* SEARCH & FILTER */
  .search-bar {
    display: flex; align-items: center; gap: 14px;
    margin-bottom: 28px;
  }
  .search-input-wrap {
    flex: 1; position: relative;
  }
  .search-input-wrap i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--text-secondary); font-size: 14px; }
  .search-input {
    width: 100%; padding: 11px 14px 11px 42px;
    border: 1.5px solid var(--border); border-radius: 11px;
    font-size: 13px; font-family: 'Plus Jakarta Sans', sans-serif;
    color: var(--text-primary); background: var(--card-bg);
    outline: none; transition: all .2s;
    box-shadow: var(--shadow);
  }
  .search-input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(37,99,235,0.1); }
  .filter-group { display: flex; gap: 8px; }
  .filter-btn {
    padding: 10px 16px; border-radius: 10px;
    font-size: 12px; font-weight: 600;
    border: 1.5px solid var(--border); background: var(--card-bg);
    color: var(--text-secondary); cursor: pointer;
    font-family: 'Plus Jakarta Sans', sans-serif;
    transition: all .2s; display: flex; align-items: center; gap: 6px;
    box-shadow: var(--shadow);
  }
  .filter-btn.active, .filter-btn:hover { background: var(--primary); color: #fff; border-color: var(--primary); }

  /* SECTION TITLE */
  .section-label {
    font-family: 'Space Grotesk', sans-serif; font-size: 18px; font-weight: 700;
    color: var(--text-primary); margin-bottom: 18px;
    display: flex; align-items: center; gap: 10px;
  }
  .section-label i { color: var(--primary); font-size: 16px; }
  .section-label .count { font-size: 12px; font-weight: 600; color: var(--primary); background: rgba(37,99,235,0.1); padding: 3px 10px; border-radius: 20px; }

  /* FACILITY GRID */
  .fac-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 36px; }

  .fac-card {
    background: var(--card-bg);
    border-radius: var(--radius);
    border: 1.5px solid var(--border);
    overflow: hidden;
    transition: all .25s;
    cursor: pointer;
    box-shadow: var(--shadow);
  }
  .fac-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-lg); border-color: transparent; }

  .fac-card-top {
    padding: 22px 20px 18px;
    color: #fff; position: relative; overflow: hidden;
  }
  .fac-card-top::after {
    content: '';
    position: absolute; right: -18px; bottom: -18px;
    width: 80px; height: 80px; border-radius: 50%;
    background: rgba(255,255,255,0.1);
  }
  .fac-card-icon { font-size: 28px; margin-bottom: 12px; display: block; position: relative; z-index: 1; }
  .fac-card-name { font-family: 'Space Grotesk', sans-serif; font-size: 15px; font-weight: 700; position: relative; z-index: 1; margin-bottom: 4px; }
  .fac-card-desc { font-size: 12px; opacity: .8; line-height: 1.5; position: relative; z-index: 1; }

  .fac-card-body { padding: 16px 20px; }

  .fac-detail-row {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 10px;
  }
  .fac-detail-label { font-size: 11px; color: var(--text-secondary); display: flex; align-items: center; gap: 5px; }
  .fac-detail-label i { color: var(--primary); font-size: 10px; }
  .fac-detail-val { font-size: 12px; font-weight: 700; color: var(--text-primary); }

  .fac-price-row {
    display: flex; align-items: center; justify-content: space-between;
    padding-top: 12px;
    border-top: 1px solid var(--border);
    margin-top: 6px;
  }
  .fac-price { font-family: 'Space Grotesk', sans-serif; font-size: 16px; font-weight: 800; color: var(--primary); }
  .fac-price-sub { font-size: 10px; color: var(--text-secondary); }

  .fac-action-btn {
    display: flex; align-items: center; justify-content: center; gap: 6px;
    width: 100%; margin-top: 14px;
    padding: 10px;
    background: linear-gradient(135deg, var(--primary), var(--primary-light));
    color: #fff; border: none; border-radius: 10px;
    font-size: 12px; font-weight: 700;
    font-family: 'Plus Jakarta Sans', sans-serif;
    cursor: pointer; transition: all .2s;
    text-decoration: none;
    box-shadow: 0 3px 10px rgba(37,99,235,0.3);
  }
  .fac-action-btn:hover { transform: translateY(-1px); box-shadow: 0 5px 16px rgba(37,99,235,0.4); }

  /* AVAILABILITY BADGE */
  .avail-badge {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: 10px; font-weight: 700; padding: 3px 9px; border-radius: 6px;
  }
  .avail-badge.available { background: rgba(16,185,129,0.1); color: var(--success); }
  .avail-badge.booked { background: rgba(245,158,11,0.1); color: var(--warning); }

  /* INFO SECTION */
  .info-section {
    background: var(--card-bg);
    border-radius: var(--radius);
    border: 1px solid var(--border);
    box-shadow: var(--shadow);
    overflow: hidden;
    margin-bottom: 28px;
  }
  .info-section-header {
    padding: 20px 28px 16px;
    border-bottom: 1px solid var(--border);
    display: flex; align-items: center; gap: 10px;
  }
  .info-section-title { font-family: 'Space Grotesk', sans-serif; font-size: 16px; font-weight: 700; }
  .info-section-title i { color: var(--primary); }
  .info-section-body { padding: 24px 28px; }

  .step-list { display: flex; flex-direction: column; gap: 16px; }
  .step-item { display: flex; align-items: flex-start; gap: 16px; }
  .step-num {
    width: 32px; height: 32px; border-radius: 50%; flex-shrink: 0;
    background: linear-gradient(135deg, var(--primary), var(--primary-light));
    color: #fff; font-size: 13px; font-weight: 800;
    display: grid; place-items: center;
    box-shadow: 0 3px 10px rgba(37,99,235,0.3);
  }
  .step-text { padding-top: 4px; }
  .step-title { font-size: 13px; font-weight: 700; color: var(--text-primary); margin-bottom: 3px; }
  .step-desc { font-size: 12px; color: var(--text-secondary); line-height: 1.5; }

  .syarat-list { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
  .syarat-item {
    display: flex; align-items: flex-start; gap: 10px;
    background: #f8faff; border-radius: 10px; padding: 12px 14px;
    border: 1px solid #e8eeff;
  }
  .syarat-icon { width: 28px; height: 28px; border-radius: 8px; background: rgba(37,99,235,0.1); color: var(--primary); display: grid; place-items: center; font-size: 12px; flex-shrink: 0; margin-top: 1px; }
  .syarat-text { font-size: 12px; color: var(--text-primary); font-weight: 500; line-height: 1.4; }

  /* ANIMATIONS */
  @keyframes fadeUp { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: translateY(0); } }
  .animate { animation: fadeUp .5s ease both; }
  .d1 { animation-delay: .05s; } .d2 { animation-delay: .1s; } .d3 { animation-delay: .15s; }
  .d4 { animation-delay: .2s; } .d5 { animation-delay: .25s; } .d6 { animation-delay: .3s; }

  ::-webkit-scrollbar { width: 5px; }
  ::-webkit-scrollbar-track { background: transparent; }
  ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
</style>
</head>
<body>

@include('partials.sidebar')

<!-- MAIN -->
<main class="main">
  <!-- TOPBAR -->
  <div class="topbar">
    <div class="topbar-left">
      <div class="breadcrumb">
        <a href="{{ route('tamu.dashboard') }}">Dashboard</a>
        <i class="fas fa-chevron-right" style="font-size:10px"></i>
        <span>Informasi Fasilitas</span>
      </div>
      <div class="topbar-title">Informasi Fasilitas</div>
    </div>
    <div class="topbar-right">
      <div class="notif-btn"><i class="fas fa-bell"></i><div class="notif-dot"></div></div>
    </div>
  </div>

  <!-- HERO -->
  <div class="hero animate d1">
    <div class="hero-blob"></div>
    <div class="hero-left">
      <div class="hero-tag"><i class="fas fa-building"></i> BPMP Provinsi Gorontalo</div>
      <div class="hero-title">Fasilitas Tersedia untuk Dipinjam</div>
      <div class="hero-sub">Temukan fasilitas BPMP yang sesuai kebutuhan Anda. Ajukan permohonan peminjaman dengan mudah dan cepat.</div>
    </div>
    <div class="hero-right">
      <div class="hero-stat">
        <div class="hero-stat-num">6</div>
        <div class="hero-stat-label">Jenis Fasilitas</div>
      </div>
      <a href="{{ route('tamu.peminjaman-aset') }}" class="hero-btn">
        <i class="fas fa-calendar-plus"></i> Ajukan Peminjaman
      </a>
    </div>
  </div>

  <!-- SEARCH & FILTER -->
  <div class="search-bar animate d2">
    <div class="search-input-wrap">
      <i class="fas fa-search"></i>
      <input type="text" class="search-input" id="searchInput" placeholder="Cari fasilitas..." oninput="filterFacilities()">
    </div>
    <div class="filter-group">
      <button class="filter-btn active" onclick="setFilter(this,'all')" id="filter-all"><i class="fas fa-border-all"></i> Semua</button>
      <button class="filter-btn" onclick="setFilter(this,'ruang')" id="filter-ruang"><i class="fas fa-door-open"></i> Ruangan</button>
      <button class="filter-btn" onclick="setFilter(this,'kendaraan')" id="filter-kendaraan"><i class="fas fa-car"></i> Kendaraan</button>
    </div>
  </div>

  <!-- FACILITY GRID -->
  <div class="section-label animate d3">
    <i class="fas fa-building"></i> Daftar Fasilitas
    <span class="count" id="facilityCount">6 Fasilitas</span>
  </div>

  <div class="fac-grid" id="facGrid">
    <!-- Aula -->
    <div class="fac-card animate d3" data-category="ruang" data-name="aula utama bpmp">
      <div class="fac-card-top" style="background:linear-gradient(135deg,#1e3a8a,#2563eb)">
        <i class="fas fa-chalkboard-user fac-card-icon"></i>
        <div class="fac-card-name">Aula Utama BPMP</div>
        <div class="fac-card-desc">Aula berkapasitas besar, dilengkapi AC sentral & sound system profesional</div>
      </div>
      <div class="fac-card-body">
        <div class="fac-detail-row">
          <div class="fac-detail-label"><i class="fas fa-users"></i> Kapasitas</div>
          <div class="fac-detail-val">200 Orang</div>
        </div>
        <div class="fac-detail-row">
          <div class="fac-detail-label"><i class="fas fa-wifi"></i> Fasilitas</div>
          <div class="fac-detail-val">AC, Sound, Proyektor</div>
        </div>
        <div class="fac-detail-row">
          <div class="fac-detail-label"><i class="fas fa-circle-check"></i> Status</div>
          <span class="avail-badge available"><i class="fas fa-circle" style="font-size:6px"></i> Tersedia</span>
        </div>
        <div class="fac-price-row">
          <div>
            <div class="fac-price">Rp 2.500.000</div>
            <div class="fac-price-sub">per hari</div>
          </div>
        </div>
        <a href="{{ route('tamu.peminjaman-aset') }}" class="fac-action-btn">
          <i class="fas fa-calendar-plus"></i> Ajukan Peminjaman
        </a>
      </div>
    </div>

    <!-- Ruang Rapat VIP -->
    <div class="fac-card animate d3" data-category="ruang" data-name="ruang rapat vip">
      <div class="fac-card-top" style="background:linear-gradient(135deg,#5b21b6,#8b5cf6)">
        <i class="fas fa-people-group fac-card-icon"></i>
        <div class="fac-card-name">Ruang Rapat VIP</div>
        <div class="fac-card-desc">Ruangan eksklusif dengan fasilitas video conference & whiteboard digital</div>
      </div>
      <div class="fac-card-body">
        <div class="fac-detail-row">
          <div class="fac-detail-label"><i class="fas fa-users"></i> Kapasitas</div>
          <div class="fac-detail-val">20 Orang</div>
        </div>
        <div class="fac-detail-row">
          <div class="fac-detail-label"><i class="fas fa-wifi"></i> Fasilitas</div>
          <div class="fac-detail-val">VC, Whiteboard, AC</div>
        </div>
        <div class="fac-detail-row">
          <div class="fac-detail-label"><i class="fas fa-circle-check"></i> Status</div>
          <span class="avail-badge available"><i class="fas fa-circle" style="font-size:6px"></i> Tersedia</span>
        </div>
        <div class="fac-price-row">
          <div>
            <div class="fac-price">Rp 1.000.000</div>
            <div class="fac-price-sub">per hari</div>
          </div>
        </div>
        <a href="{{ route('tamu.peminjaman-aset') }}" class="fac-action-btn" style="background:linear-gradient(135deg,#5b21b6,#8b5cf6);box-shadow:0 3px 10px rgba(139,92,246,0.3)">
          <i class="fas fa-calendar-plus"></i> Ajukan Peminjaman
        </a>
      </div>
    </div>

    <!-- Lab Komputer -->
    <div class="fac-card animate d4" data-category="ruang" data-name="lab komputer">
      <div class="fac-card-top" style="background:linear-gradient(135deg,#0e7490,#06b6d4)">
        <i class="fas fa-desktop fac-card-icon"></i>
        <div class="fac-card-name">Lab Komputer</div>
        <div class="fac-card-desc">30 unit komputer terbaru dengan internet fiber, ideal untuk pelatihan IT</div>
      </div>
      <div class="fac-card-body">
        <div class="fac-detail-row">
          <div class="fac-detail-label"><i class="fas fa-computer"></i> Unit PC</div>
          <div class="fac-detail-val">30 Unit</div>
        </div>
        <div class="fac-detail-row">
          <div class="fac-detail-label"><i class="fas fa-wifi"></i> Fasilitas</div>
          <div class="fac-detail-val">Internet, AC, Proyektor</div>
        </div>
        <div class="fac-detail-row">
          <div class="fac-detail-label"><i class="fas fa-circle-check"></i> Status</div>
          <span class="avail-badge booked"><i class="fas fa-circle" style="font-size:6px"></i> Sedang Dipakai</span>
        </div>
        <div class="fac-price-row">
          <div>
            <div class="fac-price">Rp 1.500.000</div>
            <div class="fac-price-sub">per hari</div>
          </div>
        </div>
        <a href="{{ route('tamu.peminjaman-aset') }}" class="fac-action-btn" style="background:linear-gradient(135deg,#0e7490,#06b6d4);box-shadow:0 3px 10px rgba(6,182,212,0.3)">
          <i class="fas fa-calendar-plus"></i> Ajukan Peminjaman
        </a>
      </div>
    </div>

    <!-- Ruang Pelatihan -->
    <div class="fac-card animate d4" data-category="ruang" data-name="ruang pelatihan">
      <div class="fac-card-top" style="background:linear-gradient(135deg,#065f46,#10b981)">
        <i class="fas fa-book-open fac-card-icon"></i>
        <div class="fac-card-name">Ruang Pelatihan A</div>
        <div class="fac-card-desc">Ruang kelas modern dengan kursi ergonomis, AC, dan fasilitas multimedia</div>
      </div>
      <div class="fac-card-body">
        <div class="fac-detail-row">
          <div class="fac-detail-label"><i class="fas fa-users"></i> Kapasitas</div>
          <div class="fac-detail-val">40 Orang</div>
        </div>
        <div class="fac-detail-row">
          <div class="fac-detail-label"><i class="fas fa-wifi"></i> Fasilitas</div>
          <div class="fac-detail-val">Multimedia, AC, Papan</div>
        </div>
        <div class="fac-detail-row">
          <div class="fac-detail-label"><i class="fas fa-circle-check"></i> Status</div>
          <span class="avail-badge available"><i class="fas fa-circle" style="font-size:6px"></i> Tersedia</span>
        </div>
        <div class="fac-price-row">
          <div>
            <div class="fac-price">Rp 800.000</div>
            <div class="fac-price-sub">per hari</div>
          </div>
        </div>
        <a href="{{ route('tamu.peminjaman-aset') }}" class="fac-action-btn" style="background:linear-gradient(135deg,#065f46,#10b981);box-shadow:0 3px 10px rgba(16,185,129,0.3)">
          <i class="fas fa-calendar-plus"></i> Ajukan Peminjaman
        </a>
      </div>
    </div>

    <!-- Kendaraan Minibus -->
    <div class="fac-card animate d5" data-category="kendaraan" data-name="kendaraan minibus">
      <div class="fac-card-top" style="background:linear-gradient(135deg,#92400e,#f59e0b)">
        <i class="fas fa-van-shuttle fac-card-icon"></i>
        <div class="fac-card-name">Kendaraan Minibus</div>
        <div class="fac-card-desc">Toyota HiAce untuk kegiatan dinas dan perjalanan lapangan</div>
      </div>
      <div class="fac-card-body">
        <div class="fac-detail-row">
          <div class="fac-detail-label"><i class="fas fa-person-seat"></i> Penumpang</div>
          <div class="fac-detail-val">16 Orang</div>
        </div>
        <div class="fac-detail-row">
          <div class="fac-detail-label"><i class="fas fa-gas-pump"></i> Bahan Bakar</div>
          <div class="fac-detail-val">Sudah Termasuk</div>
        </div>
        <div class="fac-detail-row">
          <div class="fac-detail-label"><i class="fas fa-circle-check"></i> Status</div>
          <span class="avail-badge available"><i class="fas fa-circle" style="font-size:6px"></i> Tersedia</span>
        </div>
        <div class="fac-price-row">
          <div>
            <div class="fac-price">Rp 750.000</div>
            <div class="fac-price-sub">per hari</div>
          </div>
        </div>
        <a href="{{ route('tamu.peminjaman-aset') }}" class="fac-action-btn" style="background:linear-gradient(135deg,#92400e,#d97706);box-shadow:0 3px 10px rgba(245,158,11,0.3)">
          <i class="fas fa-calendar-plus"></i> Ajukan Peminjaman
        </a>
      </div>
    </div>

    <!-- Gedung Serbaguna -->
    <div class="fac-card animate d5" data-category="ruang" data-name="gedung serbaguna">
      <div class="fac-card-top" style="background:linear-gradient(135deg,#9f1239,#f43f5e)">
        <i class="fas fa-house fac-card-icon"></i>
        <div class="fac-card-name">Gedung Serbaguna</div>
        <div class="fac-card-desc">Area 500m² untuk pameran, bazar, acara outdoor skala besar</div>
      </div>
      <div class="fac-card-body">
        <div class="fac-detail-row">
          <div class="fac-detail-label"><i class="fas fa-users"></i> Kapasitas</div>
          <div class="fac-detail-val">300 Orang</div>
        </div>
        <div class="fac-detail-row">
          <div class="fac-detail-label"><i class="fas fa-ruler-combined"></i> Luas Area</div>
          <div class="fac-detail-val">500 m²</div>
        </div>
        <div class="fac-detail-row">
          <div class="fac-detail-label"><i class="fas fa-circle-check"></i> Status</div>
          <span class="avail-badge available"><i class="fas fa-circle" style="font-size:6px"></i> Tersedia</span>
        </div>
        <div class="fac-price-row">
          <div>
            <div class="fac-price">Rp 3.000.000</div>
            <div class="fac-price-sub">per hari</div>
          </div>
        </div>
        <a href="{{ route('tamu.peminjaman-aset') }}" class="fac-action-btn" style="background:linear-gradient(135deg,#9f1239,#e11d48);box-shadow:0 3px 10px rgba(244,63,94,0.3)">
          <i class="fas fa-calendar-plus"></i> Ajukan Peminjaman
        </a>
      </div>
    </div>
  </div>

  <!-- PROSEDUR PEMINJAMAN -->
  <div class="info-section animate d5">
    <div class="info-section-header">
      <div class="info-section-title"><i class="fas fa-list-ol"></i> Prosedur Peminjaman</div>
    </div>
    <div class="info-section-body">
      <div class="step-list">
        <div class="step-item">
          <div class="step-num">1</div>
          <div class="step-text">
            <div class="step-title">Pilih Fasilitas</div>
            <div class="step-desc">Pilih fasilitas yang ingin dipinjam dan periksa ketersediaannya sesuai tanggal yang diinginkan.</div>
          </div>
        </div>
        <div class="step-item">
          <div class="step-num">2</div>
          <div class="step-text">
            <div class="step-title">Isi Formulir Peminjaman</div>
            <div class="step-desc">Lengkapi data diri, instansi, tujuan penggunaan, dan rentang tanggal peminjaman.</div>
          </div>
        </div>
        <div class="step-item">
          <div class="step-num">3</div>
          <div class="step-text">
            <div class="step-title">Tunggu Persetujuan</div>
            <div class="step-desc">Permohonan akan ditinjau oleh admin BPMP. Notifikasi persetujuan dikirim dalam 1×24 jam kerja.</div>
          </div>
        </div>
        <div class="step-item">
          <div class="step-num">4</div>
          <div class="step-text">
            <div class="step-title">Gunakan Fasilitas</div>
            <div class="step-desc">Setelah disetujui, tunjukkan bukti persetujuan kepada petugas dan gunakan fasilitas sesuai waktu yang disepakati.</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- SYARAT & KETENTUAN -->
  <div class="info-section animate d6">
    <div class="info-section-header">
      <div class="info-section-title"><i class="fas fa-shield-halved"></i> Syarat & Ketentuan</div>
    </div>
    <div class="info-section-body">
      <div class="syarat-list">
        <div class="syarat-item">
          <div class="syarat-icon"><i class="fas fa-id-card"></i></div>
          <div class="syarat-text">Peminjam wajib memiliki akun terdaftar dan terverifikasi di sistem SIBMN</div>
        </div>
        <div class="syarat-item">
          <div class="syarat-icon"><i class="fas fa-file-signature"></i></div>
          <div class="syarat-text">Mengisi surat permohonan peminjaman dengan lengkap dan benar</div>
        </div>
        <div class="syarat-item">
          <div class="syarat-icon"><i class="fas fa-calendar-days"></i></div>
          <div class="syarat-text">Pengajuan dilakukan minimal 3 hari kerja sebelum tanggal penggunaan</div>
        </div>
        <div class="syarat-item">
          <div class="syarat-icon"><i class="fas fa-hand-holding"></i></div>
          <div class="syarat-text">Bertanggung jawab penuh atas fasilitas selama masa peminjaman</div>
        </div>
        <div class="syarat-item">
          <div class="syarat-icon"><i class="fas fa-ban"></i></div>
          <div class="syarat-text">Dilarang memindahtangankan fasilitas kepada pihak ketiga tanpa izin</div>
        </div>
        <div class="syarat-item">
          <div class="syarat-icon"><i class="fas fa-clock-rotate-left"></i></div>
          <div class="syarat-text">Fasilitas dikembalikan dalam kondisi baik dan tepat waktu sesuai perjanjian</div>
        </div>
      </div>
    </div>
  </div>

</main>

<script>
  let currentFilter = 'all';

  function setFilter(el, filter) {
    currentFilter = filter;
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    el.classList.add('active');
    filterFacilities();
  }

  function filterFacilities() {
    const q = document.getElementById('searchInput').value.toLowerCase();
    const cards = document.querySelectorAll('.fac-card');
    let visible = 0;
    cards.forEach(card => {
      const cat = card.dataset.category;
      const name = card.dataset.name;
      const matchFilter = currentFilter === 'all' || cat === currentFilter;
      const matchSearch = name.includes(q);
      if (matchFilter && matchSearch) {
        card.style.display = '';
        visible++;
      } else {
        card.style.display = 'none';
      }
    });
    document.getElementById('facilityCount').textContent = visible + ' Fasilitas';
  }
</script>

</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SIPANDU - Informasi Fasilitas</title>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
  :root {
    --primary: #1a56db;
    --primary-light: #3b82f6;
    --primary-dark: #1240a8;
    --accent: #06b6d4;
    --accent2: #7c3aed;
    --success: #059669;
    --warning: #d97706;
    --danger: #dc2626;
    --bg: #f1f5fb;
    --card-bg: #ffffff;
    --text-primary: #0d1526;
    --text-secondary: #5b6f8f;
    --border: #dce4f0;
    --radius: 18px;
    --shadow: 0 2px 16px rgba(26,86,219,0.07);
    --shadow-lg: 0 10px 48px rgba(26,86,219,0.15);
  }

  * { margin: 0; padding: 0; box-sizing: border-box; }

  body {
    font-family: 'DM Sans', sans-serif;
    background: var(--bg);
    color: var(--text-primary);
    min-height: 100vh;
  }

  /* LAYOUT */
  .page-wrap { margin-left: 256px; flex: 1; padding: 0 32px 32px; }

  /* TOPBAR */
  .topbar {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 28px;
  }
  .breadcrumb { font-size: 12.5px; color: var(--text-secondary); display: flex; align-items: center; gap: 6px; margin-bottom: 5px; }
  .breadcrumb a { color: var(--text-secondary); text-decoration: none; transition: color .2s; }
  .breadcrumb a:hover { color: var(--primary); }
  .breadcrumb .sep { opacity: 0.5; font-size: 10px; }
  .breadcrumb .current { color: var(--primary); font-weight: 600; }
  .page-title { font-family: 'Outfit', sans-serif; font-size: 24px; font-weight: 800; letter-spacing: -0.5px; }
  .topbar-actions { display: flex; gap: 10px; align-items: center; }
  .icon-btn {
    width: 42px; height: 42px;
    background: var(--card-bg); border: 1.5px solid var(--border);
    border-radius: 12px; display: grid; place-items: center;
    cursor: pointer; color: var(--text-secondary); transition: all .2s;
    position: relative; text-decoration: none;
  }
  .icon-btn:hover { border-color: var(--primary); color: var(--primary); transform: translateY(-1px); }
  .notif-dot { position: absolute; top: 9px; right: 9px; width: 7px; height: 7px; background: var(--danger); border-radius: 50%; border: 2px solid var(--card-bg); }

  /* HERO */
  .hero {
    border-radius: 22px;
    padding: 36px 40px;
    background: linear-gradient(130deg, #0d1d4e 0%, #1a56db 50%, #0891b2 100%);
    position: relative; overflow: hidden;
    margin-bottom: 32px;
    box-shadow: 0 12px 48px rgba(26,86,219,0.32);
    display: flex; align-items: center; justify-content: space-between; gap: 24px;
  }
  .hero::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(circle at 75% 50%, rgba(6,182,212,0.2) 0%, transparent 60%),
                url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M0 0h40v40H0zM40 40h40v40H40z'/%3E%3C/g%3E%3C/svg%3E");
    pointer-events: none;
  }
  .hero-orb {
    position: absolute; border-radius: 50%; pointer-events: none;
  }
  .hero-orb-1 { width: 300px; height: 300px; background: rgba(255,255,255,0.04); right: -80px; top: -100px; }
  .hero-orb-2 { width: 180px; height: 180px; background: rgba(6,182,212,0.12); right: 120px; bottom: -60px; }

  .hero-left { position: relative; z-index: 2; }
  .hero-tag {
    display: inline-flex; align-items: center; gap: 7px;
    background: rgba(255,255,255,0.12); backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.2); color: rgba(255,255,255,0.9);
    font-size: 11.5px; font-weight: 600; padding: 5px 14px; border-radius: 30px;
    margin-bottom: 14px; letter-spacing: 0.3px;
  }
  .hero-title { font-family: 'Outfit', sans-serif; font-size: 28px; font-weight: 800; color: #fff; margin-bottom: 10px; letter-spacing: -0.5px; line-height: 1.2; }
  .hero-sub { font-size: 14px; color: rgba(255,255,255,0.72); max-width: 440px; line-height: 1.65; }
  .hero-cta {
    display: inline-flex; align-items: center; gap: 8px; margin-top: 18px;
    background: #fff; color: var(--primary);
    font-size: 13px; font-weight: 700; padding: 10px 22px;
    border-radius: 11px; text-decoration: none; transition: all .2s;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
  }
  .hero-cta:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(0,0,0,0.2); }

  .hero-right { position: relative; z-index: 2; display: flex; gap: 20px; }
  .hero-stat-card {
    background: rgba(255,255,255,0.12); backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.18); border-radius: 16px;
    padding: 18px 24px; text-align: center; min-width: 100px;
  }
  .hero-stat-num { font-family: 'Outfit', sans-serif; font-size: 36px; font-weight: 900; color: #fff; line-height: 1; }
  .hero-stat-label { font-size: 11.5px; color: rgba(255,255,255,0.65); margin-top: 5px; font-weight: 500; }

  /* SEARCH & FILTER */
  .toolbar {
    display: flex; align-items: center; gap: 12px;
    margin-bottom: 28px; flex-wrap: wrap;
  }
  .search-wrap { flex: 1; min-width: 220px; position: relative; }
  .search-wrap i { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-secondary); font-size: 13px; }
  .search-input {
    width: 100%; padding: 12px 14px 12px 44px;
    border: 1.5px solid var(--border); border-radius: 12px;
    font-size: 13px; font-family: 'DM Sans', sans-serif;
    color: var(--text-primary); background: var(--card-bg);
    outline: none; transition: all .2s;
    box-shadow: var(--shadow);
  }
  .search-input:focus { border-color: var(--primary); box-shadow: 0 0 0 4px rgba(26,86,219,0.08); }
  .filter-tabs { display: flex; gap: 6px; }
  .ftab {
    padding: 10px 18px; border-radius: 10px;
    font-size: 12.5px; font-weight: 600;
    border: 1.5px solid var(--border); background: var(--card-bg);
    color: var(--text-secondary); cursor: pointer;
    font-family: 'DM Sans', sans-serif;
    transition: all .2s; display: flex; align-items: center; gap: 7px;
    box-shadow: var(--shadow);
  }
  .ftab:hover { border-color: var(--primary); color: var(--primary); }
  .ftab.active { background: var(--primary); color: #fff; border-color: var(--primary); box-shadow: 0 4px 14px rgba(26,86,219,0.3); }

  /* SECTION HEADER */
  .sec-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
  .sec-title { font-family: 'Outfit', sans-serif; font-size: 19px; font-weight: 800; display: flex; align-items: center; gap: 10px; letter-spacing: -0.3px; }
  .sec-title i { color: var(--primary); font-size: 17px; }
  .fac-count { font-size: 11.5px; font-weight: 700; color: var(--primary); background: rgba(26,86,219,0.1); padding: 4px 12px; border-radius: 20px; }

  /* FACILITY GRID */
  .fac-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 22px; margin-bottom: 40px; }

  /* FACILITY CARD */
  .fac-card {
    background: var(--card-bg);
    border-radius: var(--radius);
    border: 1.5px solid var(--border);
    overflow: hidden;
    transition: all .3s cubic-bezier(.34,1.2,.64,1);
    cursor: default;
    box-shadow: var(--shadow);
    display: flex; flex-direction: column;
  }
  .fac-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-lg); border-color: rgba(26,86,219,0.2); }

  /* IMAGE SLIDER */
  .slider-wrap { position: relative; height: 200px; overflow: hidden; flex-shrink: 0; }
  .slider-track { display: flex; height: 100%; transition: transform .45s cubic-bezier(.4,0,.2,1); }
  .slide-img {
    min-width: 100%; height: 100%;
    object-fit: cover; flex-shrink: 0;
    background-size: cover; background-position: center;
  }
  /* Gradient overlay for text on image */
  .slider-overlay {
    position: absolute; inset: 0; pointer-events: none;
    background: linear-gradient(to top, rgba(0,0,0,0.65) 0%, rgba(0,0,0,0.15) 50%, transparent 100%);
  }
  /* Slide controls */
  .slide-prev, .slide-next {
    position: absolute; top: 50%; transform: translateY(-50%);
    width: 30px; height: 30px; border-radius: 50%;
    background: rgba(255,255,255,0.9); border: none;
    display: grid; place-items: center; cursor: pointer;
    font-size: 11px; color: var(--text-primary);
    transition: all .2s; z-index: 5;
    opacity: 0;
  }
  .fac-card:hover .slide-prev,
  .fac-card:hover .slide-next { opacity: 1; }
  .slide-prev { left: 10px; }
  .slide-next { right: 10px; }
  .slide-prev:hover, .slide-next:hover { background: #fff; box-shadow: 0 3px 12px rgba(0,0,0,0.2); transform: translateY(-50%) scale(1.1); }

  /* Dots */
  .slide-dots { position: absolute; bottom: 10px; left: 50%; transform: translateX(-50%); display: flex; gap: 5px; z-index: 5; }
  .dot { width: 6px; height: 6px; border-radius: 50%; background: rgba(255,255,255,0.55); transition: all .3s; cursor: pointer; }
  .dot.active { background: #fff; width: 18px; border-radius: 4px; }

  /* Status badge on image */
  .slide-status {
    position: absolute; top: 12px; right: 12px; z-index: 5;
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 10.5px; font-weight: 700; padding: 4px 10px; border-radius: 8px;
    backdrop-filter: blur(8px);
  }
  .slide-status.available { background: rgba(5,150,105,0.85); color: #fff; }
  .slide-status.booked { background: rgba(217,119,6,0.85); color: #fff; }
  .slide-status i { font-size: 7px; }

  /* Image counter */
  .img-counter {
    position: absolute; top: 12px; left: 12px; z-index: 5;
    background: rgba(0,0,0,0.45); backdrop-filter: blur(6px);
    color: #fff; font-size: 10px; font-weight: 600;
    padding: 3px 9px; border-radius: 6px;
  }

  /* Card title on image */
  .card-img-title { position: absolute; bottom: 0; left: 0; right: 0; z-index: 5; padding: 12px 16px 14px; }
  .card-img-name { font-family: 'Outfit', sans-serif; font-size: 15px; font-weight: 800; color: #fff; margin-bottom: 2px; }
  .card-img-cat { font-size: 11px; color: rgba(255,255,255,0.75); display: flex; align-items: center; gap: 5px; }

  /* Card Body */
  .card-body { padding: 16px 18px 18px; flex: 1; display: flex; flex-direction: column; gap: 12px; }

  /* Price + availability row */
  .price-avail-row { display: flex; align-items: flex-start; justify-content: space-between; }
  .price-block {}
  .price-label { font-size: 10px; color: var(--text-secondary); font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px; }
  .price-value { font-family: 'Outfit', sans-serif; font-size: 20px; font-weight: 900; color: var(--primary); letter-spacing: -0.5px; }
  .price-unit { font-size: 11px; color: var(--text-secondary); font-weight: 400; }
  .avail-block { text-align: right; }
  .avail-label { font-size: 10px; color: var(--text-secondary); font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
  .avail-badge {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 7px;
  }
  .avail-badge.available { background: rgba(5,150,105,0.1); color: var(--success); border: 1px solid rgba(5,150,105,0.2); }
  .avail-badge.booked { background: rgba(217,119,6,0.1); color: var(--warning); border: 1px solid rgba(217,119,6,0.2); }
  .avail-badge .pulse { width: 7px; height: 7px; border-radius: 50%; }
  .avail-badge.available .pulse { background: var(--success); animation: blink 1.5s infinite; }
  .avail-badge.booked .pulse { background: var(--warning); }
  @keyframes blink { 0%,100%{opacity:1} 50%{opacity:0.3} }

  /* Divider */
  .card-divider { height: 1px; background: var(--border); }

  /* Detail rows */
  .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
  .detail-item { background: #f7f9fd; border-radius: 10px; padding: 9px 12px; border: 1px solid #eaf0fb; }
  .detail-key { font-size: 10px; color: var(--text-secondary); font-weight: 500; margin-bottom: 3px; display: flex; align-items: center; gap: 5px; }
  .detail-key i { color: var(--primary); font-size: 9px; }
  .detail-val { font-size: 12px; font-weight: 700; color: var(--text-primary); }

  /* Facilities tags */
  .fac-tags { display: flex; flex-wrap: wrap; gap: 5px; }
  .fac-tag {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: 10.5px; font-weight: 600; padding: 3px 9px;
    border-radius: 6px; background: rgba(26,86,219,0.07); color: var(--primary);
    border: 1px solid rgba(26,86,219,0.15);
  }
  .fac-tag i { font-size: 9px; }

  /* Action button */
  .action-btn {
    display: flex; align-items: center; justify-content: center; gap: 7px;
    width: 100%; padding: 11px;
    background: linear-gradient(135deg, var(--primary-dark), var(--primary-light));
    color: #fff; border: none; border-radius: 11px;
    font-size: 12.5px; font-weight: 700;
    font-family: 'DM Sans', sans-serif;
    cursor: pointer; transition: all .25s;
    text-decoration: none;
    box-shadow: 0 4px 14px rgba(26,86,219,0.28);
    margin-top: auto;
  }
  .action-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(26,86,219,0.38); }
  .action-btn.booked-btn { background: linear-gradient(135deg, #92400e, #d97706); box-shadow: 0 4px 14px rgba(217,119,6,0.3); }
  .action-btn.booked-btn:hover { box-shadow: 0 8px 24px rgba(217,119,6,0.4); }

  /* ── INFO SECTIONS ── */
  .info-section {
    background: var(--card-bg);
    border-radius: var(--radius);
    border: 1.5px solid var(--border);
    box-shadow: var(--shadow);
    overflow: hidden;
    margin-bottom: 24px;
  }
  .info-header {
    padding: 18px 26px 16px;
    border-bottom: 1.5px solid var(--border);
    display: flex; align-items: center; gap: 10px;
    background: #fafcff;
  }
  .info-header-icon {
    width: 36px; height: 36px; border-radius: 10px;
    background: rgba(26,86,219,0.1); color: var(--primary);
    display: grid; place-items: center; font-size: 15px;
  }
  .info-title { font-family: 'Outfit', sans-serif; font-size: 16px; font-weight: 800; letter-spacing: -0.3px; }
  .info-body { padding: 26px; }

  /* Steps */
  .step-list { display: flex; flex-direction: column; gap: 0; }
  .step-item { display: flex; align-items: flex-start; gap: 18px; position: relative; padding-bottom: 24px; }
  .step-item:last-child { padding-bottom: 0; }
  .step-item::before {
    content: ''; position: absolute;
    left: 19px; top: 40px; bottom: 0; width: 2px;
    background: linear-gradient(to bottom, rgba(26,86,219,0.3), transparent);
  }
  .step-item:last-child::before { display: none; }
  .step-num {
    width: 40px; height: 40px; border-radius: 50%; flex-shrink: 0;
    background: linear-gradient(135deg, var(--primary-dark), var(--primary-light));
    color: #fff; font-family: 'Outfit', sans-serif; font-size: 15px; font-weight: 800;
    display: grid; place-items: center;
    box-shadow: 0 4px 14px rgba(26,86,219,0.3); z-index: 1;
  }
  .step-content { padding-top: 7px; }
  .step-title { font-size: 14px; font-weight: 700; color: var(--text-primary); margin-bottom: 4px; }
  .step-desc { font-size: 12.5px; color: var(--text-secondary); line-height: 1.6; }

  /* Syarat grid */
  .syarat-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
  .syarat-card {
    display: flex; align-items: flex-start; gap: 12px;
    background: #f7f9fd; border-radius: 12px; padding: 14px 16px;
    border: 1.5px solid #eaf0fb; transition: all .2s;
  }
  .syarat-card:hover { border-color: rgba(26,86,219,0.25); background: #f0f5ff; }
  .syarat-icon { width: 34px; height: 34px; border-radius: 9px; background: rgba(26,86,219,0.1); color: var(--primary); display: grid; place-items: center; font-size: 13px; flex-shrink: 0; }
  .syarat-text { font-size: 12.5px; color: var(--text-primary); font-weight: 500; line-height: 1.5; padding-top: 3px; }

  /* Animations */
  @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
  .fade-up { animation: fadeUp .5s ease both; }
  .d1{animation-delay:.05s}.d2{animation-delay:.1s}.d3{animation-delay:.15s}
  .d4{animation-delay:.2s}.d5{animation-delay:.25s}.d6{animation-delay:.3s}
  .d7{animation-delay:.35s}.d8{animation-delay:.4s}

  ::-webkit-scrollbar{width:5px}
  ::-webkit-scrollbar-track{background:transparent}
  ::-webkit-scrollbar-thumb{background:#c8d5e8;border-radius:10px}

  @media(max-width:900px){
    .fac-grid{grid-template-columns:repeat(2,1fr)}
    .hero-right{display:none}
  }
  @media(max-width:600px){
    .fac-grid{grid-template-columns:1fr}
    .syarat-grid{grid-template-columns:1fr}
    .detail-grid{grid-template-columns:1fr}
    .page-wrap{padding:20px 14px 40px}
    .hero{padding:24px 20px}
    .hero-title{font-size:20px}
  }
</style>
</head>
<body>

@include('partials.sidebar')

<div class="page-wrap">
    <!-- TOPBAR -->
    <div class="topbar fade-up d1">
        <div>
            <div class="breadcrumb">
                {{-- <a href="{{ route('dashboard') }}">Dashboard</a> --}}
                <span class="sep"><i class="fas fa-chevron-right"></i></span>
                <span class="current">Informasi Fasilitas</span>
            </div>
            <div class="page-title">Informasi Fasilitas</div>
        </div>
        <div class="topbar-actions">
            <a href="#" class="icon-btn"><i class="fas fa-bell"></i><div class="notif-dot"></div></a>
            <a href="{{ route('adminsarpras.data-gedung.store') }}" class="icon-btn" style="width:auto;padding:0 16px;gap:8px;font-size:13px;font-weight:700;color:var(--primary)">
                <i class="fas fa-plus"></i> Tambah
            </a>
        </div>
    </div>

    <!-- HERO -->
    <div class="hero fade-up d2">
        <div class="hero-orb hero-orb-1"></div>
        <div class="hero-orb hero-orb-2"></div>
        <div class="hero-left">
            <div class="hero-tag"><i class="fas fa-building"></i> BPMP Provinsi Gorontalo</div>
            <div class="hero-title">Fasilitas Tersedia<br>untuk Dipinjam</div>
            <div class="hero-sub">Temukan fasilitas BPMP yang sesuai kebutuhan Anda. Ajukan permohonan peminjaman dengan mudah dan cepat.</div>
            <a href="#" class="hero-cta"><i class="fas fa-calendar-plus"></i> Ajukan Peminjaman Sekarang</a>
        </div>
        <div class="hero-right">
            <div class="hero-stat-card">
                <div class="hero-stat-num">{{ $totalGedung }}</div>
                <div class="hero-stat-label">Jenis Fasilitas</div>
            </div>
            <div class="hero-stat-card">
                <div class="hero-stat-num" style="color:#6ee7b7">{{ $tersedia }}</div>
                <div class="hero-stat-label">Tersedia Kini</div>
            </div>
        </div>
    </div>

    <!-- SEARCH & FILTER -->
    <form method="GET" action="{{ route('adminsarpras.data-gedung') }}" class="toolbar fade-up d3">
        <div class="search-wrap">
            <i class="fas fa-search"></i>
            <input type="text" class="search-input" name="search" id="searchInput" 
                   placeholder="Cari fasilitas..." value="{{ request('search') }}" oninput="filterFacilities()">
        </div>
        <div class="filter-tabs">
            <a href="{{ route('adminsarpras.data-gedung') }}" class="ftab {{ request('kategori', 'all') == 'all' ? 'active' : '' }}">
                <i class="fas fa-border-all"></i> Semua
            </a>
            <a href="{{ route('adminsarpras.data-gedung', ['kategori' => 'ruang']) }}" 
               class="ftab {{ request('kategori') == 'ruang' ? 'active' : '' }}">
                <i class="fas fa-door-open"></i> Ruangan
            </a>
            <a href="{{ route('adminsarpras.data-gedung', ['kategori' => 'mess']) }}" 
               class="ftab {{ request('kategori') == 'mess' ? 'active' : '' }}">
                <i class="fas fa-bed"></i> Mess
            </a>
            <a href="{{ route('adminsarpras.data-gedung', ['kategori' => 'asrama']) }}" 
               class="ftab {{ request('kategori') == 'asrama' ? 'active' : '' }}">
                <i class="fas fa-home"></i> Asrama
            </a>
        </div>
    </form>

    <!-- SECTION HEADER -->
    <div class="sec-header fade-up d3">
        <div class="sec-title"><i class="fas fa-building"></i> Daftar Fasilitas</div>
        <div class="fac-count" id="facCount">{{ $gedungs->count() }} Fasilitas</div>
    </div>

    <!-- FACILITY GRID -->
    <div class="fac-grid" id="facGrid">
        @forelse($gedungs as $index => $gedung)
            <div class="fac-card fade-up {{ 'd' . (($index % 8) + 1) }}" 
                 data-category="{{ $gedung->kategori }}" 
                 data-name="{{ strtolower($gedung->nama_gedung) }}">
                
                <!-- SLIDER - Gunakan foto pertama atau placeholder -->
                <div class="slider-wrap" data-slider="{{ $gedung->id }}">
                    <div class="slider-track">
                        {{-- Jika ada foto --}}
                        @if($gedung->foto_url)
                            <div class="slide-img" style="background-image: url('{{ asset('storage/' . $gedung->foto_url) }}');"></div>
                        @else
                            {{-- Placeholder berdasarkan kategori --}}
                            <div class="slide-img" style="background: linear-gradient(135deg, var(--primary-dark), var(--primary));"></div>
                        @endif
                        {{-- Tambahan slide placeholder --}}
                        <div class="slide-img" style="background: linear-gradient(135deg, var(--primary), var(--accent));"></div>
                    </div>
                    <div class="slider-overlay"></div>
                    <span class="slide-status {{ $gedung->status_class }}">
                        <i class="fas fa-circle"></i> {{ $gedung->ketersediaan }}
                    </span>
                    <div class="img-counter" id="counter-{{ $gedung->id }}">1 / 2</div>
                    <button class="slide-prev" onclick="slideCard({{ $gedung->id }},-1)"><i class="fas fa-chevron-left"></i></button>
                    <button class="slide-next" onclick="slideCard({{ $gedung->id }},1)"><i class="fas fa-chevron-right"></i></button>
                    <div class="slide-dots" id="dots-{{ $gedung->id }}">
                        <div class="dot active" onclick="goSlide({{ $gedung->id }},0)"></div>
                        <div class="dot" onclick="goSlide({{ $gedung->id }},1)"></div>
                    </div>
                    <div class="card-img-title">
                        <div class="card-img-name">{{ $gedung->nama_gedung }}</div>
                        <div class="card-img-cat">
                            <i class="fas fa-{{ $gedung->kategori == 'ruang' ? 'door-open' : ($gedung->kategori == 'mess' ? 'bed' : 'home') }}"></i> 
                            {{ ucfirst($gedung->kategori ?? 'Fasilitas') }}
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="price-avail-row">
                        <div class="price-block">
                            <div class="price-label">Tarif Sewa</div>
                            <div class="price-value">{{ $gedung->tarif_sewa_format }} 
                                <span class="price-unit">/ hari</span>
                            </div>
                        </div>
                        <div class="avail-block">
                            <div class="avail-label">Ketersediaan</div>
                            <span class="avail-badge {{ $gedung->status_class }}">
                                <div class="pulse"></div> {{ $gedung->ketersediaan }}
                            </span>
                        </div>
                    </div>
                    <div class="card-divider"></div>
                    <div class="detail-grid">
                        <div class="detail-item">
                            <div class="detail-key"><i class="fas fa-users"></i> Kapasitas</div>
                            <div class="detail-val">{{ number_format($gedung->kapasitas) }} Orang</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-key"><i class="fas fa-ruler-combined"></i> Luas Bangunan</div>
                            <div class="detail-val">{{ number_format((float)$gedung->luas_bangunan, 2) }} m²</div>
                        </div>
                        @if($gedung->jadwal_pemakaian)
                        <div class="detail-item">
                            <div class="detail-key"><i class="fas fa-calendar"></i> Jadwal</div>
                            <div class="detail-val">{{ $gedung->jadwal_pemakaian }}</div>
                        </div>
                        @endif
                    </div>
                    <div>
                        <div class="detail-key" style="margin-bottom:8px;font-size:11px;">
                            <i class="fas fa-star" style="color:var(--primary);font-size:9px"></i> Fasilitas
                        </div>
                        <div class="fac-tags">
                            @foreach(explode(',', $gedung->fasilitas) as $fasilitas)
                                @if(trim($fasilitas))
                                    <span class="fac-tag">
                                        <i class="fas fa-{{ strtolower(trim($fasilitas)) }}"></i> 
                                        {{ trim($fasilitas) }}
                                    </span>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <a href="{{ route('adminsarpras.data-gedung.show', $gedung->id) }}" class="action-btn">
                        <i class="fas fa-calendar-plus"></i> Ajukan Peminjaman
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <i class="fas fa-building fa-4x text-gray-300 mb-4"></i>
                <h3 class="text-xl font-bold text-gray-500 mb-2">Belum ada data fasilitas</h3>
                <p class="text-gray-400 mb-6">Silakan tambahkan fasilitas terlebih dahulu melalui menu admin.</p>
                <a href="{{ route('adminsarpras.data-gedung.store') }}" class="action-btn inline-flex">
                    <i class="fas fa-plus"></i> Tambah Fasilitas Pertama
                </a>
            </div>
        @endforelse
    </div>

    <!-- Include bagian prosedur dan syarat seperti sebelumnya -->
</div>

{{-- JavaScript sama seperti sebelumnya, tapi update ID slider --}}
<script>
    const sliderState = {};
    
    function initSliders() {
        document.querySelectorAll('[data-slider]').forEach(wrap => {
            const id = wrap.dataset.slider;
            sliderState[id] = { current: 0, total: wrap.querySelectorAll('.slide-img').length };
        });
    }

    // Update fungsi slideCard dan goSlide untuk menggunakan ID gedung
    function goSlide(id, idx) {
        const wrap = document.querySelector(`[data-slider="${id}"]`);
        if (!wrap) return;
        
        const track = wrap.querySelector('.slider-track');
        const total = sliderState[id].total;
        sliderState[id].current = (idx + total) % total;
        const cur = sliderState[id].current;
        track.style.transform = `translateX(-${cur * 100}%)`;
        
        const dots = document.querySelectorAll(`#dots-${id} .dot`);
        dots.forEach((d, i) => d.classList.toggle('active', i === cur));
        document.getElementById(`counter-${id}`).textContent = `${cur + 1} / ${total}`;
    }

    function slideCard(id, dir) {
        const cur = sliderState[id].current;
        goSlide(id, cur + dir);
    }

    // Filter client-side
    function filterFacilities() {
        const q = document.getElementById('searchInput').value.toLowerCase();
        let visible = 0;
        document.querySelectorAll('.fac-card').forEach(card => {
            const cat = card.dataset.category;
            const name = card.dataset.name;
            const matchSearch = name.includes(q);
            card.style.display = matchSearch ? '' : 'none';
            if (matchSearch) visible++;
        });
        document.getElementById('facCount').textContent = visible + ' Fasilitas';
    }

    // Init
    initSliders();
</script>
</body>
</html>

<script>
  // ── SLIDER STATE ──
  const sliderState = {};

  function initSliders() {
    document.querySelectorAll('[data-slider]').forEach(wrap => {
      const id = parseInt(wrap.dataset.slider);
      sliderState[id] = { current: 0, total: wrap.querySelectorAll('.slide-img').length };
    });
  }

  function goSlide(id, idx) {
    const wrap = document.querySelector(`[data-slider="${id}"]`);
    const track = wrap.querySelector('.slider-track');
    const total = sliderState[id].total;
    sliderState[id].current = (idx + total) % total;
    const cur = sliderState[id].current;
    track.style.transform = `translateX(-${cur * 100}%)`;
    // Update dots
    const dots = document.querySelectorAll(`#dots-${id} .dot`);
    dots.forEach((d, i) => d.classList.toggle('active', i === cur));
    // Update counter
    document.getElementById(`counter-${id}`).textContent = `${cur + 1} / ${total}`;
  }

  function slideCard(id, dir) {
    const cur = sliderState[id].current;
    goSlide(id, cur + dir);
  }

  // Auto-slide every 4s
  function startAutoSlide() {
    setInterval(() => {
      Object.keys(sliderState).forEach(id => {
        const card = document.querySelector(`[data-slider="${id}"]`).closest('.fac-card');
        if (card && !card.matches(':hover')) {
          slideCard(parseInt(id), 1);
        }
      });
    }, 4000);
  }

  // Touch/swipe support
  function initSwipe() {
    document.querySelectorAll('[data-slider]').forEach(wrap => {
      const id = parseInt(wrap.dataset.slider);
      let startX = 0;
      wrap.addEventListener('touchstart', e => { startX = e.touches[0].clientX; }, {passive:true});
      wrap.addEventListener('touchend', e => {
        const dx = e.changedTouches[0].clientX - startX;
        if (Math.abs(dx) > 40) slideCard(id, dx < 0 ? 1 : -1);
      }, {passive:true});
    });
  }

  // ── FILTER ──
  let currentFilter = 'all';

  function setFilter(el, filter) {
    currentFilter = filter;
    document.querySelectorAll('.ftab').forEach(b => b.classList.remove('active'));
    el.classList.add('active');
    filterFacilities();
  }

  function filterFacilities() {
    const q = document.getElementById('searchInput').value.toLowerCase();
    let visible = 0;
    document.querySelectorAll('.fac-card').forEach(card => {
      const cat = card.dataset.category;
      const name = card.dataset.name;
      const matchFilter = currentFilter === 'all' || cat === currentFilter;
      const matchSearch = name.includes(q);
      const show = matchFilter && matchSearch;
      card.style.display = show ? '' : 'none';
      if (show) visible++;
    });
    document.getElementById('facCount').textContent = visible + ' Fasilitas';
  }

  // Init
  initSliders();
  startAutoSlide();
  initSwipe();
</script>
</body>
</html>
